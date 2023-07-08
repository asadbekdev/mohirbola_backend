<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string $name
 * @property string $birthdate
 * @property string $grade
 * @property string $whois
 * @property string $image
 * @property int $code
 * @property int $password
 * @property bool $paid
 * @property int $parent_id
 * @method static ofCode(int $code)
 * @method static ofLogin(int $code, int $password)
 */
class Children extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'childrens';

    protected $fillable = [
        'name',
        'birthdate',
        'grade',
        'whois',
        'image',
        'code',
        'password',
        'paid',
        'parent_id'
    ];

    public static function booted()
    {
        self::creating(function (Children $children) {
            if (empty($children->password)) {
                $children->password = random_int(100000, 999999);
                $children->code = preg_replace('/[0-9\@\.\;\`\'" "]+/', '', Str::lower($children->name)) . "#" . random_int(1000, 9999);
            }
        });
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Parents::class);
    }

    public function quizResults(): HasMany
    {
        return $this->hasMany(QuizResult::class);
    }

    public function dailyUsage(): HasMany
    {
        return $this->hasMany(DailyUsage::class);
    }

    /**
     * Scope a query to only include users of a given type.
     *
     * @param Builder $query
     * @param  mixed  $code
     * @return Builder
     */
    public function scopeOfCode(Builder $query, mixed $code): Builder
    {
        return $query->where('code', '=', $code);
    }

    public function scopeOfLogin(Builder $query, string $code, string $password): Builder
    {
        return $query->where('code', '=', $code)
            ->where('password', '=', $password);
    }
}
