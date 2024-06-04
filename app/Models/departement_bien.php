<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class departement_bien extends Model
{
    use HasFactory;

    protected $table = 'departement_biens';

    public $incrementing = false;

    protected $primarykey = null;

    protected $fillable = [
        'id_bien',
        'id_departement',
        'date_affectation',
        'affecter_a',
        
    ];

    protected $dates = [
        'date_affectation',
    ];

    public function bien()
    {
        return $this->belongsTo(bien::class, 'id_bien');
    }

    public function departement()
    {
        return $this->belongsTo(departement::class, 'id_departement');
    }
    public static function deleteByCompositeKey($id_departement, $id_bien)
    {
        return self::where('id_departement', $id_departement)
                   ->where('id_bien', $id_bien)
                   ->delete();
    }
    public static function updatesansid($id_bien, array $attributes)
    {
        return self::where('id_bien', $id_bien)->update($attributes);
    }
}
