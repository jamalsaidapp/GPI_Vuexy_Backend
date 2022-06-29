<?php

namespace App\Http\Requests\Affectation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


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

        $rules = [
            'laptop_id' => ['required', Rule::unique('laptop_salary')->where(function ($query) {
                return $query->where('laptop_id', $this->laptop_id);
            })],
            'salary_id' => 'required',
            'projet_id' => 'required',
            'affected_at' => 'required|date_format:d/m/Y',
            'remarque' => 'sometimes',
        ];

        return $rules;
    }
}
