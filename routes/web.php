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


// front routes
Route::name('front.')->group(function() {
  
  // pages
  Route::get('test', 'PageController@test')->name('test');
  Route::get('test2', 'PageController@test2')->name('test2');
  
  // home
  Route::get('/', 'HomeController@index')->name('home');
  
  // user routes
  Route::name('users.')->group(function() {
    
    Route::redirect('/u/{user:display_name}', '/u/{user:display_name}/publications', 301);
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
    Route::get('post/{post:hash}/vote-count', 'Front\PostController@getVoteCount');
    Route::post('post/{post:hash}/vote', 'Front\PostController@vote');
  });
  
  // comment routes
  Route::name('comments.')->group(function() {
    Route::post('r/{community:display_name}/{post:hash}/{slug}', 'Front\CommentController@store')->name('store')->middleware('auth');
    Route::get('comment/{comment:hash}/vote-count', 'Front\CommentController@getVoteCount');
    Route::post('comment/{comment:hash}/vote', 'Front\CommentController@vote');
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
    Route::resource('community-rules', 'CommunityRuleController');
    
  });
  
  
  Route::get('/', 'AdminController@index')->name('admin.dashboard');
  
});
