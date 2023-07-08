<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $title
 * @property string $image
 */
class CourseCategory extends Model
{
    protected $table = 'course_categories';

    protected $fillable = [
        'id',
        'title',
        'image'
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class,'category_id', 'id');
    }
}
