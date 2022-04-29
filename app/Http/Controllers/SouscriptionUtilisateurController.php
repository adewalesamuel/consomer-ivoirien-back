<?php
namespace App\Http\Controllers;

use App\Models\SouscriptionUtilisateur;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSouscriptionUtilisateurRequest;
use App\Http\Requests\UpdateSouscriptionUtilisateurRequest;
use Illuminate\Support\Str;


class SouscriptionUtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'success' => true,
            'souscription_utilisateurs' => SouscriptionUtilisateur::with(
                ['souscription', 
                'utilisateur'])->where('id', '>', -1)
                ->orderBy('created_at', 'desc')->get()
        ];

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSouscriptionUtilisateurRequest $request)
    {
        $validated = $request->validated();

        $souscription_utilisateur = new SouscriptionUtilisateur;

        $souscription_utilisateur->paiement_id = $validated['paiement_id'] ?? null;
		$souscription_utilisateur->souscription_id = $validated['souscription_id'] ?? null;
		$souscription_utilisateur->utilisateur_id = $validated['utilisateur_id'] ?? null;
		$souscription_utilisateur->prix = $validated['prix'] ?? null;
		$souscription_utilisateur->quantite = $validated['quantite'] ?? null;
		$souscription_utilisateur->mode_paiement = $validated['mode_paiement'] ?? null;
        
        if ($souscription_utilisateur->status) 
            $souscription_utilisateur->status = $validated['status'];

        $souscription_utilisateur->save();

        $data = [
            'success'       => true,
            'souscription_utilisateur'   => $souscription_utilisateur
        ];
        
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SouscriptionUtilisateur  $souscription_utilisateur
     * @return \Illuminate\Http\Response
     */
    public function show(SouscriptionUtilisateur $souscription_utilisateur)
    {
        $data = [
            'success' => true,
            'souscription_utilisateur' => $souscription_utilisateur
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SouscriptionUtilisateur  $souscription_utilisateur
     * @return \Illuminate\Http\Response
     */
    public function edit(SouscriptionUtilisateur $souscription_utilisateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SouscriptionUtilisateur  $souscription_utilisateur
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSouscriptionUtilisateurRequest $request, SouscriptionUtilisateur $souscription_utilisateur)
    {
        $validated = $request->validated();

        $souscription_utilisateur->paiement_id = $validated['paiement_id'] ?? null;
		$souscription_utilisateur->souscription_id = $validated['souscription_id'] ?? null;
		$souscription_utilisateur->utilisateur_id = $validated['utilisateur_id'] ?? null;
		$souscription_utilisateur->prix = $validated['prix'] ?? null;
		$souscription_utilisateur->quantite = $validated['quantite'] ?? null;
		$souscription_utilisateur->mode_paiement = $validated['mode_paiement'] ?? null;
        
        if ($souscription_utilisateur->status) 
            $souscription_utilisateur->status = $validated['status'];

        $souscription_utilisateur->save();

        $data = [
            'success'       => true,
            'souscription_utilisateur'   => $souscription_utilisateur
        ];
        
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SouscriptionUtilisateur  $souscription_utilisateur
     * @return \Illuminate\Http\Response
     */
    public function destroy(SouscriptionUtilisateur $souscription_utilisateur)
    {   
        $souscription_utilisateur->delete();

        $data = [
            'success' => true,
            'souscription_utilisateur' => $souscription_utilisateur
        ];

        return response()->json($data);
    }
}