<?php

declare(strict_types=1);

namespace App\Livewire\Hr;

use App\Models\Employee;
use App\Models\EmployeeAttachment;
use Livewire\Component;

/**
 * Employee Master Data — Attachments tab.
 *
 * Row editor for employee_attachments. Browse opens a small inline form
 * to capture target_path / file_name / attachment_date manually.
 *
 * Out of scope of this PR: real file upload (Storage facade, MIME
 * validation, virus scanning) — needs the cross-app file-upload pattern
 * to be decided first. Display button is also a placeholder. Delete
 * works.
 */
class EmployeeAttachmentsForm extends Component
{
    public int $employeeId;

    public bool $showBrowseForm = false;

    public string $newTargetPath = '';
    public string $newFileName = '';
    public string $newAttachmentDate = '';

    public function mount(int $employeeId): void
    {
        $this->employeeId = $employeeId;
    }

    public function openBrowse(): void
    {
        $this->showBrowseForm = true;
    }

    public function cancelBrowse(): void
    {
        $this->showBrowseForm = false;
        $this->newTargetPath = '';
        $this->newFileName = '';
        $this->newAttachmentDate = '';
    }

    public function addAttachment(): void
    {
        $path = trim($this->newTargetPath);
        $file = trim($this->newFileName);

        if ($path === '' || $file === '') {
            return;
        }

        $employee = Employee::find($this->employeeId);
        if ($employee === null) {
            return;
        }

        $employee->attachments()->create([
            'target_path' => $path,
            'file_name' => $file,
            'attachment_date' => $this->newAttachmentDate ?: null,
            'sort_order' => ($employee->attachments()->max('sort_order') ?? 0) + 1,
        ]);

        $this->cancelBrowse();
    }

    public function deleteAttachment(int $attachmentId): void
    {
        EmployeeAttachment::query()
            ->where('id', $attachmentId)
            ->where('employee_id', $this->employeeId)
            ->delete();
    }

    public function render()
    {
        $employee = Employee::with('attachments')->find($this->employeeId);

        return view('livewire.hr.employee-attachments-form', [
            'attachments' => $employee?->attachments()->orderBy('sort_order')->get() ?? collect(),
        ]);
    }
}
