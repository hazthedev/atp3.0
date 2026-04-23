<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UtilizationModelRate extends Model
{
    protected $fillable = [
        'code',
        'utilization_model_code',
        'measure_unit_code',
        'jan', 'feb', 'mar', 'apr', 'may', 'jun',
        'jul', 'aug', 'sep', 'oct', 'nov', 'dec',
    ];

    protected $casts = [
        'jan' => 'integer', 'feb' => 'integer', 'mar' => 'integer',
        'apr' => 'integer', 'may' => 'integer', 'jun' => 'integer',
        'jul' => 'integer', 'aug' => 'integer', 'sep' => 'integer',
        'oct' => 'integer', 'nov' => 'integer', 'dec' => 'integer',
    ];

    public function utilizationModel(): BelongsTo
    {
        return $this->belongsTo(UtilizationModel::class, 'utilization_model_code', 'code');
    }

    public function measureUnit(): BelongsTo
    {
        return $this->belongsTo(MeasureUnit::class, 'measure_unit_code', 'code');
    }

    public function monthlyValues(): array
    {
        return [
            'Jan' => $this->jan, 'Feb' => $this->feb, 'Mar' => $this->mar,
            'Apr' => $this->apr, 'May' => $this->may, 'Jun' => $this->jun,
            'Jul' => $this->jul, 'Aug' => $this->aug, 'Sep' => $this->sep,
            'Oct' => $this->oct, 'Nov' => $this->nov, 'Dec' => $this->dec,
        ];
    }
}
