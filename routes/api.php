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
                Route::get('organisations', 'OrganisationApi@index');
                Route::post('organisations', 'OrganisationApi@store');
                Route::get('organisations/create', 'OrganisationApi@create');
                Route::get('organisations/{id}/edit', 'OrganisationApi@edit');
                Route::patch('organisations/{id}/ban', 'OrganisationApi@ban');
                Route::patch('organisations/{id}/approve', 'OrganisationApi@approve');
                Route::patch('organisations/{id}', 'OrganisationApi@update');
                Route::delete('organisations/{id}', 'OrganisationApi@destroy');

                Route::get('jobs', 'JobApi@index');
                Route::post('jobs', 'JobApi@store');
                Route::get('jobs/create', 'JobApi@create');
                Route::get('jobs/{id}/edit', 'JobApi@edit');
                Route::patch('jobs/{id}/ban', 'JobApi@ban');
                Route::patch('jobs/{id}/approve', 'JobApi@approve');
                Route::patch('jobs/{id}', 'JobApi@update');
                Route::delete('jobs/{id}', 'JobApi@destroy');

            });
        });
    });
});
