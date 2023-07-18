<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectStatus extends Model
{
    public $table = 'project_status';

    public $fillable = [
        'project_id',
        'key_status',
        "key_status_name" ,
        "key_status_order" ,
        "is_active"
    ];

    public function project(){
        return $this->belongsTo(Project::class, 'project_id' ,'id');
    }
}
