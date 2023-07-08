<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseCategoryResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseShowResource;
use App\Interfaces\ICourseRepository;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class CourseController extends Controller
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *      path="/course/list",
     *      operationId="courseList",
     *      tags={"Courses"},
     *      summary="Get list of courses",
     *      description="Get a list of courses",
     *      @OA\Parameter(
     *          name="bearer",
     *          in="header",
     *          description="Children access token",
     *          required=true
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="application/json",
     *              ref="#/components/schemas/CourseResource"
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $courses = CourseResource::collection($this->repository->getCourses());
        return response()->json($courses)->setStatusCode(200);
    }

    /**
     * @OA\Get(
     *      path="/course/{id}",
     *      operationId="getCourse",
     *      tags={"Courses"},
     *      summary="Get course",
     *      description="Get a single course",
     *      @OA\Parameter(
     *          name="bearer",
     *          in="header",
     *          description="Children access token",
     *          required=true
     *      ),
     *     @OA\Parameter(
     *          name="id",
     *          description="Course id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="application/json",
     *              ref="#/components/schemas/CourseResource"
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     * @return JsonResponse
     */
    public function show(int $courseId)
    {
        $course = $this->repository->getCourse($courseId);
        $course = CourseShowResource::make($course);
        return response()->json($course)->setStatusCode(200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
        $courses = $this->repository->search($query);
        $courses = CourseResource::collection($courses);

        return response()->json(['status' => 200, 'courses' => $courses])->setStatusCode(200);
    }

    public function filter(Request $request)
    {
        $categoryId = $request->get('category_id');
        $courses = $this->repository->filter($categoryId);
        if ($courses) {
            $courses = CourseResource::collection($courses);
            return response()->json(['status' => 200, 'courses' => $courses])->setStatusCode(200);
        }

        return response()->json(['status' => 404, 'message' => 'Kurslar topilmadi'])->setStatusCode(404);
    }
}
