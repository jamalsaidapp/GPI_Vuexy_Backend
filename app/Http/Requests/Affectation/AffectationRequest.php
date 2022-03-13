<?php

namespace App\Http\Requests\Affectation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AffectationRequest extends FormRequest
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
     * @return string
     */
    public function rules(): array
    {
        $rules = [];

//       $ordinateur_id_rule = $this->ordinateur_id !== $this->old_ordinateur_id ? 'required|unique:ordinateur_salarie,ordinateur_id' : 'required';

        $rules['ordinateur_id'] = 'required';
//        $rules['old_ordinateur_id'] = 'sometimes';
        $rules['salarie_id'] = 'required';
        $rules['affected_at'] = 'required|date';
        $rules['remarque'] = 'sometimes';

        return $rules;
    }
}
