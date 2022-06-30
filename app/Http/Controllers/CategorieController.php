<?php
namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Post;
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
        $categories = Categorie::whereNull('parent_category_id')
        ->orderBy('created_at', 'desc')->get();

        $sub_categories = Categorie::whereNotNull('parent_category_id')
        ->orderBy('created_at', 'desc')->get();

        for ($i=0; $i < count($categories); $i++) {
            $categorie = $categories[$i];

            for ($j=0; $j < count($sub_categories) ; $j++) { 
                $sub_categorie = $sub_categories[$j];

                if ($categorie->id == $sub_categorie->parent_category_id) {
                    if ($categorie['sub_categories']) {
                        $categories[$i]['sub_categories'] = [
                            ...$categories[$i]['sub_categories'], 
                            $sub_categorie];
                    }else {
                        $categories[$i]['sub_categories'] = [$sub_categorie];
                    }
                }
            }
        }

        $data = [
            'success' => true,
            'categories' => $categories
        ];

        return response()->json($data);
    }

    public function posts(Request $request, Categorie $categorie) 
    {
        $posts = Post::where('categorie_id', $categorie->id)
        ->orderBy('created_at', 'desc')->paginate(env('PAGINATE'));
        
        $data = [
            "success" => true,
            "posts" => $posts
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
		$categorie->parent_category_id = $validated['parent_category_id'] ?? null;

        if ($request->hasFile('img'))
            $categorie->img_url =  str_replace('public', 'storage', $request->img->store('storage', 'public'));		
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
		$categorie->parent_category_id = $validated['parent_category_id'] ?? null;

        if ($request->hasFile('img'))
            $categorie->img_url =  str_replace('public', 'storage', $request->img->store('storage', 'public'));		
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