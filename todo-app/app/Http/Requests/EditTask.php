<?php

namespace App\Http\Requests;

use App\Task;
use Illuminate\Validation\Rule;

class EditTask extends CreateTask
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = parent::rules();

        // Ruleのinメソッドは入力値が許可リストに含まれているかチェックする
        // 許可リストはTask::STATUSから配列としてキーを取得
        $status_rule = Rule::in(array_keys(Task::STATUS));

        return $rule + [
            'status' => 'required|' . $status_rule
            // required|in(1,2,3)
        ];
    }

    public function attributes()
    {
        // 親のCreateTaskのattributesメソッドと合体させる
        $attributes = parent::attributes();

        return $attributes + [
            'status' => '状態',
        ];
    }

    public function messages()
    {
        $messages = parent::messages();

        $status_labels = array_map(function($item) {
            return $item['label'];
        }, Task::STATUS);

        $status_labels = implode(',', $status_labels);

        return $messages + [
            // status.inルールのメッセージを作成している
            'status.in' => ':attribute には ' . $status_labels. 'のいずれかを指定してください。',
        ];
    }
}
