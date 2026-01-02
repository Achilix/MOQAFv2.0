<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->handyman !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'description' => 'required|string|max:2000',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'string',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,category_id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Gig title is required.',
            'type.required' => 'Gig type is required.',
            'description.required' => 'Gig description is required.',
            'photos.max' => 'You can upload maximum 5 photos.',
            'category_ids.*.exists' => 'One or more selected categories do not exist.',
        ];
    }
}
