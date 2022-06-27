<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategorieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nom' => 'required|string',
			'slug' => 'required|string',
			'description' => 'nullable|string',
			'img_url' => 'nullable|string',
            'img' => 'nullable|image',
            'parent_category_id' => 'nullable|integer|exists:categories,id'
			
        ];
    }
}