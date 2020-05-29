<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $table = "document_types";
    protected $fillable = [
        'id',
        'type'];

    public function ofDocument()
    {
        return $this->belongsTo('App\Document','id','document_type_id');
    }
}