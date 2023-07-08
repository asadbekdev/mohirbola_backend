<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $course_id
 * @property string $start_date
 * @property string $end_date
 * @property boolean $finished
 * @property int $children_id
 * @method static courses(mixed $childrenId, boolean $finished)
 */
class ChildrenCourses extends Model
{
    protected $table = 'children_courses';

    protected $fillable = [
        'course_id',
        'start_date',
        'end_date',
        'finished',
        'children_id'
    ];

    public function scopeCourses(Builder $query, int $childrenId, bool $finished = false)
    {
        return $query->where('children_id', '=', $childrenId)
            ->where('finished', $finished)
            ->select('course_id')->pluck('course_id');
    }
}
