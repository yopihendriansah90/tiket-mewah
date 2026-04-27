<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $vendor = Vendor::query()->firstOrCreate(
            ['slug' => 'withim-demo'],
            [
                'name' => 'Withim Demo Vendor',
                'contact_name' => 'Platform Admin',
                'email' => 'vendor@example.com',
                'status' => 'active',
            ],
        );

        $resourceActions = [
            'ViewAny',
            'View',
            'Create',
            'Update',
            'Delete',
            'DeleteAny',
            'Restore',
            'ForceDelete',
            'ForceDeleteAny',
            'RestoreAny',
            'Replicate',
            'Reorder',
        ];

        $viewActions = ['ViewAny', 'View'];
        $manageActions = ['ViewAny', 'View', 'Create', 'Update', 'Delete', 'DeleteAny'];

        $resourcePermissions = fn (string $subject, ?array $actions = null): array => collect($actions ?? $resourceActions)
            ->map(fn (string $action): string => "{$action}:{$subject}")
            ->all();

        $allResourcePermissions = collect([
            'AuditLog',
            'Checkin',
            'Event',
            'EventGate',
            'EventSetting',
            'Family',
            'FamilyMember',
            'ManualApproval',
            'Role',
            'Ticket',
            'TicketFile',
            'TicketIssue',
            'TicketIssueLog',
            'TicketReprint',
            'User',
            'Vendor',
        ])->flatMap(fn (string $subject): array => $resourcePermissions($subject));

        $customPermissions = array_keys(config('filament-shield.custom_permissions', []));

        $permissions = $allResourcePermissions
            ->merge($customPermissions)
            ->unique()
            ->mapWithKeys(fn (string $permissionName): array => [
                $permissionName => Permission::query()->firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web',
                ]),
            ]);

        $rolePermissions = [
            'superadmin' => $permissions->keys()->all(),
            'vendor-admin' => collect([
                'Access:AdminPanel',
                'Manage:Events',
                'View:Events',
                'Manage:EventSettings',
                'Manage:Gates',
                'Manage:Families',
                'Manage:FamilyMembers',
                'Import:Families',
                'Generate:Tickets',
                'Download:Tickets',
                'Scan:Tickets',
                'Checkin:Members',
                'Create:TicketIssues',
                'Use:HelperDesk',
                'Manual:Checkin',
                'Reprint:Tickets',
                'Regenerate:Tickets',
                'View:Reports',
                'View:AuditLogs',
            ])
                ->merge($resourcePermissions('Event', $manageActions))
                ->merge($resourcePermissions('EventSetting', $manageActions))
                ->merge($resourcePermissions('EventGate', $manageActions))
                ->merge($resourcePermissions('Family', $manageActions))
                ->merge($resourcePermissions('FamilyMember', $manageActions))
                ->merge($resourcePermissions('Ticket', $manageActions))
                ->merge($resourcePermissions('TicketFile', $manageActions))
                ->merge($resourcePermissions('TicketIssue', $manageActions))
                ->merge($resourcePermissions('Checkin', $viewActions))
                ->merge($resourcePermissions('ManualApproval', $viewActions))
                ->merge($resourcePermissions('TicketReprint', $manageActions))
                ->merge($resourcePermissions('AuditLog', $viewActions))
                ->all(),
            'checkin-officer' => collect([
                'Access:AdminPanel',
                'View:Events',
                'Scan:Tickets',
                'Checkin:Members',
                'Create:TicketIssues',
            ])
                ->merge($resourcePermissions('Event', $viewActions))
                ->merge($resourcePermissions('EventGate', $viewActions))
                ->merge($resourcePermissions('Family', $viewActions))
                ->merge($resourcePermissions('FamilyMember', $viewActions))
                ->merge($resourcePermissions('Ticket', $viewActions))
                ->merge($resourcePermissions('Checkin', $viewActions))
                ->all(),
            'helper-desk' => collect([
                'Access:AdminPanel',
                'View:Events',
                'Create:TicketIssues',
                'Use:HelperDesk',
                'Manual:Checkin',
                'Approve:Override',
                'Reprint:Tickets',
                'Regenerate:Tickets',
                'View:Reports',
            ])
                ->merge($resourcePermissions('Event', $viewActions))
                ->merge($resourcePermissions('EventGate', $viewActions))
                ->merge($resourcePermissions('Family', $viewActions))
                ->merge($resourcePermissions('FamilyMember', $viewActions))
                ->merge($resourcePermissions('Ticket', $viewActions))
                ->merge($resourcePermissions('TicketIssue', $manageActions))
                ->merge($resourcePermissions('ManualApproval', $manageActions))
                ->merge($resourcePermissions('Checkin', $manageActions))
                ->merge($resourcePermissions('TicketReprint', $manageActions))
                ->all(),
            'event-supervisor' => collect([
                'Access:AdminPanel',
                'View:Events',
                'Scan:Tickets',
                'Checkin:Members',
                'Create:TicketIssues',
                'Use:HelperDesk',
                'Manual:Checkin',
                'Approve:Override',
                'Reprint:Tickets',
                'Regenerate:Tickets',
                'View:Reports',
                'View:AuditLogs',
            ])
                ->merge($resourcePermissions('Event', $viewActions))
                ->merge($resourcePermissions('EventGate', $viewActions))
                ->merge($resourcePermissions('Family', $viewActions))
                ->merge($resourcePermissions('FamilyMember', $viewActions))
                ->merge($resourcePermissions('Ticket', $viewActions))
                ->merge($resourcePermissions('TicketIssue', $viewActions))
                ->merge($resourcePermissions('ManualApproval', $viewActions))
                ->merge($resourcePermissions('Checkin', $viewActions))
                ->merge($resourcePermissions('TicketReprint', $viewActions))
                ->merge($resourcePermissions('AuditLog', $viewActions))
                ->all(),
            'school-pic' => collect([
                'Access:AdminPanel',
                'View:Events',
                'View:Reports',
            ])
                ->merge($resourcePermissions('Event', $viewActions))
                ->merge($resourcePermissions('Family', $viewActions))
                ->merge($resourcePermissions('FamilyMember', $viewActions))
                ->merge($resourcePermissions('TicketIssue', $viewActions))
                ->all(),
        ];

        $roles = collect($rolePermissions)->mapWithKeys(function (array $permissionNames, string $roleName) use ($permissions): array {
            $role = Role::query()->firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            $role->syncPermissions($permissions->only($permissionNames)->values());

            return [$roleName => $role];
        });

        $user = User::query()->updateOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'vendor_id' => $vendor->id,
                'name' => 'Platform Admin',
                'phone' => '081234567890',
                'password' => 'admin',
                'is_active' => true,
            ],
        );

        $user->syncRoles([
            $roles->get('superadmin'),
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
