<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equipe extends Model
{
    use HasFactory;
    protected $primaryKey='id_equipe';
    protected $fillable = [
        'id_comptage',
        'nom_equipe',
        'date_debut',
        'date_fin',

    ];
    protected $date=[
        'date_debut',
        'date_fin'
    ];



    public function comptage(){
        return $this->belongTo(Comptage::class,'id_comptage');
    }
}
