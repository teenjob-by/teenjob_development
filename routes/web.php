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
    return redirect('feedback', 301);
});

Route::get('internship', function(){
    return redirect('internships-for-teens', 301);
});

Route::get('jobs', function(){
    return redirect('jobs-for-teens', 301);
});

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

    Route::resource('volunteerings-for-teens', 'Volunteering', [
        'only' => ['index', 'show'],
        'names' => [
            'index' => 'volunteerings.index',
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

        Route::get('organisation/internships/new', 'Internship@create')->name('internships.create');
        Route::get('organisation/volunteeringss/new', 'Volunteering@create')->name('volunteerings.create');
        Route::get('organisation/events/new', 'Event@create')->name('events.create');
        Route::get('organisation/jobs/new', 'Job@create')->name('jobs.create');


        Route::patch('organisation/internships/{internship}/archive', 'Internship@archive')->name('internships.archive');
        Route::patch('organisation/event/{event}/archive', 'Event@archive')->name('events.archive');
        Route::patch('organisation/volunteerings/archive', 'Volunteering@archive')->name('volunteerings.archive');
        Route::patch('organisation/jobs/{job}/archive', 'Job@archive')->name('jobs.archive');
        Route::patch('organisation/internships/{internship}/unarchive', 'Internship@unarchive')->name('internships.unarchive');
        Route::patch('organisation/events/{event}/unarchive', 'Event@unarchive')->name('events.unarchive');
        Route::patch('organisation/volunteerings/unarchive', 'Volunteering@unarchive')->name('volunteerings.unarchive');
        Route::patch('organisation/jobs/{job}/unarchive', 'Job@unarchive')->name('jobs.unarchive');

        Route::prefix('organisation')->group(function () {
            Route::resource('events', 'Event');

            Route::resource('volunteerings', 'Volunteering');

            Route::resource('internships', 'Internship');

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
Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin', 'Admin\AdminController@index')->name('admin.index');
    /*Route::get('/admin/organisations/approve/{id}', 'Admin\AdminOrganisationsController@approve')->name('admin.organisations.approve');
    Route::get('/admin/organisations/remove/{id}', 'Admin\AdminOrganisationsController@remove')->name('admin.organisations.remove');
    Route::get('/admin/organisations/ban/{id}', 'Admin\AdminOrganisationsController@ban')->name('admin.organisations.ban');
    Route::get('/admin/organisations', 'Admin\AdminOrganisationsController@index')->name('admin.organisation');
    Route::get('/admin/organisations/moderation', 'Admin\AdminOrganisationsController@showUnapproved')->name('admin.organisation.moderation');
    Route::get('/admin/organisation/edit/{id}', 'Admin\AdminOrganisationsController@getOrganisationForm')->name('admin.organisationForm');
    Route::post('/admin/organisation/update', 'Admin\AdminOrganisationsController@update')->name('admin.organisation.update');
    Route::get('/admin/organisation/destroy', 'Admin\AdminOrganisationsController@destroy')->name('admin.organisation.destroy');

    Route::get('/admin/volunteering-for-teens/approve/{id}', 'Admin\AdminVolunteeringsController@approve')->name('admin.volunteerings.approve');
    Route::get('/admin/volunteering-for-teens/remove/{id}', 'Admin\AdminVolunteeringsController@remove')->name('admin.volunteerings.remove');
    Route::get('/admin/volunteering-for-teens/ban/{id}', 'Admin\AdminVolunteeringsController@ban')->name('admin.volunteerings.ban');
    Route::get('/admin/volunteering-for-teens', 'Admin\AdminVolunteeringsController@index')->name('admin.volunteering');
    Route::get('/admin/volunteering-for-teens/moderation', 'Admin\AdminVolunteeringsController@showUnapproved')->name('admin.volunteering.moderation');
    Route::get('/admin/volunteering-for-teens/edit/{id}', 'Admin\AdminVolunteeringsController@edit')->name('admin.volunteeringForm');
    Route::post('/admin/volunteering-for-teens/update', 'Admin\AdminVolunteeringsController@update')->name('admin.volunteering.update');
    Route::get('/admin/volunteering-for-teens/destroy', 'Admin\AdminVolunteeringsController@destroy')->name('admin.volunteering.destroy');

    Route::get('/admin/jobs-for-teens/approve/{id}', 'Admin\AdminVacanciesController@approve')->name('admin.vacancies.approve');
    Route::get('/admin/jobs-for-teens/remove/{id}', 'Admin\AdminVacanciesController@remove')->name('admin.vacancies.remove');
    Route::get('/admin/jobs-for-teens/ban/{id}', 'Admin\AdminVacanciesController@ban')->name('admin.vacancies.ban');
    Route::get('/admin/jobs-for-teens', 'Admin\AdminVacanciesController@index')->name('admin.vacancy');
    Route::get('/admin/jobs-for-teens/moderation', 'Admin\AdminVacanciesController@showUnapproved')->name('admin.vacancy.moderation');
    Route::get('/admin/jobs-for-teens/edit/{id}', 'Admin\AdminVacanciesController@edit')->name('admin.vacancyForm');
    Route::post('/admin/jobs-for-teens/update', 'Admin\AdminVacanciesController@update')->name('admin.vacancy.update');
    Route::get('/admin/jobs-for-teens/destroy', 'Admin\AdminVacanciesController@destroy')->name('admin.vacancy.destroy');

    Route::get('/admin/internships-for-teens/approve/{id}', 'Admin\AdminInternshipsController@approve')->name('admin.internships-for-teens.approve');
    Route::get('/admin/internships-for-teens/remove/{id}', 'Admin\AdminInternshipsController@remove')->name('admin.internships-for-teens.remove');
    Route::get('/admin/internships-for-teens/ban/{id}', 'Admin\AdminInternshipsController@ban')->name('admin.internships-for-teens.ban');
    Route::get('/admin/internships-for-teens', 'Admin\AdminInternshipsController@index')->name('admin.internship');
    Route::get('/admin/internships-for-teens/moderation', 'Admin\AdminInternshipsController@showUnapproved')->name('admin.internships-for-teens.moderation');
    Route::get('/admin/internships-for-teens/edit/{id}', 'Admin\AdminInternshipsController@edit')->name('admin.internshipForm');
    Route::post('/admin/internships-for-teens/update', 'Admin\AdminInternshipsController@update')->name('admin.internships-for-teens.update');
    Route::get('/admin/internships-for-teens/destroy', 'Admin\AdminInternshipsController@destroy')->name('admin.internships-for-teens.destroy');

    Route::get('/admin/events/approve/{id}', 'Admin\AdminEventsController@approve')->name('admin.events.approve');
    Route::get('/admin/events/remove/{id}', 'Admin\AdminEventsController@remove')->name('admin.events.remove');
    Route::get('/admin/events/ban/{id}', 'Admin\AdminEventsController@ban')->name('admin.events.ban');
    Route::get('/admin/events', 'Admin\AdminEventsController@index')->name('admin.events');
    Route::get('/admin/events/moderation', 'Admin\AdminEventsController@showUnapproved')->name('admin.events.moderation');
    Route::get('/admin/events/edit/{id}', 'Admin\AdminEventsController@edit')->name('admin.eventsForm');
    Route::post('/admin/events/update/{id}', 'Admin\AdminEventsController@update')->name('admin.events.update');
    Route::get('/admin/events/destroy', 'Admin\AdminEventsController@destroy')->name('admin.events.destroy');*/
});







