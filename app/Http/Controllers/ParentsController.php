<?php

namespace App\Http\Controllers;

use App\DTO\ResponseDTO;
use App\Helper\Slack;
use App\Http\Requests\CheckoutRequest;
use App\Http\Requests\ParentPhoneUpdateRequest;
use App\Http\Requests\ParentUpdateRequest;
use App\Http\Resources\ParentChildrenResource;
use App\Http\Resources\ParentChildrensResource;
use App\Interfaces\IParentsRepository;
use App\Interfaces\ISmsTokenRepository;
use App\Models\Children;
use App\Models\Parents;
use App\Service\ImageUploadService;
use App\Service\SmsService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use OpenApi\Annotations as OA;
use Throwable;

class ParentsController extends Controller
{
    /**
     * @var IParentsRepository
     */
    private IParentsRepository $parents;

    /**
     * @var ISmsTokenRepository
     */
    private ISmsTokenRepository $smsToken;

    /**
     * @var SmsService
     */
    private SmsService $smsService;

    public ResponseDTO $response;

    #[Pure] public function __construct(IParentsRepository $repository, ISmsTokenRepository $smsToken, SmsService $smsService)
    {
        $this->parents = $repository;
        $this->smsToken = $smsToken;
        $this->smsService = $smsService;
        $this->response = new ResponseDTO(201, 'Successful');
    }

    /**
     * @OA\Post(
     *      path="/parent/login",
     *      operationId="storeProject",
     *      tags={"Parents"},
     *      summary="Login parents",
     *      description="Returns message",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ParentLoginRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="application/json",
     *              ref="#/components/schemas/ParentResponseObject"
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
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Parent not Found"
     *      )
     * )
     * @throws Exception
     */
    public function login(Request $request)
    {
        $body = $request->json()->all();
        try {
            $phone = $body['phone'];
            $parent = $this->parents->getParentByPhone($phone);
            if (is_null($parent)) {
                $this->response->setStatusCode(404);
                $this->response->setMessage('Parent not found');
            } else {
                $this->smsService->sendSms($phone);
                $this->response->setMessage('Sms sent successfully');
            }
        } catch (Exception $e) {
            $this->response->invalidParameters();
        }

        return response()->json($this->response)->setStatusCode($this->response->getStatusCode());
    }

    /**
     * @OA\Post(
     *      path="/parent/create",
     *      operationId="parentCreate",
     *      tags={"Parents"},
     *      summary="Parent create",
     *      description="Returns message",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ParentCreateRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="application/json",
     *              ref="#/components/schemas/ParentResponseObject"
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
    public function create(Request $request)
    {
        $this->response->setStatusCode(301);
        $this->response->setMessage('Parent is exists! Please log in!');
        $body = $request->json()->all();
        try {
            $name = $body['name'];
            $phone = $body['phone'];
            $parent = $this->parents->getParentByPhone($phone);
            if (is_null($parent)) {
                $this->smsService->sendSms($phone);
                $this->parents->create([
                    'name' => $name,
                    'phone' => $phone,
                ]);
                $this->response->setStatusCode(201);
                $this->response->setMessage('Sms sent successfully.');
            }
        } catch(Exception $e) {
            $this->response->invalidParameters();
        }

        return response()->json($this->response)->setStatusCode($this->response->getStatusCode());
    }

    /**
     * @OA\Post(
     *      path="/parent/login/attempt",
     *      operationId="loginAttempt",
     *      tags={"Parents"},
     *      summary="Parent login attempt",
     *      description="Returns message",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CheckSmsTokenRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
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
    public function loginAttempt(Request $request)
    {
        $body = $request->json()->all();
        try {
            $phone = $body['phone'];
            $code = $body['code'];
            $smsToken = $this->smsToken->getSmsTokenByPhoneAndCode($phone, $code);
            if ($smsToken) {
                /** @var Parents $parent */
                $parent = $this->parents->getParentByPhone($phone);
                $token = $parent->createToken('auth_token')->plainTextToken;
                $smsToken->delete();
                return $this->respondWithToken($token);
            }
        } catch (Throwable $e) {
            $this->response->invalidParameters();
        }
        $this->response->codeNotFound();

        return response()->json($this->response)->setStatusCode($this->response->getStatusCode());
    }

    /**
     * @OA\Get(
     *      path="/parent/me",
     *      operationId="parentMe",
     *      tags={"Parents"},
     *      summary="Parent me",
     *      description="Returns parent model",
     *      @OA\Parameter(
     *          name="bearer",
     *          in="header",
     *          description="Access token",
     *          required=true
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="application/json",
     *              ref="#/components/schemas/ParentModel"
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
        return $request->user();
    }

    /**
     * @throws Exception
     */
    public function update(ParentUpdateRequest $request)
    {
        $body = $request->validated();
        $parent = $request->user();
        $parent->name = $body['name'];
        if (array_key_exists('image', $body) && is_file($body['image'])) {
            $imagePath = ImageUploadService::upload($body['image']);
            $parent->image = $imagePath;
        }
        $parent->save();
        if ($body['phone'] != $parent->phone) {
            $this->smsService->sendSms($body['phone']);
            return response()->json(['status' => 201, 'message' => 'Iltimos, yangi telefon raqamingizni tasdiqlang.'])->setStatusCode(201);
        }

        return response()->json(['status' => 201, 'parent' => $parent])->setStatusCode(201);
    }

    public function updatePhone(ParentPhoneUpdateRequest $request)
    {
        $body = $request->validated();
        $phone = $body['phone'];
        $code = $body['code'];
        $smsToken = $this->smsToken->getSmsTokenByPhoneAndCode($phone, $code);
        if ($smsToken) {
            $parent = $request->user();
            $parent->phone = $phone;
            $parent->save();
            $smsToken->delete();

            return response()->json(['status' => 201, 'parent' => $parent, 'message' => 'Telefon raqamingiz muvaffaqiyatli yangilandi'])
                ->setStatusCode(201);
        }
        $this->response->codeNotFound();

        return response()->json($this->response)->setStatusCode($this->response->getStatusCode());
    }

    /**
     * @OA\Get(
     *      path="/parent/childrens",
     *      operationId="parentChildrens",
     *      tags={"Parents"},
     *      summary="Parent childrens",
     *      description="Returns parent childrens",
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
     * @return JsonResponse
     */
    public function childrens(Request $request)
    {
        /** @var Parents $user */
        $user = $request->user();
        $childrens = ParentChildrensResource::collection($user->childrens);
        return response()->json(['childrens' => $childrens])->setStatusCode(200);
    }

    public function childrenMe(int $id)
    {
        $children = Children::query()->find($id);
        if (!is_null($children)) {
            $children = ParentChildrenResource::make($children);
            return response()->json($children)->setStatusCode(200);
        }

        return response()->json(['error' => 'Children not found'])->setStatusCode(404);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out!'])->setStatusCode(200);
    }

    public function checkout(CheckoutRequest $request)
    {
        $parentId = $request->user()->getAuthIdentifier();
        $body = $request->validated();
        $amount = $body['amount'];
        $merchantId = config('billing.payme.login');
        if ($merchantId) {
            $checkoutUrl = "https://checkout.paycom.uz/";
            $parameters = "m=" . $merchantId . ";ac.parent_id=$parentId;a=$amount";
            $checkoutUrl = $checkoutUrl . base64_encode($parameters);
            return response()->json(['status' => 200, 'url' => $checkoutUrl])->setStatusCode(200);
        }

        return response()->json(['status' => 500, 'message' => 'Xatolik yuz berdi'])->setStatusCode(500);
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
