<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ActivityChangeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->session()->get('role')=='校级')
            return true;
        else
            return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nameChange' => 'required',
            'start_timeChange' => 'required|date',
            'end_timeChange' => 'required|date|after:start_time',
            'apply_start_timeChange' => 'required|date|before:start_timeChange',
            'apply_end_timeChange' => 'required|date|after:apply_start_time',
            'placeChange' => 'required',
            'all_numChange' => 'required',
            'termChange' => 'regex:/\d{4}-\d{4}-[1-2]$/',
        ];
    }
}
