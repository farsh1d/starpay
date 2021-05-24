<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        
        if ( request()->method() === 'PUT'){

            return [

                'title' => 'nullable | min:8| max:255',
                'body'  => 'nullable | min:24',
            ];
        }

        if ( request()->method() === 'POST'){

            return [

                'title' => 'required | min:8| max:255',
                'body'  => 'required | min:24',
            ];

        }
        else{
            return [];
        }
    
    }
    
    public function messages()
    {
        return [

            "title.required" => "title must be filled",
            "title.min"      => "title must max than 8 character",
            "title.max"      => "title must min than 255 character",
            "body.required"  => "title must be filled",
            "body.min"       => "title must max than 24 character",

        ];
    }
    
}
