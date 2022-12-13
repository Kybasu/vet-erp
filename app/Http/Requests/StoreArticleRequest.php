<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg,tif,tiff,bmp,gif,xe2,webp,heic|max:5000',
            'brand_id' => 'nullable|exists:brands,id',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'variants' => 'array',
            'variants.*.default_code' => 'required|string|max:255|unique:variants,default_code',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.weight' => 'required|numeric|min:0',
        ];
    }
}
