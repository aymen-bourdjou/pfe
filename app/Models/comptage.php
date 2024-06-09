<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comptage extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_comptage';

    protected $fillable = [
        'id_inventaire',
        'id_departement',
        'nom_comptage',
        'etas',
        'observation',
        'date_debut',
        'date_fin',
        'id_user_updateure',
        'id_user_createure',
    ];

    protected $dates = [
        'date_debut',
        'date_fin',
    ];

    public function inventaire()
    {
        return $this->belongsTo(Inventaire::class, 'id_inventaire');
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'id_departement');
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
