<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FeedRequest extends FormRequest
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
        $descriptionRule = [
            'post' => Rule::unique('feeds'),
            'patch' => Rule::unique('feeds')->ignore($this->route('feed')),
        ];
        return [
            'description' => ['required', 'max:100', $descriptionRule[strtolower($this->method())]],
            'units' => 'required|max:20',
        ];
    }
}
