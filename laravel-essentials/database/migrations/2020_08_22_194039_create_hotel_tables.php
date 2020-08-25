<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_types', function (Blueprint $table) {  //This creates a table
            $table->bigIncrements('id')->comment('The Primary Key for the table.');
            $table->string('name', 255)->comment('The name of the room type, ie Double Queen, etc.');   //see also that the characters are restrained to 255
            $table->text('description')->comment('The full text description of the room type.');
            $table->timestamps();   //this gives the ability to set times for reservation
            $table->softDeletes();  //this command makes that deleted records just go deleted from the records but stays in the database
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('The Primary Key for the table.'); //bigIncrements make this id increments as it is added
            $table->integer('number')->unique('number')->comment('The room number in the hotel, a unique value.');
            //This gonna create a relationship between rooms and rooms types
            $table->unsignedBigInteger('room_type_id')->index('room_type_id')->comment('The corresponding room type.');
            $table->timestamps();
            //this advise that room_type_id is the id present in our room_types table
            $table->foreign('room_type_id')->references('id')->on('room_types');
        });

        Schema::create('discounts', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('The Primary Key for the table.');
            $table->string('name', 255);
            $table->string('code', 50)->comment('The code someone would be expected to enter at checkout.');
            $table->unsignedInteger('discount')->comment('The discount in whole cents for a room.');    //100=1dolar for us to not be worried about floating numbers in the DB
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rates', function (Blueprint $table) {   //this table give us the value of the charge of the service depending on how the table is filled
            $table->bigIncrements('id')->comment('The Primary Key for the table.');
            $table->unsignedInteger('value')->comment('The rate for the room in whole cents.'); //again we receving this with the cents value
            $table->unsignedBigInteger('room_type_id')->index('room_type_id')->comment('The corresponding room type.'); //brings back the room type
            $table->boolean('is_weekend')->default(false)->comment('If this is the weekend rate or not.');  //a boolean to extra charge in the weekends
            $table->timestamps();
            //this adds a unique relation between the two tables, so the rate being charged can be different even between the rooms of the same type depending of the boolean weekend!
            $table->unique(['room_type_id', 'is_weekend']); 
            $table->foreign('room_type_id')->references('id')->on('room_types');    //again referenciates room_types as the id of the table room_types
        });

        Schema::create('bookings', function (Blueprint $table) {    //A table to the reservations of the rooms
            $table->bigIncrements('id')->comment('The Primary Key for the table.');
            $table->unsignedBigInteger('room_id')->index('room_id')->comment('The corresponding room.');
            $table->date('start')->comment('The start date of the booking.');
            $table->date('end')->comment('The end date of the booking.');
            $table->boolean('is_reservation')->default(false)->comment('If this booking is a reservation.'); //flag to see if the user reserved the room
            $table->boolean('is_paid')->default(false)->comment('If this booking has been paid.');  //flag to see if the user already paid the room before
            $table->text('notes')->nullable()->comment('Any notes for the reservation.');   //nullable() indicate that can be blank
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('room_id')->references('id')->on('rooms');
        });

        Schema::create('bookings_users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('The Primary Key for the table.');
            $table->unsignedBigInteger('booking_id')->index('booking_id')->comment('The corresponding booking.');
            $table->unsignedBigInteger('user_id')->index('user_id')->comment('The corresponding user.');
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings_users');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('rates');
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('room_types');
    }
}