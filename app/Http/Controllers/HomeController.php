<?php

namespace App\Http\Controllers;
use App\Models\Categorie;
use App\Models\Post;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request) {
        $categories = Categorie::all();
        $posts = [];
        $post_index = 0;

        for ($k=0; $k <  count($categories); $k++) { 
            $post_list = Post::where('categorie_id', $categories[$k]->id)->limit(6)->get();
            for ($k1=0; $k1 < count($post_list); $k1++) { 
                $posts[$post_index] = $post_list[$k1];
                $post_index += 1;
            }

            $categories[$k]['posts'] = $post_list;
        }

        $data = [
            "success" => true,
            "categories" => $categories
        ];

        return response()->json($data);
    }
}
