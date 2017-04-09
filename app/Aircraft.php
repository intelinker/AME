<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    protected $fillable = [
//        'title', 'description', 'content', 'avatar', 'created_by', 'updated_by',
    ];

    public function document() {
        return $this->belongsTo('App\Document');
    }

//    public function execlDoc() {
//        return $this->belongsTo('App\ExcelDoc', 'MODEL');
//    }
}
