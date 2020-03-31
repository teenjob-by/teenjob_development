<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('site.home');
})->name('home');
Route::get('/verified', function () {
    return view('auth.verified');
})->name('verified');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('how-support', 'RulesPagesController@howSupport')->name('site.howsupport');
/**
 * Register Route(s)
 */
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

Auth::routes(['verify' => true]);

/* - site routes */
Route::get('/', 'HomeController@index')->name('home');
Route::get('/internship', 'InternshipController@index')->name('site.internship');
Route::get('/internship/{id}', 'InternshipController@show')->where('id', '[0-9]+');
Route::get('/volunteering', 'VolunteeringController@index')->name('site.volunteering');
Route::get('/volunteering/{id}', 'VolunteeringController@show')->where('id', '[0-9]+');
Route::get('/offers', 'SearchOffersController@index')->name('site.offers');
//Route::get('/events', 'EventsController@index')->name('site.events');
//Route::get('/events/{id}', 'EventsController@show')->where('id', '[0-9]+');
Route::get('/who-is-volunteer', 'RulesPagesController@getVolunteerRules')->name('site.whoisvolunteer');
Route::get('/who-is-intern', 'RulesPagesController@getInternRules')->name('site.whoisintern');
Route::get('/terms-of-use', 'RulesPagesController@getTermsOfUse')->name('site.termsofuse');
Route::get('/vacancy-rules', 'RulesPagesController@getVacancyRules')->name('site.whatisvacancy');
Route::get('/faq', 'RulesPagesController@getFAQ')->name('site.faq');
Route::get('/conditions', 'RulesPagesController@conditions')->name('site.conditions');
Route::get('/about-us', 'RulesPagesController@about')->name('site.about');
Route::get('/support', 'RulesPagesController@support')->name('site.support');
Route::post('/support', 'RulesPagesController@sendEmail')->name('site.support');
Route::get('/contacts', 'RulesPagesController@support')->name('site.contacts');
Route::get('/search', 'SearchController@index')->name('site.search');
Route::get('/eDyn', 'EventsController@indexdynview')->name('site.dynview');
Route::get('/eventsDyn', 'EventsController@indexdyn')->name('site.dyn');
Route::get('/dynTest', 'EventsController@dynTest')->name('site.dyntest');
Route::get('/specialities', 'SearchOffersController@getSpecialities')->name('site.specialities');
Route::get('/cities', 'SearchOffersController@getCities')->name('site.cities');

Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);



Route::resource('events', 'EventsController', [
    'names' => [
        'index' => 'site.events'
    ],
    'only' => ['index', 'show']
]);

Route::resource('volunteering', 'VolunteeringController', [
    'names' => [
        'index' => 'site.volunteering'
    ],
    'only' => ['index', 'show']
]);

Route::resource('internship', 'InternshipController', [
    'names' => [
        'index' => 'site.internship'
    ],
    'only' => ['index', 'show']
]);

Route::resource('vacancy', 'VacancyController', [
    'names' => [
        'index' => 'site.vacancy'
    ],
    'only' => ['index', 'show']
]);
/* - routes only for users */
Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('image-upload', 'ImageUploadController@imageUpload')->name('image.upload');
    Route::post('image-upload', 'ImageUploadController@imageUploadPost')->name('image.upload.post');

    Route::get('/organisation', 'OrganisationsController@getOrganisation')->name('organisation');
    Route::get('/organisation/edit', 'OrganisationsController@getOrganisationForm')->name('account.organisationForm');
    Route::post('/organisation/update', 'OrganisationsController@update')->name('update');
    Route::get('/organisation/destroy', 'OrganisationsController@destroy')->name('destroy');
    Route::get('/organisation/internship/create', 'InternshipController@create')->name('account.internshipForm');
    Route::get('/organisation/volunteering/create', 'VolunteeringController@create')->name('account.volunteeringForm');
    Route::get('/organisation/events/create', 'EventsController@create')->name('account.eventForm');
    Route::get('/organisation/vacancies/create', 'VacancyController@create')->name('account.vacancyForm');
    Route::get('/internship/archive/{id}', 'InternshipController@archive')->name('internship.archive');
    Route::get('/event/archive/{id}', 'EventsController@archive')->name('event.archive');
    Route::get('/volunteering/archive/{id}', 'VolunteeringController@archive')->name('volunteering.archive');
    Route::get('/vacancy/archive/{id}', 'VacancyController@archive')->name('vacancy.archive');
    Route::get('/internship/unarchive/{id}', 'InternshipController@unarchive')->name('internship.unarchive');
    Route::get('/event/unarchive/{id}', 'EventsController@unarchive')->name('event.unarchive');
    Route::get('/volunteering/unarchive/{id}', 'VolunteeringController@unarchive')->name('volunteering.unarchive');
    Route::get('/vacancy/unarchive/{id}', 'VacancyController@unarchive')->name('vacancy.unarchive');


    Route::resource('events', 'EventsController', [
        'names' => [
            'index' => 'site.events'
        ],
        'except' => ['index', 'show']
    ]);
    Route::resource('volunteering', 'VolunteeringController', [
        'names' => [
            'index' => 'site.volunteering'
        ],
        'except' => ['index', 'show']
    ]);

    Route::resource('internship', 'InternshipController', [
        'names' => [
            'index' => 'site.internship'
        ],
        'except' => ['index', 'show']
    ]);

    Route::resource('vacancy', 'VacancyController', [
        'names' => [
            'index' => 'site.vacancy'
        ],
        'except' => ['index', 'show']
    ]);
    //Route::resource('volunteers', 'VolunteersController');
    //Route::resource('offers', 'OffersController');

});

/* - routes only for admin */
Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin', 'Admin\AdminController@index')->name('admin');
    Route::get('/admin/organisations/approve/{id}', 'Admin\AdminOrganisationsController@approve')->name('admin.organisations.approve');
    Route::get('/admin/organisations/remove/{id}', 'Admin\AdminOrganisationsController@remove')->name('admin.organisations.remove');
    Route::get('/admin/organisations/ban/{id}', 'Admin\AdminOrganisationsController@ban')->name('admin.organisations.ban');
    Route::get('/admin/organisations', 'Admin\AdminOrganisationsController@index')->name('admin.organisation');
    Route::get('/admin/organisations/moderation', 'Admin\AdminOrganisationsController@showUnapproved')->name('admin.organisation.moderation');
    Route::get('/admin/organisation/edit/{id}', 'Admin\AdminOrganisationsController@getOrganisationForm')->name('admin.organisationForm');
    Route::post('/admin/organisation/update', 'Admin\AdminOrganisationsController@update')->name('admin.organisation.update');
    Route::get('/admin/organisation/destroy', 'Admin\AdminOrganisationsController@destroy')->name('admin.organisation.destroy');

    Route::get('/admin/volunteerings/approve/{id}', 'Admin\AdminVolunteeringsController@approve')->name('admin.volunteerings.approve');
    Route::get('/admin/volunteerings/remove/{id}', 'Admin\AdminVolunteeringsController@remove')->name('admin.volunteerings.remove');
    Route::get('/admin/volunteerings/ban/{id}', 'Admin\AdminVolunteeringsController@ban')->name('admin.volunteerings.ban');
    Route::get('/admin/volunteerings', 'Admin\AdminVolunteeringsController@index')->name('admin.volunteering');
    Route::get('/admin/volunteerings/moderation', 'Admin\AdminVolunteeringsController@showUnapproved')->name('admin.volunteering.moderation');
    Route::get('/admin/volunteering/edit/{id}', 'Admin\AdminVolunteeringsController@edit')->name('admin.volunteeringForm');
    Route::post('/admin/volunteering/update', 'Admin\AdminVolunteeringsController@update')->name('admin.volunteering.update');
    Route::get('/admin/volunteering/destroy', 'Admin\AdminVolunteeringsController@destroy')->name('admin.volunteering.destroy');

    Route::get('/admin/vacancies/approve/{id}', 'Admin\AdminVacanciesController@approve')->name('admin.vacancies.approve');
    Route::get('/admin/vacancies/remove/{id}', 'Admin\AdminVacanciesController@remove')->name('admin.vacancies.remove');
    Route::get('/admin/vacancies/ban/{id}', 'Admin\AdminVacanciesController@ban')->name('admin.vacancies.ban');
    Route::get('/admin/vacancies', 'Admin\AdminVacanciesController@index')->name('admin.vacancy');
    Route::get('/admin/vacancies/moderation', 'Admin\AdminVacanciesController@showUnapproved')->name('admin.vacancy.moderation');
    Route::get('/admin/vacancy/edit/{id}', 'Admin\AdminVacanciesController@edit')->name('admin.vacancyForm');
    Route::post('/admin/vacancy/update', 'Admin\AdminVacanciesController@update')->name('admin.vacancy.update');
    Route::get('/admin/vacancy/destroy', 'Admin\AdminVacanciesController@destroy')->name('admin.vacancy.destroy');

    Route::get('/admin/internships/approve/{id}', 'Admin\AdminInternshipsController@approve')->name('admin.internship.approve');
    Route::get('/admin/internships/remove/{id}', 'Admin\AdminInternshipsController@remove')->name('admin.internship.remove');
    Route::get('/admin/internships/ban/{id}', 'Admin\AdminInternshipsController@ban')->name('admin.internship.ban');
    Route::get('/admin/internships', 'Admin\AdminInternshipsController@index')->name('admin.internship');
    Route::get('/admin/internships/moderation', 'Admin\AdminInternshipsController@showUnapproved')->name('admin.internship.moderation');
    Route::get('/admin/internships/edit/{id}', 'Admin\AdminInternshipsController@edit')->name('admin.internshipForm');
    Route::post('/admin/internships/update', 'Admin\AdminInternshipsController@update')->name('admin.internship.update');
    Route::get('/admin/internships/destroy', 'Admin\AdminInternshipsController@destroy')->name('admin.internship.destroy');

    Route::get('/admin/events/approve/{id}', 'Admin\AdminEventsController@approve')->name('admin.events.approve');
    Route::get('/admin/events/remove/{id}', 'Admin\AdminEventsController@remove')->name('admin.events.remove');
    Route::get('/admin/events/ban/{id}', 'Admin\AdminEventsController@ban')->name('admin.events.ban');
    Route::get('/admin/events', 'Admin\AdminEventsController@index')->name('admin.events');
    Route::get('/admin/events/moderation', 'Admin\AdminEventsController@showUnapproved')->name('admin.events.moderation');
    Route::get('/admin/events/edit/{id}', 'Admin\AdminEventsController@edit')->name('admin.eventsForm');
    Route::post('/admin/events/update/{id}', 'Admin\AdminEventsController@update')->name('admin.events.update');
    Route::get('/admin/events/destroy', 'Admin\AdminEventsController@destroy')->name('admin.events.destroy');
});
