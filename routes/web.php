<?php

/*
 * 301 redirects
 */

Route::get('support', function(){
    return redirect('feedback', 301);
});

Route::get('contacts', function(){
    return redirect('feedback', 301);
});


Route::get('volunteering', function(){
    return redirect('volunteerings-for-teens', 301);
});

Route::any('volunteering/{restOfURL}', function ($restOfURL) {
    return redirect("/volunteerings-for-teens/$restOfURL", 301);
})->where('restOfURL', '.*');

Route::get('internship', function(){
    return redirect('internships-for-teens', 301);
});

Route::any('internship/{restOfURL}', function ($restOfURL) {
    return redirect("/internships-for-teens/$restOfURL", 301);
})->where('restOfURL', '.*');

Route::get('jobs', function(){
    return redirect('jobs-for-teens', 301);
});

Route::any('jobs/{restOfURL}', function ($restOfURL) {
    return redirect("/jobs-for-teens/$restOfURL", 301);
})->where('restOfURL', '.*');

Route::get('offers', function(){
    return redirect('volunteerings-for-teens', 301);
});




/*
 * Authorization routes
 */
Route::namespace('Auth')->group(function() {
    Route::name('auth.')->group(function () {
        Route::get('login', 'Login@showLoginForm')->name('login');
        Route::post('login', 'Login@login');
        Route::post('logout', 'Login@logout')->name('logout');
        Route::get('register', 'Register@showRegistrationForm')->name('register');
        Route::post('register', 'Register@register');
        Route::get('verified', 'Verification@verified')->name('verified');
        Route::get('logout', 'Login@logout')->name('logout');
        Route::get('password/reset/{token}', 'ResetPassword@showResetForm')->name('password.reset');
        Route::get('password/reset', 'ForgotPassword@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'ForgotPassword@sendResetLinkEmail')->name('password.email');
        Route::post('password/reset', 'ResetPassword@reset')->name('password.update');
    });


    Route::get('email/verify', 'Verification@show')->name('verification.notice');
    Route::get('email/verify/{id}', 'Verification@verify')->name('verification.verify');
    Route::get('email/resend', 'Verification@resend')->name('verification.resend');
});


/*
 * Routes available to guests
 */
Route::name('frontend.')->group(function () {

    /*
     * Static pages routes
     */

    Route::get('/', 'StaticPage@home')->name('home');
    Route::get('support-us', 'StaticPage@supportUs')->name('supportUs');
    Route::get('download', 'StaticPage@download')->name('download');
    Route::post('download', 'StaticPage@leaveEmail')->name('leaveEmail');
    Route::get('who-is-volunteer', 'StaticPage@whoIsVolunteer')->name('whoIsVolunteer');
    Route::get('who-is-intern', 'StaticPage@whoIsIntern')->name('whoIsIntern');
    Route::get('terms-of-use', 'StaticPage@termsOfUse')->name('termsOfUse');
    Route::get('employment-law-for-teens', 'StaticPage@employmentLaw')->name('employmentLaw');
    Route::get('faq', 'StaticPage@faq')->name('faq');
    Route::get('conditions', 'StaticPage@conditions')->name('conditions');
    Route::get('about-us', 'StaticPage@aboutUs')->name('aboutUs');
    Route::get('rules-for-employers', 'StaticPage@rulesForEmployers')->name('rulesForEmployers');

    /*
     * Feedback page
     */

    Route::post('feedback', 'StaticPage@sendEmail');
    Route::get('feedback', 'StaticPage@feedback')->name('feedback');


    Route::post('review', 'Review@store')->name('review.create');
    /*
     * Internship routes
     */

    Route::resource('internships-for-teens', 'Internship', [
        'only' => ['index', 'show'],
        'names' => [
            'index' => 'internships.index',
            'show' => 'internships.show'
        ],
        'parameters' => [
            'internships-for-teens' => 'internship'
        ],
    ]);



    /*
     * Volunteering routes
     */
    Route::get('volunteerings-for-teens', 'Offer@index')->name('volunteerings.index');
    Route::resource('volunteerings-for-teens', 'Volunteering', [
        'only' => ['show'],
        'names' => [
            'show' => 'volunteerings.show'
        ],
        'parameters' => [
            'volunteerings-for-teens' => 'volunteering'
        ],
    ]);

    /*
     * Job routes
     */

    Route::resource('jobs-for-teens', 'Job', [
        'only' => ['index', 'show'],
        'names' => [
            'index' => 'jobs.index',
            'show' => 'jobs.show'
        ],
        'parameters' => [
            'jobs-for-teens' => 'job'
        ],

    ]);


    /*
     * Events routes
     */

    Route::resource('events', 'Event', [
        'only' => ['index', 'show'],
        'names' => [
            'index' => 'events.index',
            'show' => 'events.show'
        ],
        'parameters' => [
            'events' => 'event'
        ],
    ]);


    /*
     * Search pages routes
     */

    Route::get('search', 'Search@index')->name('searchs.index');

});


Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'Language@switchLang']);
Route::get('specialities', 'SearchOffers@getSpecialities')->name('site.specialities');
Route::get('cities', 'SearchOffers@getCities')->name('site.cities');
/*
 * Routes available to registered organisations
 */
Route::name('organisation.')->group(function () {

    Route::group(['middleware' => ['auth', 'verified']], function () {

        Route::post('image-upload', 'ImageUpload@imageUploadPost')->name('image.upload.post');

        Route::get('organisation', 'Organisation@index')->name('index');
        Route::get('organisation/update', 'Organisation@getOrganisationForm')->name('update');
        Route::patch('organisation/update', 'Organisation@update')->name('update');
        Route::get('organisation/destroy', 'Organisation@destroy')->name('destroy');

        Route::patch('organisation/internships/{internship}/archive', 'Internship@archive')->name('internships.archive');
        Route::patch('organisation/events/{event}/archive', 'Event@archive')->name('events.archive');
        Route::patch('organisation/volunteerings/{volunteering}/archive', 'Volunteering@archive')->name('volunteerings.archive');
        Route::patch('organisation/jobs/{job}/archive', 'Job@archive')->name('jobs.archive');
        Route::patch('organisation/internships/{internship}/unarchive', 'Internship@unarchive')->name('internships.unarchive');
        Route::patch('organisation/events/{event}/unarchive', 'Event@unarchive')->name('events.unarchive');
        Route::patch('organisation/volunteerings/{volunteering}/unarchive', 'Volunteering@unarchive')->name('volunteerings.unarchive');
        Route::patch('organisation/jobs/{job}/unarchive', 'Job@unarchive')->name('jobs.unarchive');

        Route::prefix('organisation')->group(function () {
            Route::resource('events', 'Event',['names' => [
                    'index' => 'events.index',
                    'show' => 'events.show',
                    'update' => 'events.update',
                    'store' => 'events.store',
                    'destroy' => 'events.destroy',
                ]]
                );

            Route::resource('volunteerings', 'Volunteering', ['names' => [
                'index' => 'volunteerings.index',
                'show' => 'volunteerings.show',
                'update' => 'volunteerings.update',
                'store' => 'volunteerings.store',
                'destroy' => 'volunteerings.destroy',
            ]]);

            Route::resource('internships', 'Internship', [
                'names' => [
                    'index' => 'internships.index',
                    'show' => 'internships.show',
                    'update' => 'internships.update',
                    'store' => 'internships.store',
                    'destroy' => 'internships.destroy',
                ]
            ]);

            Route::resource('jobs', 'Job', [
                'names' => [
                    'index' => 'jobs.index',
                    'show' => 'jobs.show',
                    'update' => 'jobs.update',
                    'store' => 'jobs.store',
                    'destroy' => 'jobs.destroy',
                ]
            ]);
        });
    });
});

/* - routes only for admin */
Route::name('admin.')->group(function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::prefix('admin')->group(function () {

            Route::get('/dashboard', 'Admin\Admin@index')->name('index');

            Route::get('/{any}', 'Admin\Admin@index')->where('any', '.*');
        });
    });
});







