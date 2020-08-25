@extends('layouts.app')

@section('content')
<div class="col">
    {{-- we will pass the booking variable of the records to the booking variable there right bellow --}}
<form action="{{ route('bookings.update', ['booking' => $booking]) }}" method="POST">
    {{-- this is necessary cause we cant just turn method as put cause our foreach wouldnt work --}}
    @method('PUT')
    @include('bookings.fields')

    <div class="form-group row">
        <div class="col-sm-3">
            <button type="submit" class="btn btn-primary">Update Reservation</button>
        </div>
        <div class="col-sm-9">
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>
</div>
@endsection