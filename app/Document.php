<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = "documents";
    protected $fillable = [
        'document_no',
        'title',
        'source',
        'destination',
        'note',
      'document_type_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attach_file()
    {
      return $this->hasMany(AttachFiles::class,'document_id','id');
    }
}