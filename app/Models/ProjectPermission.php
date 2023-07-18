<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectPermission extends Model
{
    public $table = 'project_permissions';

    public $fillable = [
        'project_id',
        "user_id" ,
        "permission_id"
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id' ,'id');
    }

    public function permission(){
        return $this->belongsTo(Permission::class, 'permission_id' ,'id');
    }
}
