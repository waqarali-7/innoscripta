<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePreferencesRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all authenticated users
    }

    public function rules()
    {
        return [
            'sources' => 'array',
            'categories' => 'array',
            'authors' => 'array',
        ];
    }
}
