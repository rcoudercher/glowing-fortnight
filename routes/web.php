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
  
  // moderation
  Route::post('user/{community:hash}/{user}/approve', 'Front\UserController@approve')->name('approve');
  Route::post('user/{community:hash}/{user}/reject', 'Front\UserController@reject')->name('reject');
  // Route::post('user/{community:hash}/{user}/postpone', 'Front\UserController@postpone')->name('postpone');
  
});

// rule routes
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
    Route::get('admin/config', 'Front\CommunityController@editSettings')->name('settings.edit')->middleware('auth');
    Route::patch('admin/config', 'Front\CommunityController@updateSettings')->name('settings.update')->middleware('auth');
    Route::get('admin/moderation', 'Front\CommunityController@moderationIndex')->name('moderation.index')->middleware('auth');
    
    Route::get('modifier', 'Front\CommunityController@edit')->name('edit')->middleware('auth');
    Route::post('leave', 'Front\CommunityController@leave')->name('leave')->middleware('auth');
    Route::post('join', 'Front\CommunityController@join')->name('join')->middleware('auth');
    
  });
});

// post routes
Route::name('posts.')->group(function() {
  Route::get('k/{community:display_name}/publier', 'Front\PostController@create')->name('create')->middleware('auth');
  Route::post('k/{community:display_name}/publier', 'Front\PostController@store')->name('store')->middleware('auth');
  Route::get('k/{community:display_name}/{post:hash}/{slug}', 'Front\PostController@show')->name('show');
  Route::get('post/{post:hash}/vote-count', 'Front\PostController@getVoteCount')->name('vote-count');
  Route::post('post/{post:hash}/vote', 'Front\PostController@vote')->name('vote');
  // moderation
  Route::post('post/{post:hash}/approve', 'Front\PostController@approve')->name('approve');
  Route::post('post/{post:hash}/reject', 'Front\PostController@reject')->name('reject');
  // Route::post('post/{post:hash}/postpone', 'Front\PostController@postpone')->name('postpone');
});

// comment routes
Route::name('comments.')->group(function() {
  Route::post('comment/{post:hash}', 'Front\CommentController@store')->name('store')->middleware('auth');
  Route::post('reply/{comment:hash}', 'Front\CommentController@reply')->name('reply')->middleware('auth');
  Route::get('comment/{comment:hash}/vote-count', 'Front\CommentController@getVoteCount')->name('vote-count');
  Route::post('comment/{comment:hash}/vote', 'Front\CommentController@vote')->name('vote');
  // moderation
  Route::post('comment/{comment:hash}/approve', 'Front\CommentController@approve')->name('approve');
  Route::post('comment/{comment:hash}/reject', 'Front\CommentController@reject')->name('reject');
  // Route::post('comment/{comment:hash}/postpone', 'Front\CommentController@postpone')->name('postpone');
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

// user settings routes
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
    
    Route::middleware('auth:admin')->group(function () {
      
      // model routes
      Route::resource('trophies', 'Admin\TrophyController');
      Route::resource('comments', 'Admin\CommentController');
      Route::resource('posts', 'Admin\PostController');
      Route::resource('communities', 'Admin\CommunityController');
      Route::resource('users', 'Admin\UserController');
      Route::resource('community-rules', 'Admin\CommunityRuleController');
      Route::resource('messages', 'Admin\MessageController');
      
      // membership routes
      Route::prefix('memberships')->group(function() {
        Route::name('memberships.')->group(function() {
          Route::get('/', 'Admin\MembershipController@index')->name('index');
          Route::get('create', 'Admin\MembershipController@create')->name('create');
          Route::post('/', 'Admin\MembershipController@store')->name('store');
          Route::get('{id}', 'Admin\MembershipController@show')->name('show');
          Route::get('{id}/edit', 'Admin\MembershipController@edit')->name('edit');
          Route::patch('{id}', 'Admin\MembershipController@update')->name('update');
          Route::delete('{id}', 'Admin\MembershipController@destroy')->name('destroy');
        });
      });
      
      // moderation routes
      Route::get('moderation/memberships', 'Admin\ModerationController@memberships')->name('moderation.memberships');
      Route::get('moderation/posts', 'Admin\ModerationController@posts')->name('moderation.posts');
      Route::get('moderation/comments', 'Admin\ModerationController@comments')->name('moderation.comments');
      
      Route::get('posts/{post}/set-pending', 'Admin\PostController@setPending')->name('posts.set-pending');
      Route::get('posts/{post}/approve', 'Admin\PostController@approve')->name('posts.approve');
      Route::get('posts/{post}/reject', 'Admin\PostController@reject')->name('posts.reject');
      Route::get('posts/{post}/postpone', 'Admin\PostController@postpone')->name('posts.postpone');
      
      Route::get('comments/{comment}/set-pending', 'Admin\CommentController@setPending')->name('comments.set-pending');
      Route::get('comments/{comment}/approve', 'Admin\CommentController@approve')->name('comments.approve');
      Route::get('comments/{comment}/reject', 'Admin\CommentController@reject')->name('comments.reject');
      Route::get('comments/{comment}/postpone', 'Admin\CommentController@postpone')->name('comments.postpone');
      
      Route::get('memberships/{id}/set-pending', 'Admin\MembershipController@setPending')->name('memberships.set-pending');
      Route::get('memberships/{id}/approve', 'Admin\MembershipController@approve')->name('memberships.approve');
      Route::get('memberships/{id}/reject', 'Admin\MembershipController@reject')->name('memberships.reject');
      Route::get('memberships/{id}/postpone', 'Admin\MembershipController@postpone')->name('memberships.postpone');
    });
    
    
    
    
    
    
    
    
  });
});
