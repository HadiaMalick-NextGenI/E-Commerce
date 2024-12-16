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
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'stock_quantity' => 'required|integer|min:0',
            'size' => 'required|string',
            'color' => 'required|string',
            'discount_type' => 'nullable|in:flat,percentage',
            'discount_percentage' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
                Rule::requiredIf($this->input('discount_type') === 'percentage'),
            ],
            'discount_price' => [
                'nullable',
                'numeric',
                'min:0',
                Rule::requiredIf($this->input('discount_type') === 'flat'),
            ],
            'discount_end_date' => 'nullable|date|after_or_equal:today',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.exists' => 'The selected category does not exist.',
            'brand_id.exists' => 'The selected brand does not exist.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg.',
        ];
    }
}
