<?php

use App\Enums\TicketFileType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_reprints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $table->foreignId('family_id')->constrained()->cascadeOnDelete();
            $table->foreignId('issue_id')->nullable()->constrained('ticket_issues')->nullOnDelete();
            $table->foreignId('reprinted_by')->constrained('users')->restrictOnDelete();
            $table->timestamp('reprinted_at');
            $table->text('reason');
            $table->string('file_type')->default(TicketFileType::Pdf->value);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_reprints');
    }
};
