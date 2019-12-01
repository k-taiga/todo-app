<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;
use App\Http\Requests\CreateFolder;

class FolderController extends Controller
{
    public function showCreateForm()
    {
      return view('folders/create');
    }

    // 引数の型を変更
    public function create(CreateFolder $request)
    {

      // Folderモデルのインスタンスを作成
      $folder = new Folder();

      // タイトルに入力値を代入する
      $folder->title = $request->title;

      // インスタンスをデータベースに保存する
      $folder->save();

      return redirect()->route('tasks.index', [
        'id' => $folder->id,
      ]);
    }
}
