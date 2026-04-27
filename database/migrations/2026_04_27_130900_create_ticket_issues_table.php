<?php

use App\Enums\IssueStatus;
use App\Enums\IssueType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ticket_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('family_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('gate_id')->nullable()->constrained('event_gates')->nullOnDelete();
            $table->string('issue_code')->unique();
            $table->string('issue_type')->default(IssueType::Other->value);
            $table->foreignId('reported_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('reported_name')->nullable();
            $table->string('reported_phone')->nullable();
            $table->text('description')->nullable();
            $table->text('resolution')->nullable();
            $table->string('status')->default(IssueStatus::Open->value);
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index('event_id');
            $table->index('ticket_id');
            $table->index('family_id');
            $table->index('issue_code');
            $table->index('status');
            $table->index('issue_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_issues');
    }
};
