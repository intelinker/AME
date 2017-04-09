<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
//        'title', 'description', 'content', 'avatar', 'created_by', 'updated_by',
    ];

    public function aircraft() {
        return $this->hasOne('App\Aircraft', 'aircraft_id');
    }

    public function type() {
        return $this->hasOne('App\DocumentType', 'doc_type_id');
    }

    public function execleDoc() {
        return $this->hasOne('App\ExcelDoc');
    }
}
