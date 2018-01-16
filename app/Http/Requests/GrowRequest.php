<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GrowRequest extends FormRequest
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
        $growCodeRule = [
            'post' => 'unique:grows',
            'patch' => Rule::unique('grows')->ignore($this->route('grow')),
        ];
        return [
            'grow_code' => [
                'required', 'max:10', $growCodeRule[strtolower($this->method())],
            ],
            'remarks' => 'present',
            'start_date' => 'required|date_format:Y-m-d',
        ];
    }
}
