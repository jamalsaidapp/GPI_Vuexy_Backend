<?php

namespace App\Http\Requests\Retour;

use Illuminate\Foundation\Http\FormRequest;

class RetourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        $rules['ordinateur_id'] = 'required' ;
        $rules['salarie_id'] = 'required';
        $rules['affected_at'] = 'required|date';
        $rules['rendu_at'] = 'sometimes|date';
        $rules['remarque'] = 'sometimes';

        return $rules;
    }
}
