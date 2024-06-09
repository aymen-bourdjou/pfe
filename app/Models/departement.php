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
        'id_user_updateure',
        'id_user_createure',

    ];

    public function zone (){
        return $this->belongTo(Zone::class,'id_zone');
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
