<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use Uuids;

    protected $hidden = ['created_at', 'updated_at'];

    public function recipes(){
        return $this->hasMany('App\Recipe');
    }
}
