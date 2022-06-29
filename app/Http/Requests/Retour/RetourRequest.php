<?php

namespace App\Http\Requests\Retour;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


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
        $rules = [
            'laptop_id' => ['required', Rule::unique('return_salary')->where(function ($query) {
                return $query->where('laptop_id', $this->laptop_id)->where('salary_id', $this->salary_id);
            })],
            'salary_id' => 'required',
            'projet_id' => 'required',
            'affected_at' => 'required|date_format:d/m/Y',
            'rendu_at' => 'sometimes|date_format:d/m/Y',
            'remarque' => 'sometimes',
            'raison' => 'sometimes',
        ];

        return $rules;
    }
}
