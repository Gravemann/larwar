<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class clientsreq extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'a' => 'required|min:2|max:15',
            'b' => 'required|min:2|max:15',
            'c' => 'required|min:10|max:13',
            'd' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'a.required' => 'The name field is empty',
            'a.min' => 'The name must be at least 2 characters',
            'a.max' => 'The name must be no longer that 15 characters',
            'b.required' => 'The surname field is empty',
            'b.min' => 'The surname must be at least 2 characters',
            'b.max' => 'The surname must be no longer that 15 characters',
            'c.required' => 'The telephone field is empty',
            'c.min' => 'The telephone number must be at least 10 character',
            'c.max' => 'The telephone number must be no longer that 13 characters',
            'd.required' => 'The company is missing',
        ];
    }
}
