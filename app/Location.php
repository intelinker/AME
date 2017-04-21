<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function locationtable() {
        return $this->morphTo();
    }
}
