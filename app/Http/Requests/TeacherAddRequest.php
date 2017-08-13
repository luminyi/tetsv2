<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TeacherAddRequest extends Request
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
            'add-teacherid' => 'required',
        ];
    }
}
