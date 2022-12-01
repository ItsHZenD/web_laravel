@extends('layout.master')
@section('content')
    {{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

    <form action="{{ route('courses.store') }}" method="post">
        @csrf
        Name
        <input type="text" name="name" >
        {{-- @if ($errors->has('name'))
        <span class="error">
            {{ $errors->first('name') }}
        </span>
    @endif --}}
        <br>
        Gender
        <input type="radio" name="gender" value="0" checked>Male
        <input type="radio" name="gender" value="1">Female
        <br>
        Birthdate
        <input type="date" name="birthdate">
        <br>
        Status
        @foreach ($arrStudentStatus as $option => $value)

        <input type="radio" name="status" value="{{ $value }}">{{ $option }}
        @endforeach
        <br>

        <br>
        <Button>ADD</Button>
    </form>
@endsection
