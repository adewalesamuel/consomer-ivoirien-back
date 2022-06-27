<?php

namespace App\Http\Controllers;
use App\Models\Categorie;
use App\Models\Post;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request) {
        $posts = [];
        $categories = Categorie::whereNull('parent_category_id')
        ->orderBy('created_at', 'asc')->get();
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


            $sub_categorie_ids = collect($categories[$i]['sub_categories'])->map(function($sub_categorie) {
                return $sub_categorie->id;
            });
            $post_list = Post::whereIn('categorie_id', $sub_categorie_ids)->limit(6)->get();
            $categories[$i]['posts'] = [...$post_list];
        }

        // for ($k=0; $k <  count($categories); $k++) { 
        //     $post_list = Post::where('categorie_id', $categories[$k]->id)->limit(6)->get();
        //     for ($k1=0; $k1 < count($post_list); $k1++) { 
        //         $posts[$post_index] = $post_list[$k1];
        //         $post_index += 1;
        //     }

        //     $categories[$k]['posts'] = $post_list;
        // }

        $data = [
            "success" => true,
            "categories" => $categories
        ];

        return response()->json($data);
    }
}
