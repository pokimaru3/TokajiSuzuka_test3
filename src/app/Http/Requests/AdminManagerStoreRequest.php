<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminManagerStoreRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->user()->role === 'admin';
    }


    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|email|string|max:191|unique:users,email',
            'password' => 'required|string|min:8|max:191',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => '名前を入力してください',
            'name.max'          => '名前は50文字以内で入力してください',
            'email.required'    => 'メールアドレスを入力してください',
            'email.email'       => 'メール形式で入力してください',
            'email.unique'      => 'このメールアドレスは既に登録されています',
            'password.required' => 'パスワードを入力してください',
            'password.min'      => 'パスワードは8文字以上で入力してください',
        ];
    }
}
