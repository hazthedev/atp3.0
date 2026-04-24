<?php

declare(strict_types=1);

namespace App\Livewire\System;

use App\Models\User;
use Livewire\Component;

class UserIndexPage extends Component
{
    public function render()
    {
        $users = User::query()
            ->orderBy('user_code')
            ->get();

        return view('livewire.system.user-index-page', [
            'users' => $users,
        ]);
    }
}
