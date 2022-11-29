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
<form action="{{ route('course.store') }}" method="post">
    @csrf
    Name
    <input type="text" name="name" value="{{ old('name') }}">
    @if ($errors->has('name'))
        <span class="error">
            {{ $errors->first('name') }}
        </span>
    @endif
    <br>
    <Button>ADD</Button>
</form>
@endsection
