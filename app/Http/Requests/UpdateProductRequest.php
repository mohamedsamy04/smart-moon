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
            'slug' => ['sometimes','string','max:255','regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('products','slug')->ignore($this->route('id'))],
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
            'name.string' => 'The product name must be a string.',
            'name.max' => 'The product name may not be greater than 255 characters.',
            'description.string' => 'The description must be a string.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price must be at least 0.',
            'category_id.exists' => 'The selected category does not exist.',
            'slug.unique' => 'This slug is already taken.',
            'new_images.*.image' => 'Each file must be a valid image.',
            'old_images.*.exists' => 'One of the existing images does not exist.',
        ];
    }
}
