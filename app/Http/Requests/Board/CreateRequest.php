<?php

namespace App\Http\Requests\Board;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:64',
            'content' => 'required|max:256'
        ];
    }

    public function title(): string
    {
        return $this->input('title');
    }

    public function content(): string
    {
        return $this->input('content');
    }

    /* スレッド一覧のテーブルには不要
    public function userId(): int
    {
        return $this->user()->id;
    }
    */

    public function flg_anonymous(): string | null
    {
        return $this->input('flg_anonymous');
    }
}
