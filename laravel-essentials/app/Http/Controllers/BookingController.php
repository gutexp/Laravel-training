<?php

namespace App\Http\Controllers;

use App\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Booking::withTrashed()->get()->dd();    //we can check the softdeleted datas and the remaning datas with this command of dump
        $bookings = Booking::paginate(1);   //with paginate you can pass as parameter how many results do you want to be shown at the booking index page
        return view('bookings.index')
            ->with('bookings', $bookings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   //with pluck we can get the value and the key (Respectivelly) from our DB's table
        $users = DB::table('users')->get()->pluck('name', 'id')->prepend('none');
        $rooms = DB::table('rooms')->get()->pluck('number', 'id');
        return view('bookings.create')
            ->with('users', $users)
            ->with('booking', (new Booking()))
            ->with('rooms', $rooms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //this command gonna put in our DB the inserted data from the user
        // $id = DB::table('bookings')->insertGetId([
        //     'room_id' => $request->input('room_id'),
        //     'start' => $request->input('start'),
        //     'end' => $request->input('end'),
        //     'is_reservation' => $request->input('is_reservation',false),    //in this case note that we set this input as false as default, in case the user dont check this box
        //     'is_paid' => $request->input('is_paid',false),  //idem there
        //     'notes' => $request->input('notes'),
        // ]);
        //all of the above code can be replaced by this thanks to our model
        $booking = Booking::create($request->input());

        DB::table('bookings_users')->insert([
            'booking_id' => $booking->id,
            'user_id' => $request->input('user_id'),
        ]);
        return redirect()->action('BookingController@index');   //sends the user back to the index of this page of bookings
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        // dd($booking);
        return view('bookings.show', ['booking' => $booking]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        $users = DB::table('users')->get()->pluck('name', 'id')->prepend('none');
        $rooms = DB::table('rooms')->get()->pluck('number', 'id');
        $bookingsUser = DB::table('bookings_users')->where('booking_id', $booking->id)->first();
        return view('bookings.edit')
            ->with('users', $users)
            ->with('rooms', $rooms)
            ->with('bookingsUser', $bookingsUser)
            ->with('booking', $booking);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        // DB::table('bookings')
        //     ->where('id', $booking->id)
        //     ->update([
        //         'room_id' => $request->input('room_id'),
        //         'start' => $request->input('start'),
        //         'end' => $request->input('end'),
        //         'is_reservation' => $request->input('is_reservation',false),    //in this case note that we set this input as false as default, in case the user dont check this box
        //         'is_paid' => $request->input('is_paid',false),  //idem there
        //         'notes' => $request->input('notes'),
        // ]);
        
        //we can use these 2 lines to do the work from above lines of code
        $booking->fill($request->input());
        $booking->save();

        DB::table('bookings_users')
            ->where('booking_id', $booking->id)
            ->update([
                'user_id' => $request->input('user_id'),
        ]);
        return redirect()->action('BookingController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        DB::table('bookings_users')->where('booking_id', $booking->id)->delete();

        // DB::table('bookings')->where('id', $booking->id)->delete();
        $booking->delete();
        return redirect()->action('BookingController@index');
    }
}
