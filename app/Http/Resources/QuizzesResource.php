<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizzesResource extends JsonResource
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
            'background' => env('APP_STORAGE') . $this->background,
            'info' => $this->info,
            'question_count' => $this->questions->count(),
        ];
    }
}
