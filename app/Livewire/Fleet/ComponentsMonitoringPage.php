<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\ComponentsMonitoringCatalog;
use Livewire\Component;

class ComponentsMonitoringPage extends Component
{
    public string $displayOnly = 'not_initialized_serialized_parts';

    public bool $excludeAppliedAndNonApplicableTask = false;

    public string $selectedRowKey = '';

    public string $actionMessage = '';

    public function updatedDisplayOnly(): void
    {
        $this->selectedRowKey = '';
        $this->actionMessage = '';
    }

    public function updatedExcludeAppliedAndNonApplicableTask(): void
    {
        $this->selectedRowKey = '';
        $this->actionMessage = '';
    }

    public function selectRow(string $rowKey): void
    {
        $this->selectedRowKey = $rowKey;
        $selectedRow = ComponentsMonitoringCatalog::find($rowKey);

        if ($selectedRow !== null) {
            $this->actionMessage = 'Selected component ' . ($selectedRow['part_number'] ?: 'Unknown Part') . ' / ' . ($selectedRow['serial_number'] ?: 'No Serial') . '.';
        }
    }

    public function includeIntoWorkOrder(): void
    {
        $selectedRow = ComponentsMonitoringCatalog::find($this->selectedRowKey);

        if ($selectedRow === null) {
            $this->actionMessage = 'Select a component row first.';

            return;
        }

        $this->actionMessage = 'Component ' . $selectedRow['serial_number'] . ' is staged for work-order inclusion.';
    }

    public function applyTaskList(): void
    {
        $selectedRow = ComponentsMonitoringCatalog::find($this->selectedRowKey);

        if ($selectedRow === null) {
            $this->actionMessage = 'Select a component row first.';

            return;
        }

        $this->actionMessage = 'Task list preview applied to component ' . $selectedRow['serial_number'] . '.';
    }

    public function render()
    {
        $rows = ComponentsMonitoringCatalog::filter($this->displayOnly, $this->excludeAppliedAndNonApplicableTask);
        $selectedRow = $rows->firstWhere('row_key', $this->selectedRowKey);

        if ($selectedRow === null && $this->selectedRowKey !== '') {
            $this->selectedRowKey = '';
        }

        return view('livewire.fleet.components-monitoring-page', [
            'rows' => $rows,
            'selectedRow' => $selectedRow,
            'displayOptions' => [
                'critical_tasks_on_serialized_parts' => 'Critical Tasks on Serialized Parts',
                'not_initialized_serialized_parts' => 'Not Initialized Serialized Parts',
                'serialized_parts_with_init_task_without_work_order' => 'Serialized Parts with init Task w/o Work Order',
                'serialized_parts_with_non_initialized_tasks' => 'Serialized Parts with non initialized tasks',
                'serialized_parts_with_initialized_task' => 'Serialized Parts with initialized Task',
            ],
        ]);
    }
}
