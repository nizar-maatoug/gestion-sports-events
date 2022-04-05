<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    public function evennementSportif(){

        return $this->belongsTo(EvennementSportif::class);
    }

    public function athletes(){
        return $this->hasMany(Athlete::class);
    }
}
