<?php

Route::group(['middleware' => 'auth'], function() {
  // ホーム画面
  Route::get('/', 'HomeController@index')->name('home');

  // タスク一覧
  Route::get('/folders/{folder}/tasks', 'TaskController@index')->name('tasks.index');

  // タスク登録
  Route::get('/folders/{folder}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create');
  Route::post('/folders/{folder}/tasks/create', 'TaskController@create');

  // フォルダ登録
  Route::get('/folders/create', 'FolderController@showCreateForm')->name('folders.create');
  Route::post('/folders/create', 'FolderController@create');

  // タスク編集
  Route::get('/folders/{folder}/tasks/{task}/edit', 'TaskController@showEditForm')->name('tasks.edit');
  Route::post('/folders/{folder}/tasks/{tasks}/edit', 'TaskController@edit');
});

// user認証周り
Auth::routes();
