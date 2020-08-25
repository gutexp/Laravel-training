<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    public function room(){
        return $this->hasOne('App\Room');   //One-to-one relationship with room
    }

    public function rooms(){
        return $this->hasMany('App\Room', 'id', 'room_type_id');  //One-to-Many relationship with the rooms
    }
}
