<?php

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', '2fa', 'admin']], function () {
    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Content Category
    Route::delete('content-categories/destroy', 'ContentCategoryController@massDestroy')->name('content-categories.massDestroy');
    Route::resource('content-categories', 'ContentCategoryController');

    // Content Tag
    Route::delete('content-tags/destroy', 'ContentTagController@massDestroy')->name('content-tags.massDestroy');
    Route::get('content-tags/search', 'ContentTagController@search')->name('content-tags.search');
    Route::resource('content-tags', 'ContentTagController');

    // Content Page
    Route::delete('content-pages/destroy', 'ContentPageController@massDestroy')->name('content-pages.massDestroy');
    Route::post('content-pages/media', 'ContentPageController@storeMedia')->name('content-pages.storeMedia');
    Route::post('content-pages/ckmedia', 'ContentPageController@storeCKEditorImages')->name('content-pages.storeCKEditorImages');
    Route::resource('content-pages', 'ContentPageController');

    // Type Category
    Route::delete('type-categories/destroy', 'TypeCategoryController@massDestroy')->name('type-categories.massDestroy');
    Route::resource('type-categories', 'TypeCategoryController');

    // Post
    Route::delete('posts/destroy', 'PostController@massDestroy')->name('posts.massDestroy');
    Route::post('posts/media', 'PostController@storeMedia')->name('posts.storeMedia');
    Route::post('posts/ckmedia', 'PostController@storeCKEditorImages')->name('posts.storeCKEditorImages');
    Route::resource('posts', 'PostController');

    // Type Banner
    Route::delete('type-banners/destroy', 'TypeBannerController@massDestroy')->name('type-banners.massDestroy');
    Route::resource('type-banners', 'TypeBannerController');

    // Banner
    Route::delete('banners/destroy', 'BannerController@massDestroy')->name('banners.massDestroy');
    Route::post('banners/media', 'BannerController@storeMedia')->name('banners.storeMedia');
    Route::post('banners/ckmedia', 'BannerController@storeCKEditorImages')->name('banners.storeCKEditorImages');
    Route::resource('banners', 'BannerController');

    // Video
    Route::delete('videos/destroy', 'VideoController@massDestroy')->name('videos.massDestroy');
    Route::post('videos/media', 'VideoController@storeMedia')->name('videos.storeMedia');
    Route::post('videos/ckmedia', 'VideoController@storeCKEditorImages')->name('videos.storeCKEditorImages');
    Route::resource('videos', 'VideoController');

    // Partner
    Route::delete('partners/destroy', 'PartnerController@massDestroy')->name('partners.massDestroy');
    Route::post('partners/media', 'PartnerController@storeMedia')->name('partners.storeMedia');
    Route::post('partners/ckmedia', 'PartnerController@storeCKEditorImages')->name('partners.storeCKEditorImages');
    Route::resource('partners', 'PartnerController');

    // Setting
    Route::delete('settings/destroy', 'SettingController@massDestroy')->name('settings.massDestroy');
    Route::resource('settings', 'SettingController');

    // City
    Route::delete('cities/destroy', 'CityController@massDestroy')->name('cities.massDestroy');
    Route::post('cities/parse-csv-import', 'CityController@parseCsvImport')->name('cities.parseCsvImport');
    Route::post('cities/process-csv-import', 'CityController@processCsvImport')->name('cities.processCsvImport');
    Route::resource('cities', 'CityController');

    // State
    Route::delete('states/destroy', 'StateController@massDestroy')->name('states.massDestroy');
    Route::resource('states', 'StateController');

    // Newsletter
    Route::delete('newsletters/destroy', 'NewsletterController@massDestroy')->name('newsletters.massDestroy');
    Route::post('newsletters/parse-csv-import', 'NewsletterController@parseCsvImport')->name('newsletters.parseCsvImport');
    Route::post('newsletters/process-csv-import', 'NewsletterController@processCsvImport')->name('newsletters.processCsvImport');
    Route::resource('newsletters', 'NewsletterController');

    // Relatorios
    Route::delete('relatorios/destroy', 'RelatoriosController@massDestroy')->name('relatorios.massDestroy');
    Route::resource('relatorios', 'RelatoriosController');

    // Image
    Route::delete('images/destroy', 'ImageController@massDestroy')->name('images.massDestroy');
    Route::post('images/media', 'ImageController@storeMedia')->name('images.storeMedia');
    Route::post('images/ckmedia', 'ImageController@storeCKEditorImages')->name('images.storeCKEditorImages');
    Route::get('images/selectImage', 'ImageController@selectImage')->name('images.selectImage');
    Route::resource('images', 'ImageController');

    // Gallery Photo
    Route::delete('gallery-photos/destroy', 'GalleryPhotoController@massDestroy')->name('gallery-photos.massDestroy');
    Route::post('gallery-photos/media', 'GalleryPhotoController@storeMedia')->name('gallery-photos.storeMedia');
    Route::post('gallery-photos/ckmedia', 'GalleryPhotoController@storeCKEditorImages')->name('gallery-photos.storeCKEditorImages');
    Route::resource('gallery-photos', 'GalleryPhotoController');

    Route::get('global-search', 'GlobalSearchController@search')->name('globalSearch');
});
