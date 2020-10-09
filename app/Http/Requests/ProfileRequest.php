<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        return [
            'name' => ['nullable', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:20', Rule::unique('users')->ignore(auth()->id())],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(auth()->id())],
            'bio' => ['nullable', 'string', 'max:150'],
            'website' => ['nullable', 'url', 'max:50']
        ];
    }


    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.string' => __('custom_validation.name.string'),
            'name.max' => __('custom_validation.name.max:50'),
            'username.required' => __('custom_validation.username.required'),
            'username.string' => __('custom_validation.username.string'),
            'username.max' => __('custom_validation.username.max:20'),
            'username.unique' => __('custom_validation.username.unique'),
            'email.required' => __('custom_validation.email.required'),
            'email.email' => __('custom_validation.email.email'),
            'email.max' => __('custom_validation.email.max:255'),
            'email.unique' => __('custom_validation.email.unique'),
            'bio.string' => __('custom_validation.bio.string'),
            'bio.max' => __('custom_validation.bio.max:150'),
            'website.url' => __('custom_validation.website.url'),
            'website.max' => __('custom_validation.max:50'),
        ];
    }
}