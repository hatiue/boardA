<?php

namespace App\Http\Requests\Board;

use Illuminate\Foundation\Http\FormRequest;

class WriteRequest extends FormRequest
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

    public function threadId(): int
    {
        return $this->threadId; // ?
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
