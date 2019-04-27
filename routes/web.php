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

Route::group([], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/test', 'HomeController@test');

    Route::resource('answer', 'AnswerController');
    
    Route::resource('question', 'QuestionController');
    Route::get('question/browse/{id}', 'QuestionController@browseQuestions');

    Route::post('quiz/result/save', 'QuizController@saveQuiz');
    Route::get('quiz/browse', 'QuizController@browseQuizzes');
    Route::resource('quiz', 'QuizController');

    Auth::routes();
    
    Route::namespace('Admin')->prefix('admin')->group(function () {
        Route::get('/', 'DashboardController@index');

        Route::get('login', 'LoginController@showLoginForm')->name('adminLogin')->middleware('guest');

        // Users controller
        Route::resource('users', 'UserController');
        Route::get('users/create_user', 'UserController@createUser');
        Route::get('users/browse_users', 'UserController@browseUsers');
        Route::get('users/edit_user/{id}', 'UserController@editUser');
    });
    
    Route::namespace('User')->prefix('user')->group(function () {
        Route::get('/', 'DashboardController@index');
    });
});

// Catch all page controller (place at the very bottom)
//Route::get('{slug}', ['uses' => 'PageController@getPage'])->where('slug', '([ა-ჰA-Za-z0-9\-\/]+)');