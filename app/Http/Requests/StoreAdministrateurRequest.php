<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdministrateurRequest extends FormRequest
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
			'email' => 'required|string|unique:administrateurs',
			'password' => 'required|string',
			'role' => 'nullable|string',
			'img_url' => 'nullable|string',
            'img' => 'nullable|file'
			
        ];
    }
}