<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    public $fillable = [
        'name',
        "permission_list" ,

        "created_at",
        "updated_at",
    ];


}
