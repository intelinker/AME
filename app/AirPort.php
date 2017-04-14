<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirPort extends Model
{
        protected $table = "airports";

    protected $fillable = [
//        'title', 'description', 'content', 'avatar', 'created_by', 'updated_by',
    ];

    public function profile() {
        return $this->belongsTo('App\Profile');
    }
}
