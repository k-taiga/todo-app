<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Folder $folder)
    {

      if (Auth::user()->id !== $folder->user_id) {
          abort(403);
      }
      // ユーザーにひもづくフォルダを取得する
      $folders = Auth::user()->folders()->get();

      // $tasks = Task::where('folder_id', $current_folder->id)->get();
      // リレーションを貼ったSQLの取り方に修正
      // $tasks = $current_folder->tasks()->get();

      // ルートバインディングしたデータの取得の仕方に変更
      $tasks = $folder->tasks()->get();

      return view('tasks.index', [
          'folders' => $folders,
          'current_folder_id' => $folder->id,
          'tasks' => $tasks,
        ]);
    }

    /**
     * タスク作成フォーム
     * @param Folder $folder
     * @return \Illuminate\View\View
     */
    // GET /folders/{folder}/tasks/create
    public function showCreateForm(Folder $folder)
    {
      return view('tasks/create', [
        'folder_id' => $folder->id,
      ]);
    }

    /**
     * タスク作成
     * @param Folder $folder
     * @param CreateTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // POST /folders/{folder}/tasks/create
    public function create(Folder $folder, CreateTask $request)
    {

      $task = new Task();
      $task->title = $request->title;
      $task->due_date = $request->due_date;

      // リレーションを張ってある$current_folderのidに紐づくタスクを保存する
      $folder->tasks()->save($task);

      return redirect()->route('tasks.index', [
          'id' =>$folder->id,
      ]);
    }

    /**
     * タスク編集フォーム
     * @param Folder $folder
     * @param Task $task
     * @return \Illuminate\View\View
     */
    // GET /folders/{folder}/tasks/{task}/edit
    public function showEditForm(Folder $folder, Task $task)
    {

      return view('tasks/edit', [
          'task' => $task,
      ]);
    }

   /**
     * タスク編集
     * @param Folder $folder
     * @param Task $task
     * @param EditTask $request
     * @return \Illuminate\Http\RedirectResponse
     */
   // POST /folders/{folder}/tasks/{task}/edit
    public function edit(Folder $folder, Task $task ,EditTask $request)
    {

      $task->title = $request->title;
      $task->status = $request->status;
      $task->due_date = $request->due_date;
      $task->save();

      return redirect()->route('tasks.index', [
        'id' => $task->folder_id,
      ]);
    }
}
