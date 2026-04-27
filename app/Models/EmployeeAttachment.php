<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeAttachment extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'target_path', 'file_name', 'attachment_date', 'sort_order'];

    protected $casts = [
        'attachment_date' => 'date',
        'sort_order' => 'integer',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
