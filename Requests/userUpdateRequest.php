<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class userUpdateRequest extends FormRequest
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
        $user_id = $this->input('user_id');
        return [
            'name' => 'required|max:255',
            'email' => [
                'required' ,  'email', Rule::unique('users', 'email')->ignore($user_id)
            ],
            'password' => $this->isMethod('post') ? 'required|min:8|confirmed' : 'nullable|min:8|confirmed'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Enter valid name',
            'name.max' => 'Allowed maximum of 255 letters',        
            'email.required' => 'Enter valid email',
            'email.email' => 'Enter valid email',
            'password.required' => 'Enter valid password',
            'password.min' => 'Enter valid password',
            'password.confirmed' => 'Enter matched password',
            'name.required' => 'Enter valid name',
        ];
    }
}
