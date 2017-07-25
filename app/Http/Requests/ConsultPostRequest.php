<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ConsultPostRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (
            $this->session()->get('role')=='教师'
        || $this->session()->get('role')=='大组长'
        || $this->session()->get('role')=='小组长'
        || $this->session()->get('role')=='督导'
        )
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
            'phone' => 'required|numeric',

        ];
    }
}
