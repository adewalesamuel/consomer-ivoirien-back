<?php
namespace App\Http\Controllers;

use App\Models\Publicite;
use Illuminate\Http\Request;
use App\Http\Requests\StorePubliciteRequest;
use App\Http\Requests\UpdatePubliciteRequest;
use Illuminate\Support\Str;


class PubliciteController extends Controller
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
            'publicites' => Publicite::where('id', '>', -1)
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
    public function store(StorePubliciteRequest $request)
    {
        $validated = $request->validated();

        $publicite = new Publicite;

        $publicite->titre = $validated['titre'] ?? null;
		$publicite->description = $validated['description'] ?? null;
		$publicite->type = $validated['type'] ?? null;
		$publicite->img_urls = $validated['img_urls'] ?? null;
		$publicite->redirect_url = $validated['redirect_url'] ?? null;
		$publicite->date_debut = $validated['date_debut'] ?? null;
		$publicite->date_fin = $validated['date_fin'] ?? null;

        if ($publicite->status) $publicite->status = $validated['status'];
		
        $publicite->save();

        $data = [
            'success'       => true,
            'publicite'   => $publicite
        ];
        
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publicite  $publicite
     * @return \Illuminate\Http\Response
     */
    public function show(Publicite $publicite)
    {
        $data = [
            'success' => true,
            'publicite' => $publicite
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publicite  $publicite
     * @return \Illuminate\Http\Response
     */
    public function edit(Publicite $publicite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publicite  $publicite
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePubliciteRequest $request, Publicite $publicite)
    {
        $validated = $request->validated();

        $publicite->titre = $validated['titre'] ?? null;
		$publicite->description = $validated['description'] ?? null;
		$publicite->type = $validated['type'] ?? null;
		$publicite->img_urls = $validated['img_urls'] ?? null;
		$publicite->redirect_url = $validated['redirect_url'] ?? null;
		$publicite->date_debut = $validated['date_debut'] ?? null;
		$publicite->date_fin = $validated['date_fin'] ?? null;

        if ($publicite->status) $publicite->status = $validated['status'];
		
        $publicite->save();

        $data = [
            'success'       => true,
            'publicite'   => $publicite
        ];
        
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publicite  $publicite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publicite $publicite)
    {   
        $publicite->delete();

        $data = [
            'success' => true,
            'publicite' => $publicite
        ];

        return response()->json($data);
    }
}