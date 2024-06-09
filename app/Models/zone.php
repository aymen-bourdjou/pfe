<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class zone extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id_zone';

    protected $fillable = [
        'nom_zone',
        'id_user_updateure',
        'id_user_createure',
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

    