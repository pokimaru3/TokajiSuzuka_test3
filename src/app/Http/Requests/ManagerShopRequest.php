<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ManagerShopRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'area' => 'required',
            'genre' => 'required',
            'max_capacity' => 'required|integer|min:1',
            'description' => 'required|string|max:300',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => [
                'nullable', 'email', 'string', 'max:191', Rule::unique('shops', 'email')->ignore(optional($this->shop)->id)],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '店舗名を入力してください',
            'name.max' => '店舗名は50字以内で入力してください',
            'area.required' => 'エリアを選択してください',
            'genre.required' => 'ジャンルを選択してください',
            'max_capacity.required' => '予約可能人数を入力してください。',
            'max_capacity.integer'  => '予約可能人数は数字で入力してください。',
            'max_capacity.min'      => '予約可能人数は1人以上で入力してください。',
            'description.required' => '店舗説明を入力してください',
            'description.max' => '店舗説明は300字以内で入力してください',
            'email' => 'メール形式で入力してください',
            'email.max' => 'メールアドレスは191文字以内で入力してください',
            'image.image' => '画像ファイルを選択してください',
            'image.mimes' => '画像はjpeg,png,jpg,gif形式でアップロードしてください',
            'image.max' => '画像は2MB以内でアップロードしてください',
        ];
    }
}
