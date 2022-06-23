<?php

use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\SubscriberFieldController;
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

Route::apiResource("subscribers", SubscriberController::class);
Route::apiResource("subscribers.fields", SubscriberFieldController::class)->scoped();
