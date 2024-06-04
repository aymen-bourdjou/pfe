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
        'date_creation',
        'date_debut',
        'date_fin',
    ];

    protected $dates = [
        'date_creation',
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
}
