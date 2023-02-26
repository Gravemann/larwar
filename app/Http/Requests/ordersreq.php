<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ordersreq extends FormRequest
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

            'client_id' => 'required',
            'product_id' => 'required',
            'q' => 'required|max:15',
        ];
    }


    public function messages()
    {
        return [

            'client_id.required' => 'The client is not chosen',
            'product_id.required' => 'The product is not chosen',
            'q.required' => 'The quantity is missing',
            'q.max' => 'The quantity can not be more than one billion pcs',
        ];
    }
}
