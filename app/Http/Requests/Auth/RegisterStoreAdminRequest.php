<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStoreAdminRequest extends FormRequest
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
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'image' => 'nullable|mimes:jpg,png,jpeg',
            'phone' => 'nullable|unique:users,phone',
            'email' => 'nullable|unique:users,email',
            'password' => 'required|max:255'
        ];
    }
}
