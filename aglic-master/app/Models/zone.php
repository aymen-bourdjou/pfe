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
    ];
}

    