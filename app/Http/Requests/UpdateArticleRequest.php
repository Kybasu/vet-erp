<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
            'name' => 'string|max:255',
            'description' => 'string',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg,tif,tiff,bmp,gif,xe2,webp,heic|max:5000',
            'brand_id' => 'nullable|exists:brands,id',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ];
    }
}
