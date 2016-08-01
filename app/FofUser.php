<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FofUser extends Model
{
    protected $primaryKey = 'fuid';
    protected $fillable = ['type', 'name', 'id_number', 'id_number_last_6'];

    // 定义产品关联
    public function product()
    {
        return $this->hasMany('App\FofUserProduct', 'fuid', 'fuid');
    }
}
