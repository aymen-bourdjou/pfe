<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role_permission extends Model
{
    use HasFactory;
    protected $table='role_permissions';
    protected $praimaryKey=null;
    public $incrementing=false;
    protected $fillable=[
        'id_role',
        'id_permission',
        'date_debut',
        'id_user_updateure',
        'id_user_createure',
        
    ];
    public function role(){
        return $this->belongTo(role::class,'id_role');
    }
    public function permission(){
        return $this->belongTo(permission::class,'id_permission');
    }
    
    public static function deleteByCompositeKey($id_role, $id_permission)
    {
        return self::where('id_role', $id_role)
                   ->where('id_permission', $id_permission)
                   ->delete();
    }
    public static function updatesansid($id_role, $id_permission, array $attributes)
    {
        return self::where('id_role', $id_role)
                   ->where('id_permission', $id_permission)
                   ->update($attributes);
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
