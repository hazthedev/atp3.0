<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Authorization;
use App\Models\Permission;
use App\Models\UserGroup;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Tree mirrors the ATP 3.0 sidebar structure. Each entry is
     * [code, name, children?].
     */
    private array $tree = [
        ['code' => 'dashboard', 'name' => 'Dashboard', 'children' => [
            ['code' => 'dashboard.user', 'name' => 'User Dashboard'],
            ['code' => 'dashboard.fleet', 'name' => 'Fleet Dashboard'],
        ]],
        ['code' => 'administration', 'name' => 'Administration', 'children' => [
            ['code' => 'administration.user-management', 'name' => 'User Management', 'children' => [
                ['code' => 'administration.user-management.user', 'name' => 'User'],
                ['code' => 'administration.user-management.user-groups', 'name' => 'User Groups'],
                ['code' => 'administration.user-management.user-authorizations', 'name' => 'User Authorizations'],
            ]],
            ['code' => 'administration.stock-management', 'name' => 'Stock Management'],
            ['code' => 'administration.fleet-management', 'name' => 'Fleet Management'],
            ['code' => 'administration.flight-operations', 'name' => 'Flight Operations'],
            ['code' => 'administration.mro-management', 'name' => 'MRO Management'],
            ['code' => 'administration.utilities', 'name' => 'Utilities'],
            ['code' => 'administration.settings', 'name' => 'Settings'],
        ]],
        ['code' => 'business-partners', 'name' => 'Business Partners', 'children' => [
            ['code' => 'business-partners.master-data', 'name' => 'Business Partner Master Data'],
        ]],
        ['code' => 'inventory', 'name' => 'Inventory', 'children' => [
            ['code' => 'inventory.master-data', 'name' => 'Item Master Data'],
        ]],
        ['code' => 'human-resources', 'name' => 'Human Resources', 'children' => [
            ['code' => 'human-resources.employee-master-data', 'name' => 'Employee Master Data'],
        ]],
        ['code' => 'technical-data', 'name' => 'Technical Data', 'children' => [
            ['code' => 'technical-data.configuration-management', 'name' => 'Configuration Management'],
            ['code' => 'technical-data.technical-publications', 'name' => 'Technical Publications'],
            ['code' => 'technical-data.maintenance-program', 'name' => 'Maintenance Program'],
        ]],
        ['code' => 'fleet-management', 'name' => 'Fleet Management', 'children' => [
            ['code' => 'fleet-management.functional-location', 'name' => 'Functional Location'],
            ['code' => 'fleet-management.equipment', 'name' => 'Equipment'],
            ['code' => 'fleet-management.technical-publications', 'name' => 'Technical Publications'],
            ['code' => 'fleet-management.maintenance-plan', 'name' => 'Maintenance Plan'],
            ['code' => 'fleet-management.operational-inputs', 'name' => 'Operational Inputs'],
            ['code' => 'fleet-management.initialization', 'name' => 'Initialization'],
        ]],
        ['code' => 'flight-recording', 'name' => 'Flight Recording', 'children' => [
            ['code' => 'flight-recording.flight-details', 'name' => 'Flight Details'],
            ['code' => 'flight-recording.technical-log', 'name' => 'Technical Log'],
            ['code' => 'flight-recording.defects', 'name' => 'Defects'],
        ]],
        ['code' => 'mro-management', 'name' => 'MRO Management', 'children' => [
            ['code' => 'mro-management.work-package', 'name' => 'Work Package'],
            ['code' => 'mro-management.work-order', 'name' => 'Work Order'],
            ['code' => 'mro-management.time-tracking', 'name' => 'Time Tracking'],
            ['code' => 'mro-management.defects', 'name' => 'Defects'],
        ]],
        ['code' => 'reports', 'name' => 'Reports', 'children' => [
            ['code' => 'reports.fleet-commercial', 'name' => 'Fleet Commercial Report'],
            ['code' => 'reports.fleet-management', 'name' => 'Fleet Management Report'],
            ['code' => 'reports.time-tracking', 'name' => 'Time Tracking'],
        ]],
    ];

    public function run(): void
    {
        $sort = 0;

        foreach ($this->tree as $node) {
            $this->upsert($node, null, $sort++);
        }

        $this->seedExampleAuthorizations();
    }

    /**
     * @param  array{code: string, name: string, children?: array}  $node
     */
    private function upsert(array $node, ?int $parentId, int $sort): Permission
    {
        $permission = Permission::updateOrCreate(
            ['code' => $node['code']],
            [
                'name' => $node['name'],
                'parent_id' => $parentId,
                'sort_order' => $sort,
            ],
        );

        $childSort = 0;
        foreach ($node['children'] ?? [] as $child) {
            $this->upsert($child, $permission->id, $childSort++);
        }

        return $permission;
    }

    private function seedExampleAuthorizations(): void
    {
        // "ALL Access (Read Only)" group → read_only on every top-level permission.
        $readOnlyGroup = UserGroup::where('name', 'ALL Access (Read Only)')->first();
        if ($readOnlyGroup !== null) {
            $topLevel = Permission::whereNull('parent_id')->get();
            foreach ($topLevel as $perm) {
                Authorization::updateOrCreate(
                    [
                        'subject_type' => 'user_group',
                        'subject_id' => $readOnlyGroup->id,
                        'permission_id' => $perm->id,
                    ],
                    ['level' => Authorization::LEVEL_READ_ONLY],
                );
            }
        }
    }
}
