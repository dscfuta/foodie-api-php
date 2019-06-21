<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use Uuids;

    public function vendor(){
        return $this->hasOne('App\Vendor');
    }
}
