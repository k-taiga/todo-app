<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;

class FolderController extends Controller
{
    public function showCreateForm()
    {
      return view('folders/create');
    }

    public function create(Request $request)
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
