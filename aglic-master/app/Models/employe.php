<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employe extends Model
{
    use HasFactory;
    protected $primaryKey='id_employe';
    protected $fillable =[
        'nom_employe',
        'prenom_employe',
        'username',
        'password',
        'profil',

    ];
}