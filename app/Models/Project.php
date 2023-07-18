<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    protected $table = 'projects';

    public $fillable = [
        'name',
        "details" ,
        "task_backend",
        "task_frontend",
        "task_design",
        "task_server",
        "task_mobile",
        "task_tablet",
        "task_other",
    ];

    public function user(){
        return $this->belongsTo(User::class, 'creator' ,'id');
    }

    public function project_permission(){
        return $this->belongsTo(ProjectPermission::class, 'id' ,'project_id');
    }

    public function project_permission_list(){
        return $this->hasMany(ProjectPermission::class, "project_id", "id")->orderBy("permission_id", "ASC");
    }

    public function project_status_list(){
        return $this->hasMany(ProjectStatus::class, "project_id", "id")->orderBy("id", "ASC");
    }

    public function project_status_active_list(){
        return $this->hasMany(ProjectStatus::class, "project_id", "id")->where("is_active", 1)->orderBy("id", "ASC");
    }

    public function project_permission_list_user(){
        return $this->belongsToMany(User::class, "project_permissions", "project_id","user_id",'id' , 'id');
    }

    public function project_permission_list_for_user(){
        return $this->hasMany(ProjectPermission::class, "project_id", "id")->where("user_id", Auth::guard(config("sys_auth.user"))->user()->id);
    }

}
