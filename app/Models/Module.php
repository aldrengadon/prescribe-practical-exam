<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_list',
        'name',
        'label',
        'is_active',
        'route',
        'icon'
    ];

    public function modulePermissions(){
        return $this->hasMany(
            UserRolePermission::class, 
            'module_id', //foreign key
            'id' //local key
        );
    }

    public static function getModuleByName($name){
        return Module::where('name', $name)->first();
    }
}
