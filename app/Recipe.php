<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use Uuids;
    protected $hidden = ['created_at', 'updated_at', 'vendor_id'];

    public function vendor(){
        return $this->belongsTo('App\Vendor');
    }
}
