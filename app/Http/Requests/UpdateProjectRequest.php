<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
            // nel caso di dati unique in modifica per evitare errori possiamo inserire rule::unique per il title ci permette di modificare gli altri campi eccetto il titolo  che è unique 
            'title' => ['required', 'min:3', Rule::unique('projects')->ignore($this->project)],
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
            'title.unique' => 'Attenzione il titolo è già esistente, generare un nuovo titolo',
            'description.required' => 'Descrizione non può essere vuoto',
            'description.min' => 'Descrizione deve contenere almeno 10 caratteri',
        ];
    }
}
