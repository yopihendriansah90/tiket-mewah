<?php

use App\Enums\FamilyStatus;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('family_code');
            $table->string('family_name')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('main_student_name')->nullable();
            $table->string('class_label')->nullable();
            $table->text('notes')->nullable();
            $table->string('import_batch_id')->nullable();
            $table->string('status')->default(FamilyStatus::Active->value);
            $table->timestamps();

            $table->unique(['event_id', 'family_code']);
            $table->index('event_id');
            $table->index('family_code');
            $table->index('main_student_name');
            $table->index('class_label');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
