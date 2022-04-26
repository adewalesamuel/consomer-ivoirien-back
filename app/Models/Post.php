<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;
            
	public function categorie()
	{
		return $this->belongsTo(Categorie::class); 
	}
	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class); 
	}
}