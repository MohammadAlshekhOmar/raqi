<?php

namespace App\Http\Requests\Editor;

use Illuminate\Foundation\Http\FormRequest;

class EditorRequestEdit extends FormRequest
{
    /**
     * Determine if the admin is authorized to make this request.
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
        return [
            'name' => 'required',
            'email' => 'required|email|unique:editors,email,' . $this->id,
            'phone' => 'nullable|numeric|unique:editors,phone,' . $this->id,
            'password' => 'nullable|min:6|max:15|same:password_confirmation',
            'password_confirmation' => 'nullable|min:6|max:15',
            'image' => 'nullable|image|max:4096|mimes:jpg,jpeg,png,gif|mimetypes:image/jpeg,image/png',
        ];
    }
}
