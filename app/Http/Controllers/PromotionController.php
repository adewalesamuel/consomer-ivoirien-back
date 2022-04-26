<?php
namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use Illuminate\Support\Str;


class PromotionController extends Controller
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
            'promotions' => Promotion::where('id', '>', -1)
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
    public function store(StorePromotionRequest $request)
    {
        $validated = $request->validated();

        $promotion = new Promotion;

        $promotion->titre = $validated['titre'] ?? null;
		$promotion->description = $validated['description'] ?? null;
		$promotion->periode = $validated['periode'] ?? null;
		$promotion->prix = $validated['prix'] ?? null;
		
        $promotion->save();

        $data = [
            'success'       => true,
            'promotion'   => $promotion
        ];
        
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function show(Promotion $promotion)
    {
        $data = [
            'success' => true,
            'promotion' => $promotion
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function edit(Promotion $promotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePromotionRequest $request, Promotion $promotion)
    {
        $validated = $request->validated();

        $promotion->titre = $validated['titre'] ?? null;
		$promotion->description = $validated['description'] ?? null;
		$promotion->periode = $validated['periode'] ?? null;
		$promotion->prix = $validated['prix'] ?? null;
		
        $promotion->save();

        $data = [
            'success'       => true,
            'promotion'   => $promotion
        ];
        
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promotion  $promotion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promotion $promotion)
    {   
        $promotion->delete();

        $data = [
            'success' => true,
            'promotion' => $promotion
        ];

        return response()->json($data);
    }
}