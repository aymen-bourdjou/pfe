<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permission extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_permission';

    protected $fillable = [
        'nom_permission'
    ];
    
}
