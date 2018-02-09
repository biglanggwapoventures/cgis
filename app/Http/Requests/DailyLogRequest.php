<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailyLogRequest extends FormRequest
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
            'remarks' => 'present',
            'consumption' => 'required|array',
            'consumption.*.id' => 'sometimes',
            'consumption.*.deck_id' => 'required|exists:decks,id',
            'consumption.*.feed_id' => 'required|exists:feeds,id',
            'consumption.*.num_feed' => 'required|numeric|min:0',
            'mortality' => 'required|array',
            'mortality.*.id' => 'sometimes',
            'mortality.*.deck_id' => 'required|exists:decks,id',
            'mortality.*.num_am' => 'required|numeric|min:0',
            'mortality.*.num_pm' => 'required|numeric|min:0',
            'delivery' => 'required|array',
            'delivery.*.id' => 'sometimes',
            'delivery.*.feed_id' => 'required|exists:feeds,id',
            'delivery.*.num_feed' => 'required|numeric|min:0',
            'weight' => 'required|array',
            'weight.*.id' => 'sometimes',
            'weight.*.deck_id' => 'required|exists:decks,id',
            'weight.*.optimal_weight' => 'required|numeric|min:0',
            'weight.*.recorded_weight' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'consumption.*.num_feed.required' => 'Please input a number greater or equal to 0',
            'consumption.*.num_feed.numeric' => 'Please input a number greater or equal to 0',
            'consumption.*.num_feed.min' => 'Please input a number greater or equal to 0',
            'mortality.*.num_am.required' => 'Please input a number greater or equal to 0',
            'mortality.*.num_am.integer' => 'Please input a number greater or equal to 0',
            'mortality.*.num_am.min' => 'Please input a number greater or equal to 0',
            'mortality.*.num_pm.required' => 'Please input a number greater or equal to 0',
            'mortality.*.num_pm.integer' => 'Please input a number greater or equal to 0',
            'mortality.*.num_pm.min' => 'Please input a number greater or equal to 0',
            'delivery.*.num_feed.required' => 'Please input a number greater or equal to 0',
            'delivery.*.num_feed.numeric' => 'Please input a number greater or equal to 0',
            'delivery.*.num_feed.min' => 'Please input a number greater or equal to 0',
        ];
    }
}
