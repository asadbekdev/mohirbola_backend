<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseShowResource extends JsonResource
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
            'name' => $this->name,
            'image' => env('APP_STORAGE') . $this->image,
            'description' => $this->description,
            'background' => env('APP_STORAGE') . $this->background,
            'lessons' => LessonResource::collection($this->videos),
        ];
    }
}
