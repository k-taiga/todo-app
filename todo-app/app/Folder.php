<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{

  public function tasks()
  {
    // 実際は
    // $this->hasMany('App\Task', 'folder_id', 'id');
    // 第二引数がテーブル名単数形_id,第三引数がidの場合は省略可
    return $this->hasMany('App\Task');
  }

}
