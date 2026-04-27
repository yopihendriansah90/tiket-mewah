<?php

use App\Enums\CheckinMethod;
use App\Enums\CheckinStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $table->foreignId('family_id')->constrained()->cascadeOnDelete();
            $table->foreignId('family_member_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('gate_id')->nullable()->constrained('event_gates')->nullOnDelete();
            $table->foreignId('checked_by')->constrained('users')->restrictOnDelete();
            $table->timestamp('checked_at');
            $table->string('checkin_method')->default(CheckinMethod::QrScan->value);
            $table->string('checkin_status')->default(CheckinStatus::Success->value);
            $table->boolean('counts_as_quota')->default(true);
            $table->boolean('is_extra_guest')->default(false);
            $table->boolean('is_replacement')->default(false);
            $table->string('guest_name_snapshot')->nullable();
            $table->string('guest_relation_snapshot')->nullable();
            $table->foreignId('issue_id')->nullable()->constrained('ticket_issues')->nullOnDelete();
            $table->foreignId('approval_id')->nullable()->constrained('manual_approvals')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('event_id');
            $table->index('ticket_id');
            $table->index('family_id');
            $table->index('family_member_id');
            $table->index('gate_id');
            $table->index('checked_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkins');
    }
};
