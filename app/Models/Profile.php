<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;

    protected $table = "profiles";
    protected $fillable = ['profile'];
    protected $hidden = array('pivot');
}
