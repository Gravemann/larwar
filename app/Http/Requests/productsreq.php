<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productsreq extends FormRequest
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
            'brand_id' => 'required',
            'a' => 'required|min:2|max:15',
            'b' => 'required|max:10',
            'c' => 'required|max:15',
            'd' => 'required|max:15',
        ];
    }

    public function messages()
    {
        return [
            'brand_id.required' => 'The brand is not chosen',
            'a.required' => 'The name field is empty',
            'a.min' => 'The name must be at least 1 character',
            'a.max' => 'The name must be no longer that 15 characters',
            'b.required' => 'The buying price is missing',
            'b.max' => 'The buying price can be no longer that one billion',
            'c.required' => 'The selling price is missing',
            'c.max' => 'The selling price can be no longer that one billion',
            'd.required' => 'The quantity is missing',
            'd.max' => 'The quantity can be no more that one billion',
        ];
    }
}
