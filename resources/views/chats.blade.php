@extends('layout/layout')
@section('title','Chats')
@section('content')
    <chats :user="{{json_encode($user)}}" browser-identity="{{$browserIdentity}}"></chats>
@endsection