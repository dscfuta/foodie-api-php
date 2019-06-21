<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use Uuids;


    public function recipes(){
        return $this->hasMany('App\Recipe');
    }
}
