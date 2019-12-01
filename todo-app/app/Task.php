<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
  // 状態の定義

  const STATUS = [
    1 => ['label' => '未着手', 'class' => 'label-danger'],
    2 => ['label' => '着手中', 'class' => 'label-info'],
    3 => ['label' => '完了', 'class' => ''],
  ];

  // 状態のラベル
  // @return string

  public function getStatusLabelAttribute()
  {
    // 状態が入ったカラムから値を取得
    $status = $this->attributes['status'];

    // 定義されていなければ空文字を返す
    if (!isset(self::STATUS[$status])) {
      return '';
    }

    // 取得したDBの値から上で定義した状態のプロパティを返す
    return self::STATUS[$status]['label'];

  }

  // HTMLのクラスのラベル
  // @return string
  public function getStatusClassAttribute()
  {
    $status = $this->attributes['status'];

    if (!isset(self::STATUS[$status])) {
      return '';
    }

    return self::STATUS[$status]['class'];
  }

  // 期限日の整形
  // @return string
  public function getFormattedDueDateAttribute()
  {
    // Carbonライブラリを使って整形
    return Carbon::createFromFormat('Y-m-d', $this->attributes['due_date'])->format('Y/m/d');
  }
}
