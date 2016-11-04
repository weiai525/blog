<?php

namespace App\Models\Portal;

use Illuminate\Database\Eloquent\Model;

class ArticleContent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'content'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
    public $timestamps  = false;
    //protected $dateFormat = 'U';
    protected $primaryKey = 'id';
}
