<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
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
            'full_name' => 'required|min:3|max:255',
            'photo' => 'image',
            'position_id' => 'required|integer|exists:positions',
            'wage' => 'required|integer|min:1000',
            'parent_id' => 'required|integer|exists:employees',
        ];
    }
}