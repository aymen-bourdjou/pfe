<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_role';

    protected $fillable = [
        'nom_role',
        'etat',
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
