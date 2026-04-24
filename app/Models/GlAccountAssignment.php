<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class GlAccountAssignment extends Model
{
    /**
     * Fixed catalog of account slots rendered in the Accounting tab.
     * Key is persisted in account_type_key; label is the SAP wording.
     *
     * @var array<string, string>
     */
    public const ACCOUNT_TYPES = [
        'expense' => 'Expense Account',
        'revenue' => 'Revenue Account',
        'inventory' => 'Inventory Account',
        'cogs' => 'Cost of Goods Sold Account',
        'allocation' => 'Allocation Account',
        'variance' => 'Variance Account',
        'price_difference' => 'Price Difference Account',
        'negative_inventory_adjustment' => 'Negative Inventory Adjustment Acct',
        'inventory_offset_decrease' => 'Inventory Offset - Decrease Account',
        'inventory_offset_increase' => 'Inventory Offset - Increase Account',
        'sales_returns' => 'Sales Returns Account',
        'exchange_rate_differences' => 'Exchange Rate Differences Account',
        'goods_clearing' => 'Goods Clearing Account',
        'gl_decrease' => 'G/L Decrease Account',
        'gl_increase' => 'G/L Increase Account',
        'inventory_offset_pl' => 'Inventory Offset P&L Account',
        'expense_clearing' => 'Expense Clearing Account',
        'stock_in_transit' => 'Stock In Transit Account',
        'shipped_goods' => 'Shipped Goods Account',
        'sales_credit' => 'Sales Credit Account',
        'purchase_credit' => 'Purchase Credit Account',
    ];

    protected $fillable = [
        'assignable_type',
        'assignable_id',
        'account_type_key',
        'gl_account_id',
    ];

    public function assignable(): MorphTo
    {
        return $this->morphTo();
    }

    public function glAccount(): BelongsTo
    {
        return $this->belongsTo(GlAccount::class);
    }
}
