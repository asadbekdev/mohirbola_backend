<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseCategoryResource;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::query()->with('courses')->get();
        $categories = CourseCategoryResource::collection($categories);

        return response()->json(['categories' => $categories])->setStatusCode(200);
    }
}
