<?php

namespace App\Services\Ticket;

use App\Enums\TicketFileType;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\TicketFile;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class TicketPdfService
{
    public function generate(Ticket $ticket): TicketFile
    {
        $ticket->loadMissing([
            'event.settings',
            'family.members',
        ]);

        $this->deleteExistingPdfFiles($ticket);

        $fileName = $this->fileName($ticket);
        $filePath = "tickets/{$ticket->id}/{$fileName}";
        $pdf = $this->renderPdf($ticket);

        Storage::disk('local')->put($filePath, $pdf);

        return $ticket->files()->create([
            'file_type' => TicketFileType::Pdf->value,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'mime_type' => 'application/pdf',
            'file_size' => strlen($pdf),
            'generated_at' => now(),
        ]);
    }

    public function latestPdfFile(Ticket $ticket): ?TicketFile
    {
        return $ticket->files()
            ->where('file_type', TicketFileType::Pdf->value)
            ->latest('generated_at')
            ->first();
    }

    /**
     * @throws FileNotFoundException
     */
    public function hasPdfFile(Ticket $ticket): bool
    {
        return $this->latestPdfFile($ticket) !== null;
    }

    public function download(Ticket $ticket): StreamedResponse
    {
        $file = $this->latestPdfFile($ticket) ?? $this->generate($ticket);

        return Storage::disk('local')->download($file->file_path, $file->file_name);
    }

    public function canGenerate(Ticket $ticket): bool
    {
        $ticket->loadMissing('event.settings');

        return (bool) ($ticket->event?->settings?->ticket_output_pdf ?? false)
            && in_array($ticket->status, [
                TicketStatus::Active->value,
                TicketStatus::UsedPartial->value,
                TicketStatus::UsedFull->value,
            ], true);
    }

    private function renderPdf(Ticket $ticket): string
    {
        $html = View::make('tickets.pdf', [
            'ticket' => $ticket,
            'qrImageSrc' => $this->qrImageSrc($ticket->qr_token),
        ])->render();

        $options = new Options([
            'isRemoteEnabled' => false,
            'defaultFont' => 'DejaVu Sans',
        ]);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }

    private function qrImageSrc(string $data): string
    {
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'outputBase64' => false,
            'eccLevel' => QRCode::ECC_L,
            'scale' => 6,
            'addQuietzone' => true,
        ]);
        $svg = (new QRCode($options))->render($data);

        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }

    private function deleteExistingPdfFiles(Ticket $ticket): void
    {
        $ticket->files()
            ->where('file_type', TicketFileType::Pdf->value)
            ->get()
            ->each(function (TicketFile $file): void {
                Storage::disk('local')->delete($file->file_path);
                $file->delete();
            });
    }

    private function fileName(Ticket $ticket): string
    {
        $suffix = Str::of($ticket->ticket_code)
            ->upper()
            ->replaceMatches('/[^A-Z0-9-]+/', '-')
            ->trim('-')
            ->toString();

        return "ticket-{$suffix}.pdf";
    }
}
