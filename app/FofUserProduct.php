<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FofUserProduct extends Model
{
    protected $fillable = ['fuid', 'cid'];
    public $timestamps = false;
}
