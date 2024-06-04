<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equipe_employe extends Model
{
    use HasFactory;
    protected $table='equipe_employes';
    protected $praimaryKey=null;
    public $incrementing=false;
    protected $fillable=[
        'id_equipe',
        'id_employe',
        'date_debut',
        'date_fin',
        'role',
    ];

    protected $date=[
        'date_debut',
        'date_fin',
    ];

    public function equipe(){
        return $this->belongTo(Equipe::class,'id_equipe');
    }
    public function employe(){
        return $this->belongTo(Employe::class,'id_employe');
    }
   /* public static function updateByCompositeKey($id_equipe, $id_employe, $data)
    {
        return self::where('id_equipe', $id_equipe)
                   ->where('id_employe', $id_employe)
                   ->update($data);
    }*/
    public static function deleteByCompositeKey($id_equipe, $id_employe)
    {
        return self::where('id_equipe', $id_equipe)
                   ->where('id_employe', $id_employe)
                   ->delete();
    }

}
