<?php

namespace App\Http\Resources;

use App\Models\ChildrenCourses;
use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ParentChildrenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  $request
     * @return array
     */
    public function toArray($request): array
    {
        $currentCourses = ChildrenCourses::courses($this->id, false);
        $finishedCourses = ChildrenCourses::courses($this->id, true);
        $quizIds = \DB::table('quiz_results')->where('children_id', '=', $this->id)->pluck('quiz_id');
        $quizAvg = \DB::table('quiz_results')->where('children_id', '=', $this->id)->avg('result');
        $imageUrl = $this->image ?? null;
        if (!is_null($imageUrl)) {
            $imageUrl = Str::contains($imageUrl, 'mohirkids.uz') ? $imageUrl : env('APP_STORAGE') . $imageUrl;
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $imageUrl,
            'birthdate' => $this->birthdate,
            'grade' => $this->grade,
            'whois' => $this->whois,
            'password' => $this->password,
            'code' => $this->code,
            'paid' => $this->paid,
            'daily_usage' => $this->dailyUsage->last()?->usage ?? 0,
            'test_results' => $this->quizResults->avg('result') ?? 0,
            'algorithm_results' => 0,
            'current_courses' => CourseResource::collection(Course::query()->whereIn('id', $currentCourses)->get()),
            'finished_courses' => CourseResource::collection(Course::query()->whereIn('id', $finishedCourses)->get()),
            'parent' => $this->parent,
            'quiz_average' => (int)$quizAvg,
            'quizzes' => QuizzesResource::collection(Quiz::query()->whereIn('id', $quizIds)->get()),
        ];
    }
}
