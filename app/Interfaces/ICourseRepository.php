<?php

namespace App\Interfaces;

interface ICourseRepository
{
    public function getCourses();

    public function getCourse(int $courseId);

    public function search(string $search);

    public function filter(int $categoryId);
}
