<?php

use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\QuizController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function () {
    Route::prefix('parent')->group(function () {
        Route::post('login', [ParentsController::class, 'login']);
        Route::post('login/attempt', [ParentsController::class, 'loginAttempt']);
        Route::post('create', [ParentsController::class, 'create']);
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('me', [ParentsController::class, 'me']);
            Route::get('childrens', [ParentsController::class, 'childrens']);
            Route::get('children/{id}', [ParentsController::class, 'childrenMe']);
            Route::post('update', [ParentsController::class, 'update']);
            Route::post('update/phone', [ParentsController::class, 'updatePhone']);
            Route::post('children/delete', [ChildrenController::class, 'delete']);
            Route::post('children/update', [ChildrenController::class, 'update']);
            Route::post('logout', [ParentsController::class, 'logout']);
        });
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('get-course/categories', [CourseCategoryController::class, 'index']);
    });
    Route::middleware('auth:sanctum')->prefix('children')->group(function () {
        Route::post('create', [ChildrenController::class, 'create']);
        Route::post('start-course', [ChildrenController::class, 'startCourse']);
        Route::get('courses', [ChildrenController::class, 'courses']);
        Route::get('finished-courses', [ChildrenController::class, 'finishedCourses']);
        Route::post('set-finish-course', [ChildrenController::class, 'setCourseFinish']);
    });
    Route::prefix('children')->group(function () {
        Route::post('check-code', [ChildrenController::class, 'checkCode']);
        Route::post('login', [ChildrenController::class, 'login']);
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('me', [ChildrenController::class, 'me']);
            Route::post('daily/usage', [ChildrenController::class, 'dailyUsage']);
            Route::post('logout', [ChildrenController::class, 'logout']);
        });
    });
    Route::middleware('auth:sanctum')->prefix('course')->group(function () {
        Route::get('list', [CourseController::class, 'index']);
        Route::get('search', [CourseController::class, 'search']);
        Route::get('filter', [CourseController::class, 'filter']);
        Route::get('/{courseId}', [CourseController::class, 'show']);
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('quizzes', [QuizController::class, 'list']);
        Route::get('quiz/search', [QuizController::class, 'search']);
        Route::get('quiz/{id}', [QuizController::class, 'getById']);
        Route::post('quiz/finish', [QuizController::class, 'finish']);
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('send-invoice', [InvoiceController::class, 'sendInvoice']);
        Route::get('get-invoices', [InvoiceController::class, 'getInvoices']);
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('checkout', [ParentsController::class, 'checkout']);
    });
});
