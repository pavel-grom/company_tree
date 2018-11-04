<?php

namespace App\Http\Requests;

use App\Rules\NotSelfParent;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'full_name' => 'min:3|max:255',
            'photo' => 'nullable|image',
            'position_id' => 'integer|exists:positions,id',
            'wage' => 'integer|min:1',
            'parent_id' => [
                'nullable',
                'integer',
                'exists:employees,id',
                new NotSelfParent($this->route('employee')),
            ],
        ];
    }
}
