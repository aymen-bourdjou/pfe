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
        'date_creation',
        'date_debut',
        'date_fin',
    ];

    protected $date=[
        'date_creation',
        'date_debut',
        'date_fin'
    ];
}

