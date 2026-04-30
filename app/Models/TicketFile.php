<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class TicketFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'file_type',
        'file_path',
        'file_name',
        'mime_type',
        'file_size',
        'generated_at',
    ];

    protected function casts(): array
    {
        return [
            'generated_at' => 'datetime',
        ];
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function previewUrl(): ?string
    {
        if (blank($this->file_path)) {
            return null;
        }

        $disk = Storage::disk('local');

        try {
            return $disk->temporaryUrl(
                $this->file_path,
                now()->addMinutes(30),
            );
        } catch (\Throwable) {
            return $disk->url($this->file_path);
        }
    }

    public function canPreviewInline(): bool
    {
        return str_starts_with((string) $this->mime_type, 'image/');
    }
}
