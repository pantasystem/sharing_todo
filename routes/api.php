<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Auth::routes();

Route::get('/me', 'UserController@getMe');
Route::get('/me/todos{word?}{page?}{detail?}{start_match?}{end_match?}{order?}', 'TodoController@searchTodos')->name('me.todos.search')
    ->where(['page' => "[0-9]+"]);

//Route::get('/me/todos/{page?}', 'TodoController@todos');
Route::get('/me/todos/{todo_id}', 'TodoController@get');
Route::put('/me/todos/{todo_id}', 'TodoController@achiveMyTodo');
Route::post('/me/todos', 'TodoController@store');


Route::post('/groups', 'GroupController@store');

Route::get('/groups/{group_id}/members/{page?}', 'GroupController@members');

Route::get('/groups/{group_id}/invitations/{page?}', 'GroupInvitationController@invitations');
Route::post('/groups/{group_id}/invitations', 'GroupInvitationController@inviteUser');

Route::get('/groups/{group_id}', 'GroupController@getGroupsTodo');

//Route::get('/groups/{group_id}/todos/{page?}', 'TodoController@todos');
Route::post('/groups/{group_id}/todos', 'TodoController@store');
Route::get('/groups/{group_id}/todos{word?}{page?}{detail?}{start_match?}{end_match?}{order?}', 'TodoController@searchTodos')
    ->name('group.todos.search')->where(['group_id' => '[0-9]+']);

Route::get('/groups/{group_id}/todos/{todo_id}', 'TodoController@getMyTodo');
Route::put('/groups/{group_id}/todos/{todo_id}', 'TodoController@achiveGroupsTodo');








