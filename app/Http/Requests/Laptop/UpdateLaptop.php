<?php

namespace App\Http\Requests\Laptop;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLaptop extends FormRequest
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
    public function rules()
    {
        return [
            'marque' => 'required',
            'sn' => 'required|unique:laptops,sn,'.$this->id,
            'reference' => 'required',
            'ram' => 'required',
            'processor' => 'required',
            'disk' => 'required',
            'state' => 'required',
            'affecter' => 'required',
            'remarque' => 'sometimes',
        ];
    }
}
