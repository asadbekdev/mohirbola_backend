<?php

namespace App\Repository;

use App\Interfaces\ICourseRepository;
use App\Models\Course;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CourseRepository implements ICourseRepository
{
    /**
     * @return Builder[]|Collection
     */
    public function getCourses(): Collection|array
    {
        return Course::query()->orderBy('name','ASC')->get();
    }

    /**
     * @param int $courseId
     * @return Model|null
     */
    public function getCourse(int $courseId): Model|null
    {
        return Course::query()->with('videos')->findOrFail($courseId);
    }

    /**
     * @param string $search
     * @return Collection|array
     */
    public function search(string $search): Collection|array
    {
        return Course::query()->where('name', 'LIKE', "%$search%")->get();
    }

    public function filter(int $categoryId): Collection|array
    {
        return Course::query()->where('category_id', '=', $categoryId)->get();
    }
}
