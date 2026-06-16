<?php

use App\Http\Controllers\CarController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

Route::post('/tokens/create', function (Request $request) {
    $validated = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
        'token_name' => ['nullable', 'string', 'max:255'],
    ]);

    $user = User::where('email', $validated['email'])->first();

    if (! $user || ! Hash::check($validated['password'], $user->password)) {
        return response()->json(['error' => 'Неверный email или пароль.']);
    }

    $token = $user->createToken($validated['token_name'] ?? 'api-token');

    return response()->json([
        'token' => $token->plainTextToken,
    ]);

});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('cars', CarController::class);
});
