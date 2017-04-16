<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelationType extends Model
{
    public function relation() {
        return $this->belongsTo('App\UserRelation');
    }
}
