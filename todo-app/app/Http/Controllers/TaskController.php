<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(int $id)
    {
      $folders = Folder::all();

      $current_folder = Folder::find($id);

      // $tasks = Task::where('folder_id', $current_folder->id)->get();
      // リレーションを貼ったSQLの取り方に修正
      $tasks = $current_folder->tasks()->get();

      return view('tasks.index', [
          'folders' => $folders,
          'current_folder_id' => $id,
          'tasks' => $tasks,
        ]);
    }
}
