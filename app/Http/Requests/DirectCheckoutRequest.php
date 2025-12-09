<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DirectCheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^01[0125][0-9]{8}$/',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
