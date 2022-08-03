<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetArticleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'categories' => 'nullable|boolean',
            'variants' => 'nullable|boolean',
            'brand' => 'nullable|boolean',
            'per_page' => 'nullable|integer|min:1|max:100',
            'page' => 'nullable|integer|min:1',
        ];
    }
}
