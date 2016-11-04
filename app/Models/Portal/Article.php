<?php

namespace App\Models\Portal;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'abstract',
        'u_id',
        'status',
        'type',
        'is_comment',
        'p_id',
        'class_id',
        'hits',
        'like',
        'modify_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];
    protected $dateFormat = 'U';
    protected $primaryKey = 'id';

    public function getTypeAttribute($value)
    {
        switch ($value) {
            case 1:
                $value = '原创';
                break;
            case 2:
                $value = '转载';
                break;
            
            default:
                $value = '其他';
                break;
        }
        return $value;
    }
}
