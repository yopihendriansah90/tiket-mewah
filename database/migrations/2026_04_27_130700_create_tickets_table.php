<?php

use App\Enums\TicketStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('family_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('ticket_code')->unique();
            $table->string('qr_token')->unique();
            $table->unsignedInteger('quota_registered')->default(0);
            $table->unsignedInteger('quota_extra_allowed')->default(0);
            $table->unsignedInteger('quota_total')->default(0);
            $table->unsignedInteger('quota_used')->default(0);
            $table->string('status')->default(TicketStatus::Active->value);
            $table->timestamp('generated_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->foreignId('replaced_by_ticket_id')->nullable()->constrained('tickets')->nullOnDelete();
            $table->timestamps();

            $table->index('event_id');
            $table->index('family_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
