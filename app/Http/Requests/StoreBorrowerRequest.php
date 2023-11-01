<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBorrowerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:borrowers|max:255',
            'role' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'name.string' => 'Le nom doit être une chaîne de caractères.',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'L\'adresse email est déjà utilisée.',
            'email.max' => 'L\'adresse email ne doit pas dépasser 255 caractères.',
            'role.required' => 'Le rôle est obligatoire.',
            'role.string' => 'Le rôle doit être une chaîne de caractères.',
            'role.max' => 'Le rôle ne doit pas dépasser 255 caractères.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
