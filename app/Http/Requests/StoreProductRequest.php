<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'price' => 'required|numeric|min:0|max:9999999.99',
            'category_id' => 'required|integer|exists:categories,id',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', // slug format validation
                Rule::unique('products', 'slug')
            ],
            'discount_percentage' => 'nullable|numeric|between:0,100',
            'main_features' => 'nullable|array|max:10',
            'main_features.*' => 'required|string|max:255|distinct',
            'is_featured' => 'nullable|boolean',
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
        ];
    }

    public function messages(): array
    {
       return [
    // Name validation messages
    'name.required' => 'Product name is required',
    'name.string' => 'Product name must be a string',
    'name.max' => 'Product name must not exceed 255 characters',

    // Description validation messages
    'description.required' => 'Product description is required',
    'description.string' => 'Description must be a string',
    'description.max' => 'Description must not exceed 5000 characters',

    // Price validation messages
    'price.required' => 'Product price is required',
    'price.numeric' => 'Price must be a number',
    'price.min' => 'Price must be greater than or equal to zero',
    'price.max' => 'Price is too high',

    // Category validation messages
    'category_id.required' => 'Product category is required',
    'category_id.integer' => 'Category must be an integer',
    'category_id.exists' => 'Selected category does not exist',

    // Slug validation messages
    'slug.unique' => 'This slug already exists',
    'slug.regex' => 'Slug must contain only lowercase letters, numbers, and hyphens (e.g., product-name-123)',
    'slug.max' => 'Slug must not exceed 255 characters',

    // Main features validation messages
    'main_features.array' => 'Main features must be an array',
    'main_features.max' => 'Number of main features must not exceed 10',
    'main_features.*.required' => 'Each feature must be provided',
    'main_features.*.string' => 'Each feature must be a string',
    'main_features.*.max' => 'Each feature must not exceed 255 characters',
    'main_features.*.distinct' => 'Features must be unique',

    // Is featured validation messages
    'is_featured.boolean' => 'Featured status must be true or false',

    // Images validation messages
    'images.array' => 'Images must be an array',
    'images.min' => 'At least one image must be uploaded',
    'images.max' => 'Number of images must not exceed 10',
    'images.*.image' => 'Each file must be an image',
    'images.*.mimes' => 'Allowed image types: jpeg, png, jpg, gif, webp',

    // Discount percentage validation messages
    'discount_percentage.numeric' => 'Discount percentage must be a number',
    'discount_percentage.between' => 'Discount percentage must be between 0 and 100',
];

    }
}
