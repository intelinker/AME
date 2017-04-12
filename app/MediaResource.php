<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaResource extends Model
{
    public function resourcetable() {
        return $this->morphTo();
    }
}
