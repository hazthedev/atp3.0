<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Hr;

use App\Livewire\Hr\EmployeeAttachmentsForm;
use App\Models\Employee;
use Livewire\Livewire;
use Tests\TestCase;

class EmployeeAttachmentsFormTest extends TestCase
{
    public function test_open_browse_reveals_form_and_cancel_clears_inputs(): void
    {
        $emp = Employee::factory()->create();

        $component = Livewire::test(EmployeeAttachmentsForm::class, ['employeeId' => $emp->id])
            ->call('openBrowse')
            ->assertSet('showBrowseForm', true)
            ->set('newTargetPath', '/x')
            ->set('newFileName', 'a.pdf')
            ->call('cancelBrowse');

        $component->assertSet('showBrowseForm', false)
                  ->assertSet('newTargetPath', '')
                  ->assertSet('newFileName', '');
    }

    public function test_add_attachment_creates_row_and_closes_form(): void
    {
        $emp = Employee::factory()->create();

        Livewire::test(EmployeeAttachmentsForm::class, ['employeeId' => $emp->id])
            ->call('openBrowse')
            ->set('newTargetPath', '/uploads/hr/2026/contract.pdf')
            ->set('newFileName', 'contract.pdf')
            ->set('newAttachmentDate', '2026-04-27')
            ->call('addAttachment')
            ->assertSet('showBrowseForm', false)
            ->assertSet('newTargetPath', '');

        $this->assertSame(1, $emp->attachments()->count());
        $row = $emp->attachments()->first();
        $this->assertSame('/uploads/hr/2026/contract.pdf', $row->target_path);
        $this->assertSame('contract.pdf', $row->file_name);
        $this->assertSame('2026-04-27', $row->attachment_date->format('Y-m-d'));
    }

    public function test_add_attachment_requires_path_and_filename(): void
    {
        $emp = Employee::factory()->create();

        // Missing path
        Livewire::test(EmployeeAttachmentsForm::class, ['employeeId' => $emp->id])
            ->set('newTargetPath', '')
            ->set('newFileName', 'a.pdf')
            ->call('addAttachment');

        $this->assertSame(0, $emp->attachments()->count());

        // Missing filename
        Livewire::test(EmployeeAttachmentsForm::class, ['employeeId' => $emp->id])
            ->set('newTargetPath', '/some')
            ->set('newFileName', '')
            ->call('addAttachment');

        $this->assertSame(0, $emp->attachments()->count());
    }

    public function test_add_attachment_with_blank_date_persists_null(): void
    {
        $emp = Employee::factory()->create();

        Livewire::test(EmployeeAttachmentsForm::class, ['employeeId' => $emp->id])
            ->set('newTargetPath', '/x')
            ->set('newFileName', 'a.pdf')
            ->set('newAttachmentDate', '')
            ->call('addAttachment');

        $this->assertNull($emp->attachments()->first()->attachment_date);
    }

    public function test_delete_attachment_removes_only_targeted_row(): void
    {
        $emp = Employee::factory()->create();
        $a = $emp->attachments()->create([
            'target_path' => '/a',
            'file_name' => 'a.pdf',
            'sort_order' => 1,
        ]);
        $b = $emp->attachments()->create([
            'target_path' => '/b',
            'file_name' => 'b.pdf',
            'sort_order' => 2,
        ]);

        Livewire::test(EmployeeAttachmentsForm::class, ['employeeId' => $emp->id])
            ->call('deleteAttachment', $a->id);

        $this->assertSame(1, $emp->attachments()->count());
        $this->assertSame('b.pdf', $emp->attachments()->first()->file_name);
    }
}
