<?php

declare(strict_types=1);

namespace App\Services\Ticket;

use App\Enums\TicketFileType;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\TicketFile;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TicketImageService
{
    public function generate(Ticket $ticket): TicketFile
    {
        $ticket->loadMissing([
            'event.settings',
            'family.members',
        ]);

        $this->deleteExistingPngFiles($ticket);

        $fileName = $this->fileName($ticket);
        $filePath = "tickets/{$ticket->id}/{$fileName}";
        $image = $this->renderImage($ticket);

        Storage::disk('local')->put($filePath, $image);

        return $ticket->files()->create([
            'file_type' => TicketFileType::Png->value,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'mime_type' => 'image/png',
            'file_size' => strlen($image),
            'generated_at' => now(),
        ]);
    }

    public function latestPngFile(Ticket $ticket): ?TicketFile
    {
        return $ticket->files()
            ->where('file_type', TicketFileType::Png->value)
            ->latest('generated_at')
            ->first();
    }

    /**
     * @throws FileNotFoundException
     */
    public function hasPngFile(Ticket $ticket): bool
    {
        return $this->latestPngFile($ticket) !== null;
    }

    public function download(Ticket $ticket): StreamedResponse
    {
        $file = $this->latestPngFile($ticket) ?? $this->generate($ticket);

        return Storage::disk('local')->download($file->file_path, $file->file_name);
    }

    public function canGenerate(Ticket $ticket): bool
    {
        $ticket->loadMissing('event.settings');

        return (bool) ($ticket->event?->settings?->ticket_output_png ?? false)
            && in_array($ticket->status, [
                TicketStatus::Active->value,
                TicketStatus::UsedPartial->value,
                TicketStatus::UsedFull->value,
            ], true);
    }

    private function renderImage(Ticket $ticket): string
    {
        $width = 1080;
        $height = 1400;

        $image = imagecreatetruecolor($width, $height);

        $background = imagecolorallocate($image, 255, 255, 255);
        $white = imagecolorallocate($image, 255, 255, 255);
        $title = imagecolorallocate($image, 190, 24, 93);
        $text = imagecolorallocate($image, 157, 23, 77);
        $muted = imagecolorallocate($image, 241, 218, 164);
        $dots = imagecolorallocate($image, 250, 240, 214);

        imagefill($image, 0, 0, $background);
        $this->drawWatermarkPattern($image, $muted);
        $this->drawDotFade($image, $dots);

        $this->drawCenteredText(
            $image,
            540,
            172,
            32,
            'DejaVuSans-Bold',
            $this->truncate((string) ($ticket->event?->name ?: 'E-Ticket Event'), 28),
            $title
        );
        $this->drawCenteredText(
            $image,
            540,
            226,
            20,
            'DejaVuSans-Bold',
            $ticket->event?->event_date?->translatedFormat('l, d F Y') ?? '-',
            $text
        );
        $this->drawCenteredText(
            $image,
            540,
            282,
            20,
            'NotoSans-Regular',
            'Ticket for: '.$this->truncate($this->primaryMemberName($ticket), 26),
            $text
        );
        $this->drawCenteredText(
            $image,
            540,
            318,
            20,
            'DejaVuSans-Bold',
            'Ticket ID: '.$ticket->ticket_code.' | '.$this->memberSummary($ticket),
            $text
        );

        imagefilledrectangle($image, 200, 420, 880, 1100, $white);

        $qr = imagecreatefromstring($this->qrPng($ticket->qr_token));
        imagecopyresampled($image, $qr, 258, 478, 0, 0, 564, 564, imagesx($qr), imagesy($qr));
        imagedestroy($qr);

        $this->drawCenteredText($image, 540, 1182, 18, 'NotoSans-Regular', 'Customer Service Event', $title);
        $this->drawCenteredText($image, 540, 1214, 18, 'NotoSans-Regular', '+62 852-0000-0301', $title);
        $this->drawCenteredText($image, 540, 1246, 18, 'NotoSans-Regular', 'support@example.com', $title);

        ob_start();
        imagepng($image);
        $png = (string) ob_get_clean();

        imagedestroy($image);

        return $png;
    }

    private function qrPng(string $data): string
    {
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_L,
            'scale' => 16,
            'imageBase64' => false,
        ]);

        return (new QRCode($options))->render($data);
    }

    private function deleteExistingPngFiles(Ticket $ticket): void
    {
        $ticket->files()
            ->where('file_type', TicketFileType::Png->value)
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

        return "ticket-{$suffix}.png";
    }

    private function drawText(
        \GdImage $image,
        int $x,
        int $baselineY,
        int $size,
        string $fontName,
        string $text,
        int $color,
    ): void {
        $fontPath = $this->fontPath($fontName);

        if ($fontPath === null) {
            imagestring($image, 5, $x, $baselineY, $text, $color);

            return;
        }

        imagettftext($image, $size, 0, $x, $baselineY, $color, $fontPath, $text);
    }

    private function drawCenteredText(
        \GdImage $image,
        int $centerX,
        int $baselineY,
        int $size,
        string $fontName,
        string $text,
        int $color,
    ): void {
        $fontPath = $this->fontPath($fontName);

        if ($fontPath === null) {
            imagestring($image, 5, $centerX - 120, $baselineY, $text, $color);

            return;
        }

        $width = $this->textWidth($size, $fontPath, $text);
        imagettftext($image, $size, 0, $centerX - (int) ($width / 2), $baselineY, $color, $fontPath, $text);
    }

    private function textWidth(int $size, string $fontPath, string $text): int
    {
        $box = imagettfbbox($size, 0, $fontPath, $text);

        return (int) abs($box[2] - $box[0]);
    }

    private function fontPath(string $fontName): ?string
    {
        $fonts = [
            'NotoSans-Regular' => '/usr/share/fonts/truetype/noto/NotoSans-Regular.ttf',
            'DejaVuSans-Bold' => '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
        ];

        $path = $fonts[$fontName] ?? null;

        return ($path !== null && is_file($path)) ? $path : null;
    }

    private function drawWatermarkPattern(\GdImage $image, int $shapeColor): void
    {
        for ($y = 30; $y < 1360; $y += 120) {
            for ($x = 10; $x < 1040; $x += 230) {
                imagefilledellipse($image, $x + 26, $y + 12, 18, 44, $shapeColor);
                imagefilledellipse($image, $x + 46, $y + 32, 18, 44, $shapeColor);
                $this->drawText($image, $x + 66, $y + 22, 12, 'DejaVuSans-Bold', 'MEWAH', $shapeColor);
                $this->drawText($image, $x + 66, $y + 42, 12, 'DejaVuSans-Bold', 'PROJECT', $shapeColor);
            }
        }
    }

    private function drawDotFade(\GdImage $image, int $dotColor): void
    {
        for ($y = 1100; $y < 1390; $y += 16) {
            for ($x = 20; $x < 300; $x += 16) {
                imagefilledellipse($image, $x, $y, 5, 5, $dotColor);
            }
        }
    }

    private function primaryMemberName(Ticket $ticket): string
    {
        $primary = $ticket->family?->members?->firstWhere('is_primary_student', true)
            ?? $ticket->family?->members?->first();

        return $primary?->name ?? 'Peserta';
    }

    private function memberSummary(Ticket $ticket): string
    {
        $member = $ticket->family?->members?->first();
        $gender = strtolower((string) ($member?->gender ?? ''));
        $label = match ($gender) {
            'male' => 'Laki-Laki',
            'female' => 'Perempuan',
            default => 'Peserta',
        };

        return $label.' | Reguler';
    }

    private function truncate(string $value, int $limit): string
    {
        return Str::limit($value, $limit, '...');
    }
}
