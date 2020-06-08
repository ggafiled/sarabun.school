<?php

namespace App;

use App\Enums\DocumentType;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = "documents";
    protected $fillable = [
        'run_no',
        'document_no',
        'title',
        'source',
        'destination',
        'note',
        'user_id',
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

    public function getDocumentLastIdFor($documentType)
    {
        $lastid = $this->where('document_type_id',$documentType)->orderBy('run_no', 'desc')->first();
        if($lastid!=null) {
            $lastid = $lastid->run_no + 1;
        }else {
            $lastid = 1;
        }
        return $lastid;
    }
}