@extends('layouts.app')

@section('content')
    <chat-app init-chats="{{ $chats }}" user-id={{ auth()->id() }}></chat-app>
@endsection
