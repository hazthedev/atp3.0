<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Database\Seeder;

class UserGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            'Finance',
            'Sales',
            'Store',
            'Inventory',
            'Planner',
            'Technical Record',
            'Logistic',
            'Eng. Supervisor',
            'Tech Service',
            'Fleet Comm',
            'ALL Access (Read Only)',
            'BDD',
            'Eng. Supv (can delete WO)',
            'Planner (can delete WO)',
            'CAMO ARE',
            'Check Spares (ENG)',
            'WESB Data Migration Team',
        ];

        foreach ($groups as $name) {
            UserGroup::updateOrCreate(
                ['name' => $name, 'group_type' => UserGroup::TYPE_AUTHORIZATION],
                [
                    'description' => $name . ' — authorization group.',
                ],
            );
        }

        // Example memberships.
        $assignments = [
            'fauzan.ab' => ['Eng. Supervisor', 'Technical Record'],
            'aina.noor' => ['Planner'],
            'shahrul.a' => ['Tech Service', 'Fleet Comm'],
        ];

        foreach ($assignments as $userCode => $groupNames) {
            $user = User::where('user_code', $userCode)->first();
            if ($user === null) {
                continue;
            }

            $ids = UserGroup::whereIn('name', $groupNames)->pluck('id')->all();
            $user->groups()->syncWithoutDetaching($ids);
        }
    }
}
