<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tag;
use App\Models\Categorie;

class quote extends Model
{
    protected $fillable = ['author', 'quote', 'user_id'];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'tag_quote')->withTimestamps();
    }

    public function categories(){
        return $this->belongsToMany(Categorie::class, 'categorie_quote')->withTimestamps();
    }

    public function favoris(){
        return $this->hasMany(Favoris::class);
    }
    
}
