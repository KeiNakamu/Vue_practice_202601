<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'max:255'],
            'limit_date' => ['required', 'date'],
            'state' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'タスクは必須です',
            'limit_date.required' => '期限は必須です',
            'limit_date.date' => '正しい日付を入力してください',
            'state.required' => '状態を選択してください',
        ];
    }
}
