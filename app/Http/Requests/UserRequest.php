<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UserRequest extends FormRequest
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
        
        if ( request()->url() === Route('register')){
            
            return [
                'name'  => 'required | string | min:4',
                'email' => 'required |  regex:/(.+)@(.+)\.(.+)/i  | unique:users,email,' . request('email'),                
                'password' => 'required | between:6,32 | confirmed'
            ];
        }

        if ( request()->url() === Route('login')){

            return [

                'email' => 'required | exists:users',
                'password' => 'required | between:6,32 '
            ];
        }
        return [];
    }

    public function messages()
    {
        return [

            "name.required" => "name must be filled",
            "name.string" => "name must be string",
            "name.min" => "name must have 4 character or more",
            
            "email.string"   => "email must be filled",            
            "email.unique"   => "this email used by another",
            "email.regex"    => "this not a valid email address!",
            
            "password.required"  => "password must be filled",
            "password.between"  => "password must between 6 to 32 character",
            "password.confirmed"  => "please fill password confirmation ",

        ];
    }
}
