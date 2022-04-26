<?php
namespace App\Http\Controllers;

use App\Models\Administrateur;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAdministrateurRequest;
use App\Http\Requests\UpdateAdministrateurRequest;
use Illuminate\Support\Str;


class AdministrateurController extends Controller
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
            'administrateurs' => Administrateur::where('id', '>', -1)
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
    public function store(StoreAdministrateurRequest $request)
    {
        $validated = $request->validated();

        $administrateur = new Administrateur;

        $administrateur->nom_prenoms = $validated['nom_prenoms'] ?? null;
		$administrateur->email = $validated['email'] ?? null;
		$administrateur->password = $validated['password'] ?? null;
		$administrateur->role = $validated['role'] ?? null;
		$administrateur->img_url = $validated['img_url'] ?? null;

        if ($request->hasFile('img'))
            $administrateur->img_url =  str_replace('public', 'storage', $request->img->store('public'));
		
        $administrateur->save();

        $data = [
            'success'       => true,
            'administrateur'   => $administrateur
        ];
        
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Administrateur  $administrateur
     * @return \Illuminate\Http\Response
     */
    public function show(Administrateur $administrateur)
    {
        $data = [
            'success' => true,
            'administrateur' => $administrateur
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Administrateur  $administrateur
     * @return \Illuminate\Http\Response
     */
    public function edit(Administrateur $administrateur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administrateur  $administrateur
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdministrateurRequest $request, Administrateur $administrateur)
    {
        $validated = $request->validated();

        $administrateur->nom_prenoms = $validated['nom_prenoms'] ?? null;
		$administrateur->email = $validated['email'] ?? null;
		$administrateur->password = $validated['password'] ?? null;
		$administrateur->role = $validated['role'] ?? null;

        if ($request->hasFile('img'))
            $administrateur->img_url =  str_replace('public', 'storage', $request->img->store('public'));	
            	
        $administrateur->save();

        $data = [
            'success'       => true,
            'administrateur'   => $administrateur
        ];
        
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administrateur  $administrateur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Administrateur $administrateur)
    {   
        $administrateur->delete();

        $data = [
            'success' => true,
            'administrateur' => $administrateur
        ];

        return response()->json($data);
    }
}