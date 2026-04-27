<?php

use App\Enums\FamilyMemberCheckinStatus;
use App\Enums\Gender;
use App\Enums\MemberType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained()->cascadeOnDelete();
            $table->string('member_type')->default(MemberType::Student->value);
            $table->string('name');
            $table->string('gender')->default(Gender::Unknown->value);
            $table->string('class_name')->nullable();
            $table->string('relation_label')->nullable();
            $table->boolean('is_primary_student')->default(false);
            $table->boolean('is_registered_member')->default(true);
            $table->boolean('is_extra_guest')->default(false);
            $table->boolean('is_replacement')->default(false);
            $table->foreignId('replaced_member_id')->nullable()->constrained('family_members')->nullOnDelete();
            $table->string('checkin_status')->default(FamilyMemberCheckinStatus::Pending->value);
            $table->timestamp('checked_in_at')->nullable();
            $table->foreignId('checked_in_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('checked_in_gate_id')->nullable()->constrained('event_gates')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('family_id');
            $table->index('name');
            $table->index('member_type');
            $table->index('checkin_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
