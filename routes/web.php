<?php

use Illuminate\Support\Facades\Route;

use App\Post;

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

Auth::routes();
  
// pages
Route::get('test', 'Front\PageController@test')->name('test');
Route::get('test2', 'Front\PageController@test2')->name('test2');

// home
Route::get('/', 'Front\HomeController@index')->name('home');

// user routes
Route::name('users.')->group(function() {
  Route::redirect('/u/{user:display_name}', '/u/{user:display_name}/publications', 301)->name('show');
  Route::get('u/{user:display_name}/publications', 'Front\UserController@showPosts')->name('show.posts');
  Route::get('u/{user:display_name}/commentaires', 'Front\UserController@showComments')->name('show.comments');
  Route::get('connexion', 'Auth\LoginController@showLoginForm')->name('login');
  Route::post('deconnexion', 'Auth\LoginController@userLogout')->name('logout');
  Route::get('inscription', 'Front\UserController@create')->name('create')->middleware('guest');
  Route::post('inscription', 'Front\UserController@store')->name('store');
  Route::get('mot-de-passe/reinitialiser', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
  Route::patch('config/compte/supprimer', 'Front\UserController@destroy')->name('destroy')->middleware('auth');
});

// community rule routes
Route::name('community-rules.')->group(function() {
  Route::group(['prefix' => 'k/{community:display_name}/admin/regle', 'middleware' => 'auth'], function() {
    // Route::get('/', 'Front\CommunityRuleController@index')->name('index');
    Route::get('creer', 'Front\CommunityRuleController@create')->name('create');
    Route::post('/', 'Front\CommunityRuleController@store')->name('store');
    // Route::get('{community_rule:hash}', 'Front\CommunityRuleController@show')->name('show');
    Route::get('{community_rule:hash}/modifier', 'Front\CommunityRuleController@edit')->name('edit');
    Route::patch('{community_rule:hash}', 'Front\CommunityRuleController@update')->name('update');
    Route::delete('{community_rule:hash}', 'Front\CommunityRuleController@destroy')->name('destroy');
    Route::get('{community_rule:hash}/up', 'Front\CommunityRuleController@up')->name('up');
    Route::get('{community_rule:hash}/down', 'Front\CommunityRuleController@down')->name('down');
  });
});

// community routes
Route::name('communities.')->group(function () {
  Route::get('k', 'Front\CommunityController@index')->name('index');
  Route::get('config/communautes/creer', 'Front\CommunityController@create')->name('create')->middleware('auth');
  Route::post('config/communautes/creer', 'Front\CommunityController@store')->name('store')->middleware('auth');
  Route::prefix('k/{community:display_name}')->group(function() {
    Route::get('/', 'Front\CommunityController@show')->name('show');
    Route::patch('/', 'Front\CommunityController@update')->name('update')->middleware('auth');
    Route::get('admin', 'Front\CommunityController@showAdminDashboard')->name('admin.dashboard')->middleware('auth');
    Route::get('modifier', 'Front\CommunityController@edit')->name('edit')->middleware('auth');
    Route::post('quitter', 'Front\CommunityController@leave')->name('leave');
    Route::post('rejoindre', 'Front\CommunityController@join')->name('join');
  });
});

// post routes
Route::name('posts.')->group(function() {
  Route::get('k/{community:display_name}/publier', 'Front\PostController@create')->name('create')->middleware('auth');
  Route::post('k/{community:display_name}/publier', 'Front\PostController@store')->name('store')->middleware('auth');
  Route::get('k/{community:display_name}/{post:hash}/{slug}', 'Front\PostController@show')->name('show');
  Route::get('post/{post:hash}/vote-count', 'Front\PostController@getVoteCount')->name('vote-count');
  Route::post('post/{post:hash}/vote', 'Front\PostController@vote')->name('vote');
});

// comment routes
Route::name('comments.')->group(function() {
  Route::post('comment/{post:hash}', 'Front\CommentController@store')->name('store')->middleware('auth');
  Route::post('reply/{comment:hash}', 'Front\CommentController@reply')->name('reply')->middleware('auth');
  Route::get('comment/{comment:hash}/vote-count', 'Front\CommentController@getVoteCount')->name('vote-count');
  Route::post('comment/{comment:hash}/vote', 'Front\CommentController@vote')->name('vote');
});

// message routes
Route::name('messages.')->group(function() {
  Route::group(['prefix' => 'message', 'middleware' => 'auth'], function() {
    Route::get('boite-de-reception', 'Front\MessageController@inbox')->name('inbox');
    Route::get('non-lus', 'Front\MessageController@unread')->name('unread');
    Route::get('envoyes', 'Front\MessageController@sent')->name('sent');
    Route::get('archives', 'Front\MessageController@archived')->name('archived');
    // Route::get('supprimes', 'Front\MessageController@deleted')->name('deleted');
    Route::get('nouveau', 'Front\MessageController@create')->name('create');
    Route::post('/', 'Front\MessageController@store')->name('store');
    Route::get('{message:hash}', 'Front\MessageController@show')->name('show');
    Route::get('{message:hash}/repondre', 'Front\MessageController@reply')->name('reply');
    Route::post('{message:hash}/repondre', 'Front\MessageController@storeReply')->name('store-reply');
    Route::delete('{message:hash}', 'Front\MessageController@destroy')->name('destroy');
    Route::post('{message:hash}/mark-unread', 'Front\MessageController@markUnread')->name('mark-unread');
    Route::post('{message:hash}/archive', 'Front\MessageController@archive')->name('archive');
  });
});

// settings routes
Route::name('settings.')->group(function () {
  Route::group(['prefix' => 'config', 'middleware' => 'auth'], function() {
    Route::get('compte', 'Front\SettingsController@account')->name('account');
    Route::get('profil', 'Front\SettingsController@profile')->name('profile');
    Route::get('securite', 'Front\SettingsController@privacy')->name('privacy');
    Route::get('flux', 'Front\SettingsController@feed')->name('feed');
    Route::get('notifications', 'Front\SettingsController@notifications')->name('notifications');
    Route::get('messagerie', 'Front\SettingsController@messaging')->name('messaging');
    Route::get('communautes', 'Front\SettingsController@showCommunities')->name('communities');
    Route::get('modifier-mot-de-passe', 'Front\SettingsController@editUserPassword')->name('password.edit');
    Route::post('modifier-mot-de-passe', 'Front\SettingsController@updateUserPassword')->name('password.update');
  });
});

// admin routes
Route::prefix('admin')->group(function() {
  Route::name('admin.')->group(function() {
    Route::get('/', 'Admin\AdminController@index')->name('dashboard');
    // auth routes
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('login.submit');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('logout');
    // password reset routes
    Route::post('password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/reset', 'Auth\AdminResetPasswordController@reset')->name('password.update');
    Route::get('password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('password.reset');
    // model routes
    Route::middleware('auth:admin')->group(function () {
      Route::resource('trophies', 'Admin\TrophyController');
      Route::resource('comments', 'Admin\CommentController');
      Route::resource('posts', 'Admin\PostController');
      Route::resource('communities', 'Admin\CommunityController');
      Route::resource('users', 'Admin\UserController');
      Route::resource('community-rules', 'Admin\CommunityRuleController');
      Route::resource('messages', 'Admin\MessageController');
    });
  });
});
