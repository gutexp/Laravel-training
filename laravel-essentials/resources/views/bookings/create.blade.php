@extends('layouts.app')

@section('content')
<div class="col">
<form action="{{ route('bookings.store') }}" method="POST">
    {{-- this include gets the the fields from fields.blade.php and put there, since we can reuse all of this form in our edit.blade.php its worth to maintain a single .php containing all the forms in order to avoid duplicate code --}}
    @include('bookings.fields')

    <div class="form-group row">
        <div class="col-sm-3">
            <button type="submit" class="btn btn-primary">Add Reservation</button>
        </div>
        <div class="col-sm-9">
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>
</div>
@endsection