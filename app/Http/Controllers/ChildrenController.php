<?php

namespace App\Http\Controllers;

use App\DTO\ResponseDTO;
use App\Helper\Slack;
use App\Http\Requests\ChildrenCreateRequest;
use App\Http\Requests\ChildrenStartCourseRequest;
use App\Http\Requests\ChildrenUpdateRequest;
use App\Http\Requests\DailyUsageCreateRequest;
use App\Http\Resources\ChildrenMeResource;
use App\Http\Resources\CourseResource;
use App\Interfaces\IChildrenRepository;
use App\Models\Children;
use App\Models\ChildrenCourses;
use App\Models\Course;
use App\Models\DailyUsage;
use App\Service\ImageUploadService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JsonException;
use OpenApi\Annotations as OA;
use Throwable;

class ChildrenController extends Controller
{
    /**
     * @var IChildrenRepository
     */
    private IChildrenRepository $repository;

    /**
     * @var ResponseDTO
     */
    public ResponseDTO $response;

    public function __construct(IChildrenRepository $repository)
    {
        $this->repository = $repository;
        $this->response = new ResponseDTO(201, 'Successful');
    }

    /**
     * @OA\Post(
     *      path="/children/create",
     *      operationId="childrenCreate",
     *      tags={"Parents"},
     *      summary="Create children",
     *      description="Create new children",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ChildrenCreateRequest")
     *      ),
     *      @OA\Parameter(
     *          name="bearer",
     *          in="header",
     *          description="Parent access token",
     *          required=true
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="application/json",
     *              ref="#/components/schemas/ChildrenModel"
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
     * @param ChildrenCreateRequest $request
     * @return JsonResponse
     */
    public function create(ChildrenCreateRequest $request)
    {
        $body = $request->all();
        try {
            if (array_key_exists('image', $body) && is_file($body['image'])) {
                $imagePath = ImageUploadService::upload($body['image']);
            }
            $children = $this->repository->create([
                'name' => $body['name'],
                'birthdate' => $body['birthdate'],
                'grade' => $body['grade'],
                'whois' => $body['whois'],
                'image' => $imagePath ?? null,
                'parent_id' => $request->user()->id
            ]);
            $children = ChildrenMeResource::make($children);
            return response()->json(['status' => 200, 'children' => $children])->setStatusCode(200);
        } catch (\Throwable $exception) {
            return response()->json(['status' => 500, 'message' => 'Error please try again'])->setStatusCode(500);
        }
    }

    /**
     * @OA\Post(
     *      path="/children/check-code",
     *      operationId="childrenCheckCode",
     *      tags={"Children"},
     *      summary="Check children code",
     *      description="Children check code",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ChildrenCheckCodeRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="application/json",
     *              ref="#/components/schemas/ChildrenResponseObject"
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
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkCode(Request $request)
    {
        $body = $request->json()->all();
        $code = $body['code'];
        $children = $this->repository->checkCode($code);
        if (!is_null($children)) {
            $this->response->setMessage('Children found, please enter a password');
            return response()->json($this->response)->setStatusCode($this->response->getStatusCode());
        }
        $this->response->setMessage('Children not found');
        $this->response->setStatusCode(404);

        return response()->json($this->response)->setStatusCode($this->response->getStatusCode());
    }

    /**
     * @OA\Post(
     *      path="/children/login",
     *      operationId="childrenLogin",
     *      tags={"Children"},
     *      description="Chidlren login",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ChildrenLoginRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="application/json",
     *              ref="#/components/schemas/ParentAccessTokenResponse"
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
     * @throws Exception
     */
    public function login(Request $request)
    {
        $body = $request->json()->all();
        try {
            $code = $body['code'];
            $password = $body['password'];
            /** @var Children $children */
            $children = $this->repository->login($code, $password);
            if (!is_null($children)) {
                $token = $children->createToken('auth_token')->plainTextToken;
                return $this->respondWithToken($token);
            } else {
                $this->response->setMessage('Password do not match');
                $this->response->setStatusCode(401);
            }
        } catch (Exception $e) {
            $this->response->invalidParameters();
        }

        return response()->json($this->response)->setStatusCode($this->response->getStatusCode());
    }

    /**
     * @OA\Get(
     *      path="/children/me",
     *      operationId="childrenMe",
     *      tags={"Children"},
     *      summary="Children me",
     *      description="Returns children model",
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
     *              ref="#/components/schemas/ChildrenModel"
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
    public function me(Request $request)
    {
        $user = ChildrenMeResource::make($request->user());
        return response()->json($user)->setStatusCode(200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request)
    {
        $body = $request->json()->all();
        $childrenId = $body['children_id'];
        $this->repository->delete($childrenId);

        return response()->json(['status' => 200, 'message' => 'Children deleted successfully'])->setStatusCode(200);
    }

    public function update(ChildrenUpdateRequest $request)
    {
        $body = $request->validated();
        $childrenId = $body['children_id'];
        try {
            if (array_key_exists('image', $body) && is_file($body['image'])) {
                $imagePath = ImageUploadService::upload($body['image']);
                $body['image'] = $imagePath;
            }
            $this->repository->update($childrenId, $body);
        } catch (Throwable $e) {
            return response()->json(['status' => 500, 'message' => 'Children update failed'])->setStatusCode(500);
        }
        $children = $this->repository->find($childrenId);

        return response()->json(['status' => 200, 'message' => 'Children updated successfully', 'children' => $children])->setStatusCode(200);
    }

    public function startCourse(ChildrenStartCourseRequest $request)
    {
        $courseId = $request->get('course_id');
        try {
            ChildrenCourses::query()->updateOrCreate([
                'course_id' => $courseId,
                'start_date' => now()->format('Y-m-d'),
                'children_id' => $request->user()->id
            ]);
        } catch (Throwable $e) {
            return response()->json(['status' => 500, 'message' => 'Unprocessable Entity'])->setStatusCode(500);
        }

        return response()->json(['status' => 200])->setStatusCode(200);
    }

    public function courses(Request $request)
    {
        $courseIds = ChildrenCourses::courses($request->user()->id, false);
        if (count($courseIds)) {
            $courses = Course::query()->whereIn('id', $courseIds)->get();
            $courses = CourseResource::collection($courses);
        }

        return response()->json(['status' => 200, 'courses' => $courses ?? []])->setStatusCode(200);
    }

    public function finishedCourses(Request $request)
    {
        $courseIds = ChildrenCourses::courses($request->user()->id, true);
        if (count($courseIds)) {
            $courses = Course::query()->whereIn('id', $courseIds)->get();
        }

        return response()->json(['status' => 200, 'courses' => $courses ?? []])->setStatusCode(200);
    }

    public function dailyUsage(DailyUsageCreateRequest $request)
    {
        $body = $request->json()->all();
        try {
            DailyUsage::query()->create([
                'usage' => $body['usage'],
                'children_id' => $request->user()->id
            ]);
            return response()->json(['status' => 200])->setStatusCode(200);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Error'])->setStatusCode(500);
        }
    }

    public function setCourseFinish(Request $request)
    {
        $body = $request->json()->all();
        $user = $request->user();
        try {
            /** @var ChildrenCourses $course */
            $course = ChildrenCourses::query()->where('children_id', $user->id)
                ->where('course_id', $body['course_id'])
                ->where('finished', 0)->first();
            if ($course) {
                $course->end_date = now()->format('Y-m-d');
                $course->finished = true;
                $course->save();
            }
            return response()->json(['status' => 200])->setStatusCode(200);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Error'])->setStatusCode(500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out!'])->setStatusCode(200);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 86400
        ]);
    }
}
