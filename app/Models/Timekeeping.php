<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timekeeping extends Model
{
    protected $table = 'timekeeping';

    protected $fillable = [
        'project_id',
        'user_id',
        'task',
        'description',
        'start_date',
        'minutes',
        'location',
    
    ];
    
    
    protected $dates = [
        'start_date',
    
    ];
    public $timestamps = false;
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/timekeepings/'.$this->getKey());
    }
}
