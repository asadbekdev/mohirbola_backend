<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $name
 * @property string $phone
 * @property string $image
 * @property boolean $is_active
 * @property boolean $is_free
 * @method static ofPhone(string $phone)
 */
class Parents extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'name',
        'phone',
        'image',
        'is_free',
        'is_active',
        'remember_token'
    ];

    /**
     * @return HasMany
     */
    public function childrens(): HasMany
    {
        return $this->hasMany(Children::class,'parent_id');
    }

    /**
     * Scope a query to only include users of a given type.
     *
     * @param Builder $query
     * @param  mixed  $phone
     * @return Builder
     */
    public function scopeOfPhone(Builder $query, string $phone): Builder
    {
        return $query->where('phone', $phone);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return bool
     */
    public function isIsActive(): bool
    {
        return $this->is_active;
    }

    /**
     * @param bool $is_active
     */
    public function setIsActive(bool $is_active): void
    {
        $this->is_active = $is_active;
    }

    /**
     * @return bool
     */
    public function isIsFree(): bool
    {
        return $this->is_free;
    }

    /**
     * @param bool $is_free
     */
    public function setIsFree(bool $is_free): void
    {
        $this->is_free = $is_free;
    }
}
