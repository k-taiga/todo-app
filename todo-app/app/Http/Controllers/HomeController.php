<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

  public function index()
  {

    // ログインユーザーを取得
    $user = Auth::user();

    // ログインユーザーにひもづくフォルダを１個取得
    $folder = $user->folders()->first();

    // まだ一つもフォルダを作っていなければホームページをレスポンスする
    if (is_null($folder)) {
      return view('home');
    }

    // あればそのフォルダのタスク一覧画面にリダイレクト
    return redirect()->route('tasks.index', [
        'id' => $folder->id,
    ]);
  }
}
