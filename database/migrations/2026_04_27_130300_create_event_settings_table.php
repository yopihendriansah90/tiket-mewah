<?php

use App\Enums\QrTokenType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->unique()->constrained()->cascadeOnDelete();
            $table->boolean('allow_extra_guests')->default(false);
            $table->unsignedInteger('extra_guest_limit')->nullable();
            $table->boolean('extra_guest_requires_helper_approval')->default(true);
            $table->boolean('allow_parent_replacement')->default(true);
            $table->boolean('parent_replacement_requires_helper_approval')->default(true);
            $table->boolean('allow_guardian_replacement')->default(true);
            $table->boolean('guardian_replacement_requires_helper_approval')->default(true);
            $table->boolean('allow_reentry_at_main_gate')->default(false);
            $table->boolean('reentry_requires_helper_approval')->default(true);
            $table->boolean('require_student_to_enter_with_parent')->default(false);
            $table->boolean('require_parent_to_enter_with_student')->default(false);
            $table->boolean('allow_partial_checkin')->default(true);
            $table->boolean('allow_manual_checkin')->default(true);
            $table->boolean('manual_checkin_requires_reason')->default(true);
            $table->boolean('ticket_output_pdf')->default(true);
            $table->boolean('ticket_output_png')->default(true);
            $table->string('qr_token_type')->default(QrTokenType::Ulid->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_settings');
    }
};
