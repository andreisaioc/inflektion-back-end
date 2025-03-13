<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuccessfulEmailController;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    return response()->json([
        'token' => $user->createToken('api-token')->plainTextToken
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/emails', [SuccessfulEmailController::class, 'store']);
    Route::get('/emails/{id}', [SuccessfulEmailController::class, 'getById']);
    Route::put('/emails/{id}', [SuccessfulEmailController::class, 'update']);
    Route::get('/emails', [SuccessfulEmailController::class, 'getAll']);
    Route::delete('/emails/{id}', [SuccessfulEmailController::class, 'deleteById']);
});


Route::get('/mock-token', function () {
    $user = \App\Models\User::factory()->create();

    return response()->json([
        'token' => $user->createToken('api-token')->plainTextToken
    ]);
});
