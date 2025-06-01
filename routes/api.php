<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::apiResource('users', 'UsersApiController');

    // Content Category
    Route::apiResource('content-categories', 'ContentCategoryApiController');

    // Content Tag
    Route::apiResource('content-tags', 'ContentTagApiController');

    // Content Page
    Route::post('content-pages/media', 'ContentPageApiController@storeMedia')->name('content-pages.storeMedia');
    Route::apiResource('content-pages', 'ContentPageApiController');

    // Type Category
    Route::apiResource('type-categories', 'TypeCategoryApiController');

    // Post
    Route::post('posts/media', 'PostApiController@storeMedia')->name('posts.storeMedia');
    Route::apiResource('posts', 'PostApiController');

    // Type Banner
    Route::apiResource('type-banners', 'TypeBannerApiController');

    // Banner
    Route::post('banners/media', 'BannerApiController@storeMedia')->name('banners.storeMedia');
    Route::apiResource('banners', 'BannerApiController');

    // Video
    Route::post('videos/media', 'VideoApiController@storeMedia')->name('videos.storeMedia');
    Route::apiResource('videos', 'VideoApiController');

    // Partner
    Route::post('partners/media', 'PartnerApiController@storeMedia')->name('partners.storeMedia');
    Route::apiResource('partners', 'PartnerApiController');

    // Setting
    Route::apiResource('settings', 'SettingApiController');

    // City
    Route::apiResource('cities', 'CityApiController');

    // State
    Route::apiResource('states', 'StateApiController');

    // Newsletter
    Route::apiResource('newsletters', 'NewsletterApiController');

    // Image
    Route::post('images/media', 'ImageApiController@storeMedia')->name('images.storeMedia');
    Route::apiResource('images', 'ImageApiController');

    // Gallery Photo
    Route::post('gallery-photos/media', 'GalleryPhotoApiController@storeMedia')->name('gallery-photos.storeMedia');
    Route::apiResource('gallery-photos', 'GalleryPhotoApiController');
});

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
