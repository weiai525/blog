<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class RoleRule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'rule_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
    //protected $dateFormat = 'U';
    //protected $primaryKey = 'id';
    protected $timestamp = false;

   
}
