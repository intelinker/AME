<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExcelDoc extends Model
{
    protected $fillable = [
//        'title', 'description', 'content', 'avatar', 'created_by', 'updated_by',
    ];

    public function document() {
        return $this->belongsTo('App\Document', 'document_id');
    }
}
