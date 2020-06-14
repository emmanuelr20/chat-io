<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;
    
    protected $guarded = [];
    protected $with = ['members', 'recentMessages'];
    
    public function users()
    {
        return $this->belongsToMany('App\User')->as('chat_details')->withPivot('chat_name')->withTimestamps();
    }

    public function members()
    {
        return $this->belongsToMany('App\User')->where("user_id", '!=', auth()->id());
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function recentMessages()
    {
        return $this->hasMany('App\Message')->latest()->limit(10);
    }
}
