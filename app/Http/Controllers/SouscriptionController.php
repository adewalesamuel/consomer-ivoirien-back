<?php
namespace App\Http\Controllers;

use App\Models\Souscription;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSouscriptionRequest;
use App\Http\Requests\UpdateSouscriptionRequest;
use Illuminate\Support\Str;


class SouscriptionController extends Controller
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
            'souscriptions' => Souscription::where('id', '>', -1)
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
    public function store(StoreSouscriptionRequest $request)
    {
        $validated = $request->validated();

        $souscription = new Souscription;

        $souscription->titre = $validated['titre'] ?? null;
		$souscription->description = $validated['description'] ?? null;
		$souscription->periode = $validated['periode'] ?? null;
		$souscription->prix = $validated['prix'] ?? null;
		$souscription->attributs = $validated['attributs'] ?? null;

        if ($request->hasFile('img'))
            $souscription->img_url =  str_replace('public', 'storage', $request->img->store('public'));        

		
        $souscription->save();

        $data = [
            'success'       => true,
            'souscription'   => $souscription
        ];
        
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Souscription  $souscription
     * @return \Illuminate\Http\Response
     */
    public function show(Souscription $souscription)
    {
        $data = [
            'success' => true,
            'souscription' => $souscription
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Souscription  $souscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Souscription $souscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Souscription  $souscription
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSouscriptionRequest $request, Souscription $souscription)
    {
        $validated = $request->validated();

        $souscription->titre = $validated['titre'] ?? null;
		$souscription->description = $validated['description'] ?? null;
		$souscription->periode = $validated['periode'] ?? null;
		$souscription->prix = $validated['prix'] ?? null;
		$souscription->attributs = $validated['attributs'] ?? null;

        if ($request->hasFile('img'))
            $souscription->img_url =  str_replace('public', 'storage', $request->img->store('public'));   
		
        $souscription->save();

        $data = [
            'success'       => true,
            'souscription'   => $souscription
        ];
        
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Souscription  $souscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Souscription $souscription)
    {   
        $souscription->delete();

        $data = [
            'success' => true,
            'souscription' => $souscription
        ];

        return response()->json($data);
    }
}