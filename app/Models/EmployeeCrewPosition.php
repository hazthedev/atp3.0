<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeCrewPosition extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'position', 'sort_order'];

    protected $casts = ['sort_order' => 'integer'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
