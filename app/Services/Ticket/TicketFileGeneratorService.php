<?php

declare(strict_types=1);

namespace App\Services\Ticket;

use App\Enums\TicketFileType;
use App\Models\Ticket;
use App\Models\TicketFile;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class TicketFileGeneratorService
{
    public function __construct(
        private readonly TicketPdfService $pdfService,
        private readonly TicketImageService $imageService,
    ) {}

    /**
     * @return Collection<int, TicketFile>
     */
    public function generateConfiguredFiles(Ticket $ticket): Collection
    {
        $types = $this->configuredTypes($ticket);

        if ($types === []) {
            throw new InvalidArgumentException('Tidak ada format output tiket yang aktif pada event ini.');
        }

        return collect($types)
            ->map(fn (string $type): TicketFile => $this->generate($ticket, $type));
    }

    public function generate(Ticket $ticket, string $type): TicketFile
    {
        return match ($type) {
            TicketFileType::Pdf->value => $this->pdfService->generate($ticket),
            TicketFileType::Png->value => $this->imageService->generate($ticket),
            default => throw new InvalidArgumentException("Format file tiket tidak didukung: {$type}"),
        };
    }

    public function configuredTypes(Ticket $ticket): array
    {
        $ticket->loadMissing('event.settings');

        $types = [];

        if ($ticket->event?->settings?->ticket_output_pdf) {
            $types[] = TicketFileType::Pdf->value;
        }

        if ($ticket->event?->settings?->ticket_output_png) {
            $types[] = TicketFileType::Png->value;
        }

        return $types;
    }
}
