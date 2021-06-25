<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Unidade extends Model
{
    use SoftDeletes;

    protected $table = "unidades";
    protected $appends = ['file'];
    protected $fillable = [
        'name', 'cod','cnpj','cor_primaria','cor_secundaria','file_id'
    ];

    public function Files()
    {
        return $this->belongsTo('App\Models\File','file_id');
    }

    public function getfileAttribute()
    {
        if(is_null($this->file_id))
            return "";
            
        $file = File::find($this->file_id);
        return "http://skakiback.fasters.com.br/".$file["path"].$file["file"];
    }
}
