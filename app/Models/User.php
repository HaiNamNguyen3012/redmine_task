<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use CanResetPassword;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'name',
        'email',
        'password',
        'project_actived',
        'project_admin_actived',
        'color',
        'customer_id',
        'card_number',
        'payment_service_plan_subscription_id',
        'plan_id',
        'is_bought',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_actived', 'id');
    }

    public function projectStatusActive()
    {
        return $this->hasMany(ProjectStatus::class, "project_id", "project_actived")->where("is_active", 1)->orderBy("key_status_order", "ASC");
    }

    public function projectStatusActiveNotOrder()
    {
        return $this->hasMany(ProjectStatus::class, "project_id", "project_actived")->where("is_active", 1)->orderBy("id", "ASC");
    }

    public function projectStatusActiveAdmin()
    {
        return $this->hasMany(ProjectStatus::class, "project_id", "project_admin_actived")->where("is_active", 1)->orderBy("key_status_order", "ASC");
    }
    public function projectStatusActiveNotOrderAdmin()
    {
        return $this->hasMany(ProjectStatus::class, "project_id", "project_admin_actived")->where("is_active", 1)->orderBy("id", "ASC");
    }
}
