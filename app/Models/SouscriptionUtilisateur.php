<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SouscriptionUtilisateur extends Model
{
    use HasFactory, SoftDeletes;
            
	public function souscription()
	{
		return $this->belongsTo(Souscription::class); 
	}
	public function utilisateur()
	{
		return $this->belongsTo(Utilisateur::class); 
	}
}