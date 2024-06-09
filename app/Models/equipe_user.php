<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equipe_user extends Model
{
    use HasFactory;
    protected $table='equipe_users';
    protected $praimaryKey=null;
    public $incrementing=false;
    protected $fillable=[
        'id_equipe',
        'id_user',
        'id_user_updateure',
        'id_user_createure',
    ];


    public function equipe(){
        return $this->belongTo(Equipe::class,'id_equipe');
    }
    public function userCreateur()
    {
        return $this->belongsTo(User::class, 'id_user_createure');
    }

    public function userUpdateur()
    {
        return $this->belongsTo(User::class, 'id_user_updateure');
    }
   /* public static function updateByCompositeKey($id_equipe, $id_user, $data)
    {
        return self::where('id_equipe', $id_equipe)
                   ->where('id_user', $id_user)
                   ->update($data);
    }*/
    public static function deleteByCompositeKey($id_equipe, $id_user)
    {
        return self::where('id_equipe', $id_equipe)
                   ->where('id_user', $id_user)
                   ->delete();
    }

}
