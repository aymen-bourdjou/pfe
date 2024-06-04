<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comptage_bien extends Model
{
    use HasFactory;
    protected $table = 'comptage_biens';

    public $incrementing = false;

    protected $primarykey = null;
    
    protected $fillable = [
        'id_bien',
        'id_comptage',
        'etas',
    
    ];

    protected $dates = [
        'date_de_comptage',
    ];

    public function bien()
    {
        return $this->belongsTo(bien::class, 'id_bien');
    }

    public function comptage()
    {
        return $this->belongsTo(comptage::class, 'id_comptage');
    }
    public static function deleteByCompositeKey($id_comptage, $id_bien)
    {
        return self::where('id_comptage', $id_comptage)
                   ->where('id_bien', $id_bien)
                   ->delete();
    }
    public static function updatesansid($id_bien, $id_comptage, array $attributes)
{
    return self::where('id_bien', $id_bien)
               ->where('id_comptage', $id_comptage)
               ->update($attributes);
}
}
