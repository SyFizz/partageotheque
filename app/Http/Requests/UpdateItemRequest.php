<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'item_name' => 'nullable|exists:items,item_name',
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'item_name.required' => 'Le champ "item_name" est obligatoire.',
            'item_name.exists' => 'Le champ "item_name" doit correspondre à un item existant.',
            'type.required' => 'Le champ "type" est obligatoire.',
            'type.string' => 'Le champ "type" doit être une chaîne de caractères.',
            'type.max' => 'Le champ "type" ne doit pas dépasser 255 caractères.',
            'description.required' => 'Le champ "description" est obligatoire.',
            'description.string' => 'Le champ "description" doit être une chaîne de caractères.',
            'description.max' => 'Le champ "description" ne doit pas dépasser 255 caractères.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
