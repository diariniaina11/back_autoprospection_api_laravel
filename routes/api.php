<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AiUsageCreditController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ColdEmailModelController;
use App\Http\Controllers\Api\FollowUpController;
use App\Http\Controllers\Api\MessageThreadController;
use App\Http\Controllers\Api\ProspectController;
use App\Http\Controllers\Api\ReplyController;
use App\Http\Controllers\Api\SentEmailController;
use App\Http\Controllers\Api\SuspectController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application.
| All routes are prefixed with /api.
|
*/

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::apiResource('ai-usage-credits', AiUsageCreditController::class);
Route::apiResource('chats', ChatController::class);
Route::apiResource('campaigns', CampaignController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('cold-email-models', ColdEmailModelController::class);
Route::apiResource('follow-ups', FollowUpController::class);
Route::apiResource('message-threads', MessageThreadController::class);
Route::apiResource('prospects', ProspectController::class);
Route::apiResource('replies', ReplyController::class);
Route::apiResource('sent-emails', SentEmailController::class);
Route::apiResource('suspects', SuspectController::class);
Route::apiResource('tests', TestController::class);
Route::apiResource('users', UserController::class);
