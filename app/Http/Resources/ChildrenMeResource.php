<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ChildrenMeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $imageUrl = $this->image ?? null;
        if (!is_null($imageUrl)) {
            $imageUrl = Str::contains($imageUrl, 'mohirkids.uz') ? $imageUrl : env('APP_STORAGE') . $imageUrl;
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'birthdate' => $this->birthdate,
            'grade' => $this->grade,
            'whois' => $this->whois,
            'image' => $imageUrl,
            'code' => $this->code,
            'password' => $this->password,
            'quiz_counts' => $this->quizResults->count(),
            'quiz_average' => $this->quizResults->avg('result'),
            'parent' => ParentResource::make($this->parent)
        ];
    }
}
