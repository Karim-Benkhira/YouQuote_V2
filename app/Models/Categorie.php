<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\quote;

class Categorie extends Model
{
    protected $fillable = ['name'];

    public function quotes()
    {
        return $this->belongsToMany(quote::class);
    }
}
