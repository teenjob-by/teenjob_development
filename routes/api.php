<?php

use Illuminate\Http\Request;
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

Route::namespace('Api')->group(function () {



        Route::prefix('v1')->group(function () {

            Route::post('login', 'Auth@login');
            Route::post('register', 'Auth@register');
            Route::post('logout', 'Auth@logout')->middleware('auth:api');

            Route::namespace('v1')->group(function () {

                Route::group(['middleware' => 'auth:api'], function(){

                Route::get('counters', 'AdminApi@getCounters')->name('counters');

                Route::get('organisations', 'OrganisationApi@index');
                Route::get('organisations/show/{status}', 'OrganisationApi@indexFilter');
                Route::post('organisations', 'OrganisationApi@store');
                Route::get('organisations/create', 'OrganisationApi@create');
                Route::get('organisations/{id}/edit', 'OrganisationApi@edit');
                Route::patch('organisations/{id}/ban', 'OrganisationApi@ban');
                Route::patch('organisations/{id}/approve', 'OrganisationApi@approve');
                Route::patch('organisations/{id}', 'OrganisationApi@update');
                Route::delete('organisations/{id}', 'OrganisationApi@destroy');

                Route::get('jobs', 'JobApi@index');
                Route::get('jobs/show/{status}', 'JobApi@indexFilter');
                Route::post('jobs', 'JobApi@store');
                Route::get('jobs/create', 'JobApi@create');
                Route::get('jobs/{id}/edit', 'JobApi@edit');
                Route::patch('jobs/{id}/ban', 'JobApi@ban');
                Route::patch('jobs/{id}/approve', 'JobApi@approve');
                Route::patch('jobs/{id}/archive', 'JobApi@archive');
                Route::patch('jobs/{id}', 'JobApi@update');
                Route::delete('jobs/{id}', 'JobApi@destroy');

                Route::get('volunteerings', 'VolunteeringApi@index');
                Route::get('volunteerings/show/{status}', 'VolunteeringApi@indexFilter');
                Route::post('volunteerings', 'VolunteeringApi@store');
                Route::get('volunteerings/create', 'VolunteeringApi@create');
                Route::get('volunteerings/{id}/edit', 'VolunteeringApi@edit');
                Route::patch('volunteerings/{id}/ban', 'VolunteeringApi@ban');
                Route::patch('volunteerings/{id}/approve', 'VolunteeringApi@approve');
                Route::patch('volunteerings/{id}/archive', 'VolunteeringApi@archive');
                Route::patch('volunteerings/{id}', 'VolunteeringApi@update');
                Route::delete('volunteerings/{id}', 'VolunteeringApi@destroy');

                Route::get('internships', 'InternshipApi@index');
                Route::get('internships/show/{status}', 'InternshipApi@indexFilter');
                Route::post('internships', 'InternshipApi@store');
                Route::get('internships/create', 'InternshipApi@create');
                Route::get('internships/{id}/edit', 'InternshipApi@edit');
                Route::patch('internships/{id}/ban', 'InternshipApi@ban');
                Route::patch('internships/{id}/approve', 'InternshipApi@approve');
                Route::patch('internships/{id}/archive', 'InternshipApi@archive');
                Route::patch('internships/{id}', 'InternshipApi@update');
                Route::delete('internships/{id}', 'InternshipApi@destroy');

                Route::get('events', 'EventApi@index');
                Route::get('events/show/{status}', 'EventApi@indexFilter');
                Route::post('events', 'EventApi@store');
                Route::get('events/create', 'EventApi@create');
                Route::get('events/{id}/edit', 'EventApi@edit');
                Route::patch('events/{id}/ban', 'EventApi@ban');
                Route::patch('events/{id}/approve', 'EventApi@approve');
                Route::patch('events/{id}/archive', 'EventApi@archive');
                Route::patch('events/{id}', 'EventApi@update');
                Route::delete('events/{id}', 'EventApi@destroy');

            });
        });
    });
});
