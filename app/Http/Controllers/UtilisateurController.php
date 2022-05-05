<?php
namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUtilisateurRequest;
use App\Http\Requests\UpdateUtilisateurRequest;
use Illuminate\Support\Str;


class UtilisateurController extends Controller
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
            'utilisateurs' => Utilisateur::where('id', '>', -1)
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
    public function store(StoreUtilisateurRequest $request)
    {
        $validated = $request->validated();

        $utilisateur = new Utilisateur;

        $utilisateur->nom_prenoms = $validated['nom_prenoms'] ?? null;
		$utilisateur->email = $validated['email'] ?? null;
		$utilisateur->password = $validated['password'] ?? null;
		$utilisateur->adresse = $validated['adresse'] ?? null;
		$utilisateur->ville = $validated['ville'] ?? null;
		$utilisateur->pays = $validated['pays'] ?? null;
		$utilisateur->telephone = $validated['telephone'] ?? null;
        $utilisateur->api_token = Str::random(60);
		
        if ($utilisateur->status) $utilisateur->status = $validated['status'] ?? null;
        if ($request->hasFile('img'))
            $utilisateur->img_url =  str_replace('public', 'storage', $request->img->store('public'));        

        $utilisateur->save();

        $data = [
            'success'       => true,
            'utilisateur'   => $utilisateur
        ];
        
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function show(Utilisateur $utilisateur)
    {
        $data = [
            'success' => true,
            'utilisateur' => $utilisateur
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function edit(Utilisateur $utilisateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUtilisateurRequest $request, Utilisateur $utilisateur)
    {
        $validated = $request->validated();

        $utilisateur->nom_prenoms = $validated['nom_prenoms'] ?? null;
		$utilisateur->email = $validated['email'] ?? null;
		$utilisateur->password = $validated['password'] ?? null;
		$utilisateur->adresse = $validated['adresse'] ?? null;
		$utilisateur->ville = $validated['ville'] ?? null;
		$utilisateur->pays = $validated['pays'] ?? null;
		$utilisateur->telephone = $validated['telephone'] ?? null;
		
        if ($utilisateur->status) $utilisateur->status = $validated['status'] ?? null;
		if ($request->hasFile('img'))
            $utilisateur->img_url =  str_replace('public', 'storage', $request->img->store('public'));

        $utilisateur->save();

        $data = [
            'success'       => true,
            'utilisateur'   => $utilisateur
        ];
        
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Utilisateur  $utilisateur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Utilisateur $utilisateur)
    {   
        $utilisateur->delete();

        $data = [
            'success' => true,
            'utilisateur' => $utilisateur
        ];

        return response()->json($data);
    }
}