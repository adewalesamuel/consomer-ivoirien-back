<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Support\Str;


class PostController extends Controller
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
            'posts' => Post::with(['categorie', 'utilisateur'])->where('id', '>', -1)
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
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        $post = new Post;

        $post->titre = $validated['titre'] ?? null;
		$post->description = $validated['description'] ?? null;
		$post->attributs = $validated['attributs'] ?? null;
		$post->prix = $validated['prix'] ?? null;
		$post->img_urls = $validated['img_urls'] ?? null;
		$post->categorie_id = $validated['categorie_id'] ?? null;
		$post->utilisateur_id = $validated['utilisateur_id'] ?? null;
		$post->promotion_end_date = $validated['promotion_end_date'] ?? null;
		
        $post->save();

        $data = [
            'success'       => true,
            'post'   => $post
        ];
        
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $data = [
            'success' => true,
            'post' => Post::where('id', $post->id)->with(['categorie', 'utilisateur'])->first()
        ];

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $validated = $request->validated();

        $post->titre = $validated['titre'] ?? null;
		$post->description = $validated['description'] ?? null;
		$post->attributs = $validated['attributs'] ?? null;
		$post->prix = $validated['prix'] ?? null;
		$post->img_urls = $validated['img_urls'] ?? null;
		$post->categorie_id = $validated['categorie_id'] ?? null;
		$post->utilisateur_id = $validated['utilisateur_id'] ?? null;
		$post->promotion_end_date = $validated['promotion_end_date'] ?? null;
		
        $post->save();

        $data = [
            'success'       => true,
            'post'   => $post
        ];
        
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {   
        $post->delete();

        $data = [
            'success' => true,
            'post' => $post
        ];

        return response()->json($data);
    }
}