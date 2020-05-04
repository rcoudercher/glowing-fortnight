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


// front routes
Route::name('front.')->group(function() {
  
  // home
  Route::get('/', 'HomeController@index')->name('home');
  
  // user routes
  Route::name('users.')->group(function() {
    Route::get('u/{user:display_name}', 'Front\UserController@show')->name('show');
    Route::get('connexion', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('deconnexion', 'Auth\LoginController@userLogout')->name('logout');
    Route::get('inscription', 'Front\UserController@create')->name('create')->middleware('guest');
    Route::post('inscription', 'Front\UserController@store')->name('store');
    Route::get('mot-de-passe/reinitialiser', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::patch('config/compte/supprimer', 'Front\UserController@destroy')->name('destroy')->middleware('auth');
  });
  
  // community routes
  Route::name('communities.')->group(function () {
    Route::get('r', 'Front\CommunityController@index')->name('index');
    
    Route::get('config/communautes/creer', 'Front\CommunityController@create')->name('create')->middleware('auth');
    Route::post('config/communautes/creer', 'Front\CommunityController@store')->name('store')->middleware('auth');
    
    Route::prefix('r/{community:display_name}')->group(function() {
      Route::get('/', 'Front\CommunityController@show')->name('show');
      Route::patch('/', 'Front\CommunityController@update')->name('update')->middleware('auth');
      Route::get('admin', 'Front\CommunityController@admin')->name('admin');
      Route::get('modifier', 'Front\CommunityController@edit')->name('edit')->middleware('auth');
      Route::post('quitter', 'Front\CommunityController@leave')->name('leave');
      Route::post('rejoindre', 'Front\CommunityController@join')->name('join');
    });
    
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
  
  // settings routes
  Route::name('settings.')->group(function () {
    Route::group(['prefix' => 'config', 'middleware' => 'auth'], function() {
      Route::get('compte', 'SettingsController@account')->name('account');
      Route::get('profil', 'SettingsController@profile')->name('profile');
      Route::get('securite', 'SettingsController@privacy')->name('privacy');
      Route::get('flux', 'SettingsController@feed')->name('feed');
      Route::get('notifications', 'SettingsController@notifications')->name('notifications');
      Route::get('messagerie', 'SettingsController@messaging')->name('messaging');
      Route::get('communautes', 'SettingsController@showCommunities')->name('communities');
      Route::get('modifier-mot-de-passe', 'SettingsController@editUserPassword')->name('password.edit');
      Route::post('modifier-mot-de-passe', 'SettingsController@updateUserPassword')->name('password.update');
    });
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
