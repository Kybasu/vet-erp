<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetBrandRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'articles' => 'nullable|boolean',
            'variants' => 'nullable|boolean',
            'per_page' => 'nullable|integer|min:1|max:15',
            'page' => 'nullable|integer|min:1',
        ];
    }
}
