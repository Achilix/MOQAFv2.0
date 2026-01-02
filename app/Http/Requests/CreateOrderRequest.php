<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'handyman_id' => 'required|exists:handyman,handyman_id',
            'gig_id' => 'nullable|exists:gigs,id_gig',
            'budget' => 'required|numeric|min:0|max:999999.99',
            'description' => 'required|string|max:2000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'handyman_id.required' => 'Handyman selection is required.',
            'handyman_id.exists' => 'Selected handyman does not exist.',
            'gig_id.exists' => 'Selected gig does not exist.',
            'budget.required' => 'Budget is required.',
            'budget.numeric' => 'Budget must be a valid number.',
            'budget.min' => 'Budget must be at least 0.',
            'description.required' => 'Order description is required.',
        ];
    }
}
