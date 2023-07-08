<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property string $image
 * @property string $description
 * @property string $background
 * @property int $category_id
 */
class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'name',
        'image',
        'description',
        'background',
        'category_id'
    ];

    /**
     * @return HasMany
     */
    public function videos(): HasMany
    {
        return $this->hasMany(CourseVideos::class,'course_id');
    }
}
