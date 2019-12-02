<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTask;

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

    // GET /folders/{id}/tasks/create
    public function showCreateForm(int $id)
    {
      return view('tasks/create', [
        'folder_id' => $id
      ]);
    }

    // POST /folders/{id}/tasks/create
    public function create(int $id, CreateTask $request)
    {
      $current_folder = Folder::find($id);

      $task = new Task();
      $task->title = $request->title;
      $task->due_date = $request->due_date;

      // リレーションを張ってある$current_folderのidに紐づくタスクを保存する
      $current_folder->tasks()->save($task);

      return redirect()->route('tasks.index', [
          'id' =>$current_folder->id,
      ]);
    }

    // GET /folders/{id}/tasks/{task_id}/edit
    public function showEditForm(int $id, int $task_id)
    {
      $task = Task::find($task_id);

      return view('tasks/edit', [
          'task' => $task,
      ]);
    }

   // POST /folders/{id}/tasks/{task_id}/edit
    public function edit(int $id, int $task_id ,EditTask $request)
    {
      $task = Task::find($task_id);

      $task->title = $request->title;
      $task->status = $request->status;
      $task->due_date = $request->due_date;
      $task->save();

      return redirect()->route('tasks.index', [
        'id' => $task->folder_id,
      ]);
    }
}
