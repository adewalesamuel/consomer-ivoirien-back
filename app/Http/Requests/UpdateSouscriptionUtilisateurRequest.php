<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSouscriptionUtilisateurRequest extends FormRequest
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
            'paiement_id' => 'nullable|string',
			'souscription_id' => 'required|integer',
			'utilisateur_id' => 'required|integer',
			'prix' => 'required|integer',
			'quantite' => 'nullable|integer',
			'status' => 'nullable|string',
			'mode_paiement' => 'nullable|string',
			
        ];
    }
}