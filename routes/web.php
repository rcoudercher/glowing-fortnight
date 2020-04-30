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

Route::get('/', 'HomeController@index')->name('home');
Route::post('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');


Route::name('front.communities.')->group(function () {
  Route::get('r/{community:display_name}', 'FrontController@showCommunity')->name('show');
  Route::post('r/{community:display_name}/rejoindre', 'CommunityController@join')->name('join');
  Route::post('r/{community:display_name}/quitter', 'CommunityController@leave')->name('leave');
});

Route::get('r/{community:display_name}/publier', 'FrontController@createPost')->name('front.posts.create');
Route::post('r/{community:display_name}/publier', 'FrontController@storePost')->name('front.posts.store');
Route::get('r/{community:display_name}/{post:hash}/{slug}', 'FrontController@showPost')->name('front.posts.show');

Route::post('r/{community:display_name}/{post:hash}/{slug}', 'FrontController@storeComment')->name('front.comments.store');



Route::get('u/{user:display_name}', 'FrontController@showUser')->name('front.users.show');

Route::group(['prefix' => 'config', 'middleware' => 'auth'], function() {
  Route::name('user.settings.')->group(function () {
    Route::get('/', 'UserSettingsController@account')->name('index');
    Route::get('compte', 'UserSettingsController@account')->name('account');
    Route::delete('compte/supprimer', 'UserSettingsController@destroyUser')->name('account.destroy');
    
    Route::get('profil', 'UserSettingsController@profile')->name('profile');
    Route::get('securite', 'UserSettingsController@privacy')->name('privacy');
    Route::get('flux', 'UserSettingsController@feed')->name('feed');
    Route::get('notifications', 'UserSettingsController@notifications')->name('notifications');
    Route::get('messagerie', 'UserSettingsController@messaging')->name('messaging');
    
    Route::get('communautes', 'UserSettingsController@communitiesIndex')->name('communities.index');
    Route::get('communautes/creer', 'UserSettingsController@communitiesCreate')->name('communities.create');
    Route::post('communautes/creer', 'UserSettingsController@communitiesStore')->name('communities.store');
    
    
    Route::get('modifier-mot-de-passe', 'UserSettingsController@editUserPassword')->name('password.edit');
    Route::post('modifier-mot-de-passe', 'UserSettingsController@updateUserPassword')->name('password.update');
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
