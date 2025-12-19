<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:200'],
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => '評価を選択してください。',
            'rating.between'  => '評価は1〜5の間で選択してください。',
            'comment.max'     => 'コメントは200文字以内で入力してください。',
        ];
    }
}
