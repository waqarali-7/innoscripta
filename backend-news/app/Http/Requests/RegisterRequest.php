<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Set to true to allow all requests
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8', // Minimum 8 characters
                'confirmed', // Matches a password_confirmation field
                Password::min(8) // Ensures additional rules
                ->letters() // Requires at least one letter
                ->mixedCase() // Requires uppercase and lowercase letters
                ->numbers() // Requires at least one number
                ->symbols(), // Requires at least one symbol
            ],
        ];
    }
}
