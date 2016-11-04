<?php

namespace App\Models\Portal;

use Illuminate\Database\Eloquent\Model;

class ArticleClass extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'u_id',
        'name',
    ];
    protected $table='article_classes';

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
