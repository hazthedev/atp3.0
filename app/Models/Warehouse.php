<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Warehouse extends Model
{
    protected $fillable = [
        'code',
        'name',
        'inactive',
        'drop_ship',
        'location',
        'nettable',
        'issue_part_for_maintenance',
        'enable_bin_locations',
        'street_po_box',
        'street_no',
        'block',
        'building_floor_room',
        'zip_code',
        'city',
        'county',
        'country',
        'state',
        'federal_tax_id',
        'gln',
        'tax_office',
        'address_name_2',
        'address_name_3',
    ];

    protected $casts = [
        'inactive' => 'boolean',
        'drop_ship' => 'boolean',
        'nettable' => 'boolean',
        'issue_part_for_maintenance' => 'boolean',
        'enable_bin_locations' => 'boolean',
    ];

    public function glAccountAssignments(): MorphMany
    {
        return $this->morphMany(GlAccountAssignment::class, 'assignable');
    }
}
