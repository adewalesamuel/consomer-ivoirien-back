<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSouscriptionRequest extends FormRequest
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
            'titre' => 'required|string|unique:souscriptions',
			'description' => 'nullable|string',
			'img_urls' => 'nullable|json',
			'periode' => 'required|integer',
			'prix' => 'required|integer',
			'attributs' => 'nullable|json',
			
        ];
    }
}