<?php
namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use Illuminate\Support\Str;


class CategorieController extends Controller
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
            'categories' => Categorie::where('id', '>', -1)
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
    public function store(StoreCategorieRequest $request)
    {
        $validated = $request->validated();

        $categorie = new Categorie;

        $categorie->nom = $validated['nom'] ?? null;
		$categorie->slug = $validated['slug'] ?? null;
		$categorie->description = $validated['description'] ?? null;

        if ($request->hasFile('img'))
            $categorie->img_url =  str_replace('public', 'storage', $request->img->store('public'));		
        $categorie->save();

        $data = [
            'success'       => true,
            'categorie'   => $categorie
        ];
        
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Categorie $categorie)
    {
        $data = [
            'success' => true,
            'categorie' => $categorie
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit(Categorie $categorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategorieRequest $request, Categorie $categorie)
    {
        $validated = $request->validated();

        $categorie->nom = $validated['nom'] ?? null;
		$categorie->slug = $validated['slug'] ?? null;
		$categorie->description = $validated['description'] ?? null;

        if ($request->hasFile('img'))
            $categorie->img_url =  str_replace('public', 'storage', $request->img->store('public'));		
        $categorie->save();

        $data = [
            'success'       => true,
            'categorie'   => $categorie
        ];
        
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {   
        $categorie->delete();

        $data = [
            'success' => true,
            'categorie' => $categorie
        ];

        return response()->json($data);
    }
}