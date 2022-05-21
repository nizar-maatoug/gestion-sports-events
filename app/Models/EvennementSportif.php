<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvennementSportif extends Model
{
    use HasFactory;

    protected $guarded=[];

    protected $perPage = 2;

    public function organisateur(){

        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories(){

        return $this->hasMany(Categorie::class);

    }

    public function athletes(){

        return $this->hasManyThrough(Athlete::class,Categorie::class);

    }

    public function commentaires(){
        return $this->morphMany(Commentaire::class,'commentable');
    }
}
