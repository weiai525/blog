<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'role_id',
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
