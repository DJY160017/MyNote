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

//登录与注册
Route::any('/index', 'UserController@index');
Route::any('/login', 'UserController@login');
Route::any('/signUp', 'UserController@signUp');

//个人信息
Route::any('/getUserInfo', 'UserController@getProfileInfo');
Route::any('/your_profile', 'UserController@showProfile');
Route::any('/uploadHead', 'UserController@uploadHead');
Route::any('/modifyPassword', 'UserController@modifyPassword');
Route::any('/modifyProfile', 'UserController@modifyProfile');

//笔记
Route::any('/note/create', 'NoteController@createNote');
Route::any('/note/createNote', 'NoteController@create');
Route::any('/note/getInitNotebookInfo', 'NoteController@getInitNotebookInfo');
Route::any('/note/getInitTagInfo', 'NoteController@getInitTagInfo');
Route::any('/note/notelist', 'NoteController@showNotelist');
Route::any('/note/getAllNote', 'NoteController@getAllNote');
Route::any('/note/searchNote', 'NoteController@search');
Route::any('/note/showNote', 'NoteController@showNote');
Route::any('/note/getNote', 'NoteController@getOneNote');
Route::any('/note/modifyNote', 'NoteController@modifyNote');
Route::any('/note/removeNote', 'NoteController@removeNote');


//笔记本
Route::any('/notebook', 'NotebookController@showNotebook');
Route::any('/notebook/create', 'NotebookController@createNotebook');
Route::any('/notebook/createNotebook', 'NotebookController@create');
Route::any('/notebook/getAllNotebook', 'NotebookController@getAllNotebook');
Route::any('/notebook/searchNotebook', 'NotebookController@search');
Route::any('/notebook/modifyNotebookName', 'NotebookController@modifyNotebookID');
Route::any('/notebook/removeNotebook', 'NotebookController@removeNotebook');


//标签创建
Route::any('/tag/create', 'TagController@createTag');
Route::any('/tag/createTag', 'TagController@create');
Route::any('/tag/showSearchResult', 'TagController@showSearchResult');
Route::any('/tag/search', 'TagController@search');

//分享
Route::any('/share', 'ShareController@findFriend');
Route::any('/share/getAllUser', 'ShareController@getAllUser');
Route::any('/share/searchUser', 'ShareController@searchUser');
Route::any('/share/getFriends', 'ShareController@getAllFriend');
Route::any('/share/searchFriend', 'ShareController@searchFriend');
Route::any('/share/noteCheck', 'ShareController@checkNote');
Route::any('/share/addFriend', 'ShareController@addFriend');
Route::any('/share/removeFriend', 'ShareController@removeFriend');
Route::any('/share/getFriendNote', 'ShareController@getFriendNote');
Route::any('/share/showFriendNotes', 'ShareController@showFriendsNotes');
Route::any('/share/getAllFriendNotes', 'ShareController@getAllFriendsNote');


