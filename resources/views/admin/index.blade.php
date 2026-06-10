@extends('layouts.app')

@section('content')
    <h1>管理画面</h1>

    <form action="/logout" method="POST">
        @csrf
        <button type="submit">logout</button>
    </form>
@endsection