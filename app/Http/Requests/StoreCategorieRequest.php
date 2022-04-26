<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategorieRequest extends FormRequest
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
            'nom' => 'required|string|unique:categories',
			'slug' => 'required|string|unique:categories',
			'description' => 'nullable|string',
			'img_url' => 'nullable|string',
            'img' => 'nullable|file'
			
        ];
    }
}