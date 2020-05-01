<?php

use Illuminate\Support\Facades\Route;

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

Route::get('test', 'PageController@test')->name('test');

Auth::routes();

Route::post('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');

// front routes
Route::name('front.')->group(function() {
  
  // home
  Route::get('/', 'HomeController@index')->name('home');
  
  // user routes
  Route::name('users.')->group(function() {
    Route::get('u/{user:display_name}', 'FrontController@showUser')->name('show');
    
    // user settings routes
    Route::group(['prefix' => 'config', 'middleware' => 'auth'], function() {
      Route::name('settings.')->group(function () {
        Route::get('/', 'UserSettingsController@account')->name('index');
        Route::get('compte', 'UserSettingsController@account')->name('account');
        Route::delete('compte/supprimer', 'UserSettingsController@destroyUser')->name('account.destroy');
        Route::get('profil', 'UserSettingsController@profile')->name('profile');
        Route::get('securite', 'UserSettingsController@privacy')->name('privacy');
        Route::get('flux', 'UserSettingsController@feed')->name('feed');
        Route::get('notifications', 'UserSettingsController@notifications')->name('notifications');
        Route::get('messagerie', 'UserSettingsController@messaging')->name('messaging');
        Route::get('communautes', 'UserSettingsController@showCommunities')->name('communities');
        Route::get('modifier-mot-de-passe', 'UserSettingsController@editUserPassword')->name('password.edit');
        Route::post('modifier-mot-de-passe', 'UserSettingsController@updateUserPassword')->name('password.update');
      });
    });
  });
  
  // community routes
  Route::name('communities.')->group(function () {
    Route::get('communautes', 'Front\CommunityController@index')->name('index');
    Route::get('r/{community:display_name}', 'Front\CommunityController@show')->name('show');
    Route::get('config/communautes/creer', 'Front\CommunityController@create')->name('create');
    Route::post('config/communautes/creer', 'Front\CommunityController@store')->name('store');
    Route::post('r/{community:display_name}/rejoindre', 'Front\CommunityController@join')->name('join');
    Route::post('r/{community:display_name}/quitter', 'Front\CommunityController@leave')->name('leave');
    Route::get('r/{community:display_name}/admin', 'Front\CommunityController@admin')->name('admin');
  });
  
  // post routes
  Route::name('posts.')->group(function() {
    Route::get('r/{community:display_name}/publier', 'Front\PostController@create')->name('create');
    Route::post('r/{community:display_name}/publier', 'Front\PostController@store')->name('store');
    Route::get('r/{community:display_name}/{post:hash}/{slug}', 'Front\PostController@show')->name('show');
  });
  
  // comment routes
  Route::name('comments.')->group(function() {
    Route::post('r/{community:display_name}/{post:hash}/{slug}', 'Front\CommentController@store')->name('store');
  });
  
});
  
Route::prefix('admin')->group(function() {
  // admin auth routes
  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
  Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    // password reset routes
  Route::post('password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
  Route::get('password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
  Route::post('password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.update');
  Route::get('password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
  
  Route::middleware('auth:admin')->group(function () {
    Route::resource('trophies', 'TrophyController');
    Route::resource('comments', 'CommentController');
    Route::resource('posts', 'PostController');
    Route::resource('communities', 'CommunityController');
    Route::resource('users', 'UserController');
  });
  
  
  Route::get('/', 'AdminController@index')->name('admin.dashboard');
  
});
