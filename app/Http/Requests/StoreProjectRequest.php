<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'title' => ['required', 'min:3', 'unique:projects'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'technologies' => ['nullable', 'exists:technologies,id'],
            'description' => ['required', 'min:10'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages() {
        return [
            'title.required' => 'Il titolo non può essere vuoto',
            'title.min' => 'Il titolo deve contenere almeno 3 caratteri',
            'title.unique' => 'Non ci possono essere titoli ugali',
            'description.required' => 'Descrizione non può essere vuoto',
            'description.min' => 'Descrizione deve contenere almeno 10 caratteri',
        ];
    }
}
