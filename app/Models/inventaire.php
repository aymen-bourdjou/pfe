<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inventaire extends Model
{
    use HasFactory;
    protected $primaryKey='id_inventaire';
    protected $fillable=[
        'nom_inventaire',
        'etas',
        'observation',
        'date_debut',
        'date_fin',
        'id_user_updateure',
        'id_user_createure',
    ];

    protected $date=[
        'date_creation',
        'date_debut',
        'date_fin'
    ];
    public function userCreateur()
    {
        return $this->belongsTo(User::class, 'id_user_createure');
    }

    public function userUpdateur()
    {
        return $this->belongsTo(User::class, 'id_user_updateure');
    }
}

