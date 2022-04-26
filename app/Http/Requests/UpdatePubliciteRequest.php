<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePubliciteRequest extends FormRequest
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
			'type' => 'required|string',
			'img_urls' => 'nullable|json',
			'redirect_url' => 'nullable|string',
			'date_debut' => 'required|date',
			'date_fin' => 'required|date',
			'status' => 'nullable|string',
			
        ];
    }
}