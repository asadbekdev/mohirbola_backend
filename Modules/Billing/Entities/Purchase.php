<?php

namespace Modules\Billing\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $parent_id
 * @property float $amount
 * @property string $state
 */
class Purchase extends Model
{
    protected $table = 'purchases';

    protected $fillable = [
        'id',
        'parent_id',
        'amount',
        'state'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function activeTransactions(): HasMany
    {
        return $this->transactions()->where('state', Transaction::STATE_CREATED);
    }

    public function completedTransactions(): HasMany
    {
        return $this->transactions()->where('state', Transaction::STATE_COMPLETED);
    }
}
