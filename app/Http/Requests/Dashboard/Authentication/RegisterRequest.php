<?php

namespace App\Http\Requests\Dashboard\Authentication;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:4|max:30',
            'email' => ['required' , 'email' , Rule::unique('admins' , 'email')],
            'phone' => ['required' , 'regex:/^01[0125][0-9]{8}$/' , Rule::unique('admins' , 'phone')],
            'password' => 'required|string|min:9|max:20|confirmed' ,
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'رقم الهاتف يجب أن يكون رقم مصري صحيح يبدأ بـ 010 أو 011 أو 012 أو 015 ومكون من 11 رقم.',
            'phone.unique' => 'رقم الهاتف مسجل بالفعل.',
        ];
    }
}
