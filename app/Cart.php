<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use Uuids;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $fillable = ['user_id'];

    protected $hidden = ['user_id', 'created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
