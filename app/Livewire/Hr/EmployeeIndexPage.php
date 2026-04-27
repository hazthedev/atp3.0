<?php

declare(strict_types=1);

namespace App\Livewire\Hr;

use App\Models\Employee;
use Livewire\Component;

class EmployeeIndexPage extends Component
{
    public function render()
    {
        return view('livewire.hr.employee-index-page', [
            'employees' => Employee::query()
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get(),
        ]);
    }
}
