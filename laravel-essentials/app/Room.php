<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'id';
    public $timestamps = true;
    //with this function bellow we can make the model talks to DB instead of using the controller to doind this, code is more simplistic and clean
    public function scopeByType($query, $roomTypeId = null){
        if(!is_null($roomTypeId)){
            $query->where('room_type_id', $roomTypeId);
        }
        return $query;
    }

    public function roomType(){
        return $this->belongsTo('App\RoomType', 'room_type_id', 'id');    //this forces a relationship between room and roomtype
    }

}
