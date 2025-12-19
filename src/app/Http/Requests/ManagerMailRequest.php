<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagerMailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:100',
            'body' => 'required|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => '選択してください',
            'subject.required' => '件名を入力してください',
            'subject.max' => '件名は最大100字までです',
            'body.required' => '本文を入力してください',
            'body.max' => '本文は最大500字までです'
        ];
    }
}
