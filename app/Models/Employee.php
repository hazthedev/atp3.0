<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        // Header
        'first_name', 'middle_name', 'last_name',
        'employee_no', 'ext_employee_no', 'active_employee',
        'job_title', 'position', 'department', 'branch',
        'manager_id', 'user_code', 'sales_employee', 'cost_center',
        'office_phone', 'office_phone_ext', 'mobile_phone', 'pager',
        'home_phone', 'fax', 'email', 'linked_vendor', 'photo_path',
        // Address — Work
        'work_street', 'work_street_no', 'work_block', 'work_building_floor_room',
        'work_zip_code', 'work_city', 'work_county', 'work_state', 'work_country',
        // Address — Home
        'home_street', 'home_street_no', 'home_block', 'home_building_floor_room',
        'home_zip_code', 'home_city', 'home_county', 'home_state', 'home_country',
        // Administration
        'start_date', 'status', 'termination_date', 'termination_reason',
        'reference_1', 'reference_1_from', 'reference_1_to',
        'reference_2', 'reference_2_from', 'reference_2_to',
        'admin_remarks', 'work_profile',
        // Personal
        'gender', 'date_of_birth', 'country_of_birth', 'marital_status',
        'number_of_children', 'id_no', 'citizenship',
        'passport_no', 'passport_expiration_date', 'passport_issue_date', 'passport_issuer',
        // Finance
        'salary_amount', 'salary_period',
        'employee_costs_amount', 'employee_costs_period',
        'bank', 'bank_account_no', 'bank_branch',
        // Flight Ops
        'home_base',
        // Remarks
        'remarks',
    ];

    protected $casts = [
        'active_employee' => 'boolean',
        'manager_id' => 'integer',
        'number_of_children' => 'integer',
        'salary_amount' => 'decimal:2',
        'employee_costs_amount' => 'decimal:2',
        'start_date' => 'date',
        'termination_date' => 'date',
        'reference_1_from' => 'date',
        'reference_1_to' => 'date',
        'reference_2_from' => 'date',
        'reference_2_to' => 'date',
        'date_of_birth' => 'date',
        'passport_expiration_date' => 'date',
        'passport_issue_date' => 'date',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(self::class, 'manager_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(self::class, 'manager_id');
    }

    public function roles(): HasMany
    {
        return $this->hasMany(EmployeeRole::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(EmployeeTeam::class);
    }

    public function crewPositions(): HasMany
    {
        return $this->hasMany(EmployeeCrewPosition::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(EmployeeAssignment::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(EmployeeAttachment::class);
    }

    public function fullName(): string
    {
        return trim(implode(' ', array_filter([$this->first_name, $this->middle_name, $this->last_name])));
    }
}
