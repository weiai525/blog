<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'route',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
    //protected $dateFormat = 'U';
    protected $primaryKey = 'id';
    protected $timestamp = false;

   
}
