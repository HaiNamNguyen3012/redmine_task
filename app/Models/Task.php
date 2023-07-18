<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    public $fillable = [
        'user_id',
        'user_id_backup',
        "project_id" ,
        "name",
        "details",
        "category_name",
        "priority",
        "status",
        "version",
        "start_date",
        "end_date",
        "deadline",
        "creator",
        "created_at",
        "updated_at",
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id' ,'id');
    }

    public function userBackup(){
        return $this->belongsTo(User::class, 'user_id_backup' ,'id');
    }

    public function getCreator(){
        return $this->belongsTo(User::class, 'creator' ,'id');
    }

    public function statusProject(){
        return $this->belongsTo(ProjectStatus::class, 'status' ,'id');
    }

}
