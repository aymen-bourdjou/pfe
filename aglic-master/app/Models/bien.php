<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_bien',//liblle
        'prix_d_achat',//prix
        'barcode',//code
        'date_achat',//date
        'duree_vie',//duree de vie
        'qr_code',//code
        'fournisseure',//bil,
        'etas',//etas
        'no_serie'//no_serie
    ];
    protected $primaryKey = 'id_bien';

    protected $casts = [
        'date_achat' => 'date',
        'duree_vie' => 'integer',
        // Si  besoin de convertir qr_code en tableau
    ];

}
