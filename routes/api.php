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
Route::get('/me/todos/{page?}', 'TodoController@todos');
Route::get('/me/todos/{todo_id}', 'TodoController@get');
Route::put('/me/todos/{todo_id}', 'TodoController@achiveMyTodo');
Route::post('/me/todos', 'TodoController@store');
Route::get('/me/todos/{word?}{page?}', 'TodoController@searchTodosFromMe');


Route::post('/groups', 'GroupController@store');

Route::get('/groups/{group_id}/members/{page?}', 'GroupController@members');

Route::get('/groups/{group_id}/invitations/{page?}', 'GroupInvitationController@invitations');
Route::post('/groups/{group_id}/invitations', 'GroupInvitationController@inviteUser');

Route::get('/groups/{group_id}', 'GroupController@getGroupsTodo');

Route::get('/groups/{group_id}/todos/{page?}', 'TodoController@todos');
Route::post('/groups/{group_id}/todos', 'TodoController@store');
Route::get('/groups/{group_id}/todos{word?}{page?}', 'TodoController@searchTodosFromGroup');

Route::get('/groups/{group_id}/todos/{todo_id}', 'TodoController@getMyTodo');
Route::put('/groups/{group_id}/todos/{todo_id}', 'TodoController@achiveGroupsTodo');








