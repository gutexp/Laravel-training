<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{   
    
    use SoftDeletes;    //with softdeletes we enable de capacity to laravel secure our trashed data in case that we need this
    //with the use of the Eloquent in our model we have more security when adding items to our DB as well as it gives us the oportunity to save the exact day that we created a booking
    //check this on the browser and compare to the other items that we added early
    protected $fillable = [
        'room_id',
        'start',
        'end',
        'is_reservation',
        'is_paid',
        'notes',

    ];

    public function room(){
        return $this->belongsTo('App\Room');
    }

    public function users(){    //many-to-many relationship
        return $this->belongsToMany('App\User', 'bookings_users', 'booking_id', 'user_id')->withTimestamps();
    }
}
