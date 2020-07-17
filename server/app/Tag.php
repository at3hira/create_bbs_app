<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];
    
    public function threads()
    {
        return $this->belongsToMany('App\Thread', 'thread_tag_table');
    }
}
