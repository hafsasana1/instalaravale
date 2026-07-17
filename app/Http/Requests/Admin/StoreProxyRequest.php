<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProxyRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'protocol' => ['required', 'string', 'in:http,https'],
            'hostname' => ['required', 'string', 'max:255'],
            'port' => ['required', 'integer', 'min:1', 'max:65535'],
            'username' => ['required_with:auth', 'nullable', 'string', 'max:255'],
            'password' => ['required_with:auth', 'nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.required_with' => 'The username field is required.',
            'password.required_with' => 'The password field is required.',
        ];
    }
}
