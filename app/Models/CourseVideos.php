<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $title
 * @property string $video
 * @property string $video_url
 * @property string $info
 * @property string $cover_image
 * @property string $duration
 * @property int $course_id
 */
class CourseVideos extends Model
{
    use HasFactory;

    protected $table = 'course_videos';

    protected $fillable = [
        'title',
        'video',
        'video_url',
        'info',
        'cover_image',
        'duration',
        'course_id'
    ];

    /**
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
