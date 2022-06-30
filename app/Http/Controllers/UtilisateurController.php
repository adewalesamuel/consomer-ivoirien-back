<?php
namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Models\SouscriptionUtilisateur;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUtilisateurRequest;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\UpdateUtilisateurRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;


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

    public function posts(Request $request, Utilisateur $utilisateur) {
        $data = [
            'success' => true,
            'posts' => $utilisateur->posts->sortByDesc('created_at')->values()->all()
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
            $utilisateur->img_url =  str_replace('public', 'storage', $request->img->store('storage', 'public'));        

        $utilisateur->save();

        $data = [
            'success'       => true,
            'utilisateur'   => $utilisateur
        ];
        
        return response()->json($data);
    }

    public function storePost(StorePostRequest $request)
    {
        $validated = $request->validated();

        $user = $this->user($request);
        
        if (!$user) return;

        $souscription_utilisateur = SouscriptionUtilisateur::where('utilisateur_id', $user->id)
        ->orderBy('created_at', 'desc')->firstOrFail();

        if (!$this->isSouscripionValid($souscription_utilisateur))
            throw new \Exception("Votre souscription n'est pas valide!", 1);
            

        $post = new Post;

        $post->titre = $validated['titre'] ?? null;
		$post->description = $validated['description'] ?? null;
		$post->attributs = $validated['attributs'] ?? null;
		$post->prix = $validated['prix'] ?? null;
		$post->img_urls = $validated['img_urls'] ?? null;
		$post->categorie_id = $validated['categorie_id'] ?? null;
		$post->utilisateur_id = $user->id ?? null;
		$post->promotion_end_date = $validated['promotion_end_date'] ?? null;
		
        $post->save();

        $data = [
            'success' => true,
            'post'    => $post
        ];
        
        return response()->json($data);
    }

    public function updatePost(UpdatePostRequest $request, Post $post)
    {
        $validated = $request->validated();
        
        if ($this->user($request)->id !== $post->utilisateur_id) 
            throw new Exception("Non Authentifié", 1);
        
        $post->titre = $validated['titre'] ?? null;
		$post->description = $validated['description'] ?? null;
		$post->attributs = $validated['attributs'] ?? null;
		$post->prix = $validated['prix'] ?? null;
		$post->img_urls = $validated['img_urls'] ?? null;
		$post->categorie_id = $validated['categorie_id'] ?? null;
		$post->promotion_end_date = $validated['promotion_end_date'] ?? null;
		
        $post->save();

        $data = [
            'success' => true,
            'post'    => $post
        ];
        
        return response()->json($data);
    }

    private function isSouscripionValid(SouscriptionUtilisateur $souscription_utilisateur): bool {
        $current_datetime = Carbon::now();
        $expiration_date = Carbon::create($souscription_utilisateur->created_at)
        ->addMonth($souscription_utilisateur->souscription->periode);

        $is_valid = ($current_datetime > $expiration_date) ? false : true;

        return $is_valid;
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
            $utilisateur->img_url =  str_replace('public', 'storage', $request->img->store('storage', 'public'));

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

    public function destroyPost(Request $request, Post $post)
    {   
        if ($this->user($request)->id !== $post->utilisateur_id) 
            throw new Exception("Non Authentifié", 1);

        $post->delete();

        $data = [
            'success' => true,
            'post' => $post
        ];

        return response()->json($data);
    }
    
    private function user(Request $request): Utilisateur
    {
        $token = $request->header('Authorization') ? 
        explode(" ", $request->header('Authorization'))[1] : null;
        $utilisateur = Utilisateur::where("api_token", $token)->firstOrFail();

        return $utilisateur;
    }
}