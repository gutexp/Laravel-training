<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowRoomsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $rooms = DB::table('rooms')->get(); //this gonna return to variable rooms everything that we have in this table through a foreach kind of method
        if($request->query('id') !== null){ //this will give us the chance, if we want, to search the room by id's
            $rooms = $rooms->where('room_type_id', $request->query('id'));
        }

        // return response()->json($rooms);    //this gonna pass the response of the search in the DB by a json format of the response which is better to show this up
        return view('rooms.index', ['rooms' => $rooms]);

    }
}
