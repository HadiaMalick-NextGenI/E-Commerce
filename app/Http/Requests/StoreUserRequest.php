<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string',
            'address' => 'required|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'The email address is already registered.',
            // 'password.confirmed' => 'Password confirmation does not match.',
            // 'phone.regex' => 'Enter a valid phone number.',
        ];
    }
}
