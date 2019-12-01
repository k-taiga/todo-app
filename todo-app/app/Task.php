<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
  // 状態の定義

  const STATUS = [
    1 => ['label' => '未着手'],
    2 => ['label' => '着手中'],
    3 => ['label' => '完了'],
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
}
