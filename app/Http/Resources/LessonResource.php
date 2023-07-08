<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'video' => $this->video,
            'video_url' => $this->video_url,
            'info' => $this->info,
            'cover_image' => $this->cover_image ? asset($this->cover_image) : 'https://mohirkids.uz/storage/istockphoto-1357365823-612x612.jpeg',
            'duration' => $this->duration,
            'course_id' => $this->course_id,
        ];
    }
}
