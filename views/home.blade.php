@extends('layout')

@section('content')
    <div>
        <h1>Home Page</h1>
        <a href="/about">About</a>
    </div>

    <?php var_dump($users); ?>
@endsection
