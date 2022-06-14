<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRolePermission extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'module_id',
        'view',
        'add',
        'edit',
        'delete'
    ];

    public function permissionModule(){
        return $this->belongsTo(
            Module::class, 
            'module_id', //foreign key
            'id' //local key
        );
    }
}
