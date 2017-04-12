<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    public function keystable() {
        return $this->morphTo();
    }
}
