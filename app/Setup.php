<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setup extends Model
{
    protected $table = 'user_setup';

    protected $fillable = [
//        'title', 'description', 'content', 'avatar', 'created_by', 'updated_by',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
