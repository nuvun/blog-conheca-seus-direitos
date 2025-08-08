<?php

Route::group(['prefix' => 'v1/auth', 'as' => 'api.auth.', 'namespace' => 'Api\V1\Auth'], function() {

    Route::controller(\App\Http\Controllers\Api\V1\Auth\AuthApiController::class)->group(function () {
        Route::post('/login', 'login')
            ->middleware(['guest'])
            ->name('login');

        Route::post('/logout', 'logout')
            ->middleware(['auth:sanctum'])
            ->name('logout');

        Route::get('recovery-password', 'recoveryPassword');
    });

});

Route::group(['prefix' => 'v1/data', 'as' => 'api.data.', 'namespace' => 'Api\V1\Data'], function() {

    Route::controller(\App\Http\Controllers\Api\V1\Data\ChatController::class)->group(function () {
        Route::get('/chat', 'index')
            ->middleware(['auth:sanctum'])
            ->name('chat.index');
    });

});
