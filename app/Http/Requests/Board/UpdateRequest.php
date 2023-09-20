<?php

namespace App\Http\Requests\Board;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'content' => 'required|max:256'
        ];
    }

    public function id(): int
    {
        return (int) $this->route('writeId');
    }

    public function content(): string
    {
        return $this->input('content');
    }

    public function flg_anonymous(): string | null
    {
        return $this->input('flg_anonymous');
    }
}
