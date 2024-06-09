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
        'id_user_updateure',
        'id_user_createure',

    ];
    protected $date=[
        'date_debut',
        'date_fin'
    ];



    public function comptage(){
        return $this->belongTo(Comptage::class,'id_comptage');
    }
    public function userCreateur()
    {
        return $this->belongsTo(User::class, 'id_user_createure');
    }

    public function userUpdateur()
    {
        return $this->belongsTo(User::class, 'id_user_updateure');
    }
}
