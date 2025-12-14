<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'price' => 'required|numeric|min:0|max:9999999.99',
            'category_id' => 'required|integer|exists:categories,id',
            'company_id' => 'required|integer|exists:companies,id',
            'slug' => ['sometimes', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('products', 'slug')->ignore($this->route('id'))],
            'is_featured' => 'required|boolean',
            'main_features' => 'sometimes|array|max:10',
            'main_features.*' => 'string|max:255|distinct',
            'discount_percentage' => 'nullable|numeric|between:0,100',

            // الصور
            'old_images' => 'nullable|array',
            'old_images.*' => 'integer|exists:product_images,id',
            'new_images' => 'nullable|array|max:10',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp',
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

            // Company validation messages
            'company_id.required' => 'Product company is required',
            'company_id.integer' => 'Company must be an integer',
            'company_id.exists' => 'Selected company does not exist',

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
            'is_featured.required' => 'Featured status is required',
            'is_featured.boolean' => 'Featured status must be true or false',

            // Discount percentage validation messages
            'discount_percentage.numeric' => 'Discount percentage must be a number',
            'discount_percentage.between' => 'Discount percentage must be between 0 and 100',

            // Images validation messages
            'old_images.array' => 'Old images must be an array',
            'old_images.*.integer' => 'Each old image ID must be an integer',
            'old_images.*.exists' => 'One of the existing images does not exist',
            'new_images.array' => 'New images must be an array',
            'new_images.max' => 'Number of new images must not exceed 10',
            'new_images.*.image' => 'Each file must be a valid image',
            'new_images.*.mimes' => 'Allowed image types: jpeg, png, jpg, gif, webp',
        ];
    }
}
