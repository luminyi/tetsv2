<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ActivityCreateRequest extends Request
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
            'name' => 'required|unique:activities,name',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'place' => 'required',
            'state' => 'required',
            'all_num' => 'required',
            'term' => 'regex:/\d{4}-\d{4}-[1-2]$/',
        ];
    }
}
