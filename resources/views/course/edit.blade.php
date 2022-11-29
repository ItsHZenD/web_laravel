@extends('layout.master')
@section('content')

<form action="{{ route('course.update', $each) }}" method="post">
    @csrf
    @method('PUT')
    Name
    <input type="text" name="name" value="{{ $each->name }}">
    <br>
    <Button>Update</Button>
</form>
@endsection
