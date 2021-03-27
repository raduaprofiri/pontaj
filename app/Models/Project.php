<?php

namespace App\Models;

use Brackets\AdminAuth\Models\AdminUser;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'leader_id',
        'name',
        'description',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/projects/' . $this->getKey());
    }

    public function leader()
    {
        return $this->belongsTo(AdminUser::class, 'leader_id');
    }
}
