<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttachFiles extends Model
{
    protected $table = "attach_files";
    protected $fillable = [
        'filename',
        'document_id',
        'originalname',
        'extension'
    ]; 

    public function document()
    {
        return $this->belongsTo(Document::class,'id','document_id');
    }
}