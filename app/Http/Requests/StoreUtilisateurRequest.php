<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUtilisateurRequest extends FormRequest
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
            'nom_prenoms' => 'required|string',
			'email' => 'required|string|unique:utilisateurs',
			'password' => 'required|string',
			'adresse' => 'nullable|string',
			'ville' => 'nullable|string',
			'pays' => 'nullable|string',
			'telephone' => 'nullable|string',
			'img_url' => 'nullable|string',
            'img' => 'nullable|file',
			'status' => 'nullable|string',
			
        ];
    }
}