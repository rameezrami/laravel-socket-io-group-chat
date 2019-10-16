@extends('layout.layout')
@section('title','Join chat')
@section('content')
    <form action="{{route('chat')}}">
        <div class="form-group">
            <label>User ID:</label>
            <input type="text" name="user_id" class="form-control">
            <small class="form-text text-muted1">
                User IDs available from [ 1 - 50 ]
            </small>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection
