<?php

namespace App\Http\Resources;

use App\Models\ChildrenCourses;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ParentChildrensResource extends JsonResource
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
            $imageUrl = Str::contains($imageUrl,'mohirkids.uz') ? $imageUrl : asset($imageUrl);
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $imageUrl,
            'birthdate' => $this->birthdate,
            'grade' => $this->grade,
            'password' => $this->password,
            'code' => $this->code,
            'paid' => $this->paid,
            'daily_usage' => $this->dailyUsage->last()?->usage ?? 0,
            'test_results' => $this->quizResults->avg('result') ?? 0,
            'algorithm_results' => 0,
            'course_counts' => count(ChildrenCourses::courses($this->id, false))
        ];
    }
}
