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
        'date_creation',
        
    ];

    protected $dates = [
        'date_creation',
    ];
}
