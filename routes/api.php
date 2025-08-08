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
