<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizzesResource;
use App\Interfaces\IQuizRepository;
use App\Models\QuizResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use F9Web\ApiResponseHelpers;

class QuizController extends Controller
{
    use ApiResponseHelpers;

    private IQuizRepository $repository;

    public function __construct(IQuizRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Get(
     *      path="/quizzes",
     *      operationId="quizzesList",
     *      tags={"Quiz"},
     *      summary="Get list of quizzes",
     *      description="Get a list of quizzes",
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
     *              ref="#/components/schemas/QuizzesResource"
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
    public function list()
    {
        $quizzes = $this->repository->getActiveQuizzes();
        $quizzes = QuizzesResource::collection($quizzes);
        return $this->respondWithSuccess(['quizzes' => $quizzes]);
    }

    /**
     * @OA\Get(
     *      path="/quiz/{id}",
     *      operationId="getQuiz",
     *      tags={"Quiz"},
     *      summary="Get quiz",
     *      description="Get a single quiz",
     *      @OA\Parameter(
     *          name="bearer",
     *          in="header",
     *          description="Children access token",
     *          required=true
     *      ),
     *     @OA\Parameter(
     *          name="id",
     *          description="Quiz id",
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
     *              ref="#/components/schemas/QuizResource"
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
    public function getById($id)
    {
        $quiz = $this->repository->getById($id);
        if (is_null($quiz)) {
            return $this->respondNotFound('Quiz not found');
        }
        return $this->respondWithSuccess($quiz);
    }

    public function search(Request $request)
    {
        $query = $request->get('title');
        $quizzes = $this->repository->search($query);
        $quizzes = QuizzesResource::collection($quizzes);

        return response()->json(['status' => 200, 'quizzes' => $quizzes])->setStatusCode(200);
    }

    public function finish(Request $request)
    {
        $body = $request->json()->all();
        try {
            QuizResult::query()->create([
                'children_id' => $request->user()->id,
                'quiz_id' => $body['quiz_id'],
                'result' => $body['result']
            ]);
            return response()->json(['status' => 200])->setStatusCode(200);
        } catch (\Exception $e) {
            return response()->json(['status' => 500])->setStatusCode(500);
        }
    }
}
