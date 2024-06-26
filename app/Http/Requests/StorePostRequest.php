<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'titre' => 'required|string',
			'description' => 'nullable|string',
			'attributs' => 'nullable|json',
			'prix' => 'required|integer',
			'img_urls' => 'nullable|json',
			'categorie_id' => 'required|integer|exists:categories,id',
			'utilisateur_id' => 'nullable|integer|exists:utilisateurs,id',
			'promotion_end_date' => 'nullable|date',
			
        ];
    }
}