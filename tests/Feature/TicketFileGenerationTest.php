<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\EventStatus;
use App\Enums\EventType;
use App\Enums\FamilyMemberCheckinStatus;
use App\Enums\FamilyStatus;
use App\Enums\Gender;
use App\Enums\MemberType;
use App\Enums\QrTokenType;
use App\Enums\TicketFileType;
use App\Enums\TicketStatus;
use App\Models\Event;
use App\Models\EventSetting;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Vendor;
use App\Services\Ticket\TicketFileGeneratorService;
use App\Services\Ticket\TicketImageService;
use App\Services\Ticket\TicketPdfService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TicketFileGenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_generates_configured_pdf_and_png_files(): void
    {
        Storage::fake('local');

        $ticket = $this->makeTicket();

        $files = app(TicketFileGeneratorService::class)->generateConfiguredFiles($ticket);

        $this->assertCount(2, $files);
        $this->assertEqualsCanonicalizing(
            [TicketFileType::Pdf->value, TicketFileType::Png->value],
            $files->pluck('file_type')->all(),
        );

        foreach ($files as $file) {
            Storage::disk('local')->assertExists($file->file_path);
        }
    }

    public function test_it_can_generate_png_file(): void
    {
        Storage::fake('local');

        $ticket = $this->makeTicket();

        $file = app(TicketImageService::class)->generate($ticket);

        $this->assertSame(TicketFileType::Png->value, $file->file_type);
        $this->assertSame('image/png', $file->mime_type);
        Storage::disk('local')->assertExists($file->file_path);
        $this->assertStringEndsWith('.png', $file->file_name);
    }

    public function test_it_replaces_existing_pdf_file_when_regenerated(): void
    {
        Storage::fake('local');

        $ticket = $this->makeTicket();
        $service = app(TicketPdfService::class);

        $first = $service->generate($ticket);
        $second = $service->generate($ticket->fresh());

        Storage::disk('local')->assertMissing($first->file_path);
        Storage::disk('local')->assertExists($second->file_path);
        $this->assertDatabaseCount('ticket_files', 1);
        $this->assertSame(TicketFileType::Pdf->value, $second->file_type);
    }

    public function test_it_fails_when_no_output_format_is_enabled(): void
    {
        $ticket = $this->makeTicket([
            'ticket_output_pdf' => false,
            'ticket_output_png' => false,
        ]);

        $this->expectExceptionMessage('Tidak ada format output tiket yang aktif pada event ini.');

        app(TicketFileGeneratorService::class)->generateConfiguredFiles($ticket);
    }

    private function makeTicket(array $settingOverrides = []): Ticket
    {
        $vendor = Vendor::query()->create([
            'name' => 'Demo Vendor',
            'slug' => 'demo-vendor',
            'status' => 'active',
        ]);

        $user = User::query()->create([
            'vendor_id' => $vendor->id,
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'is_active' => true,
        ]);

        $event = Event::query()->create([
            'vendor_id' => $vendor->id,
            'name' => 'Graduation Night 2026',
            'slug' => 'graduation-night-2026',
            'event_type' => EventType::School->value,
            'event_date' => now()->toDateString(),
            'status' => EventStatus::Active->value,
            'created_by' => $user->id,
        ]);

        EventSetting::query()->create(array_merge([
            'event_id' => $event->id,
            'allow_extra_guests' => true,
            'extra_guest_limit' => 2,
            'extra_guest_requires_helper_approval' => true,
            'allow_parent_replacement' => true,
            'parent_replacement_requires_helper_approval' => true,
            'allow_guardian_replacement' => true,
            'guardian_replacement_requires_helper_approval' => true,
            'allow_reentry_at_main_gate' => false,
            'reentry_requires_helper_approval' => true,
            'require_student_to_enter_with_parent' => false,
            'require_parent_to_enter_with_student' => false,
            'allow_partial_checkin' => true,
            'allow_manual_checkin' => true,
            'manual_checkin_requires_reason' => true,
            'ticket_output_pdf' => true,
            'ticket_output_png' => true,
            'qr_token_type' => QrTokenType::Ulid->value,
        ], $settingOverrides));

        $family = Family::query()->create([
            'event_id' => $event->id,
            'family_code' => 'FAM-001',
            'family_name' => 'Keluarga Andika',
            'main_student_name' => 'Andika',
            'class_label' => '12A',
            'status' => FamilyStatus::Active->value,
        ]);

        FamilyMember::query()->create([
            'family_id' => $family->id,
            'member_type' => MemberType::Student->value,
            'name' => 'Andika',
            'gender' => Gender::Male->value,
            'class_name' => '12A',
            'relation_label' => 'Siswa',
            'is_primary_student' => true,
            'is_registered_member' => true,
            'is_extra_guest' => false,
            'is_replacement' => false,
            'checkin_status' => FamilyMemberCheckinStatus::Pending->value,
        ]);

        FamilyMember::query()->create([
            'family_id' => $family->id,
            'member_type' => MemberType::Father->value,
            'name' => 'Budi',
            'gender' => Gender::Male->value,
            'relation_label' => 'Ayah',
            'is_primary_student' => false,
            'is_registered_member' => true,
            'is_extra_guest' => false,
            'is_replacement' => false,
            'checkin_status' => FamilyMemberCheckinStatus::Pending->value,
        ]);

        return Ticket::query()->create([
            'event_id' => $event->id,
            'family_id' => $family->id,
            'ticket_code' => 'EV-1-FAM-001',
            'qr_token' => '01JTESTQR1234567890ABCDE',
            'quota_registered' => 2,
            'quota_extra_allowed' => 2,
            'quota_total' => 4,
            'quota_used' => 0,
            'status' => TicketStatus::Active->value,
            'generated_at' => now(),
        ]);
    }
}
