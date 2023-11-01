<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'item_name' => 'required|unique:items,item_name|regex:/[A-Za-z]+-?[0-9]+/',
            'type' => 'required|string|max:255',
            'description' => 'required|string|min:3|max:255',
            'is_borrowed' => 'required|boolean',
            ];
    }

    public function messages()
    {
        return [
            'item_name.required' => 'Le champ "Référence du matériel" est obligatoire.',
            'item_name.unique' => 'Cette référence existe déjà.',
            'item_name.regex' => 'La référence doit être au format "TEXTE-00".',
            'type.required' => 'Le champ "Type" est obligatoire.',
            'type.string' => 'Le champ "Type" doit être une chaîne de caractères.',
            'type.max' => 'Le champ "Type" ne doit pas dépasser 255 caractères.',
            'description.required' => 'Le champ "Description" est obligatoire.',
            'description.string' => 'Le champ "Description" doit être une chaîne de caractères.',
            'description.min' => 'Le champ "Description" doit contenir au moins 3 caractères.',
            'description.max' => 'Le champ "Description" ne doit pas dépasser 255 caractères.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
