<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code'
    ];

    public function roleModules(){
        return $this->hasMany(
            UserRoleModule::class, 
            'role_id', //foreign key
            'id' //local key
        );
    }

    public function rolePermissions(){
        return $this->hasMany(
            UserRolePermission::class, 
            'role_id', //foreign key
            'id' //local key
        );
    }
}
