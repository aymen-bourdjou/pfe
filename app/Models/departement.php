<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class departement extends Model
{
    use HasFactory;
    protected $primaryKey ='id_departement';

    protected $fillable = [
        'id_zone',
        'nom_departement',

    ];

    public function zone (){
        return $this->belongTo(Zone::class,'id_zone');
    }

}
