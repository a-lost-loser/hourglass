@extends('Hourglass.Backend::shared.scaffolding')

@section('body')
    <form method="post">
        {!! csrf_field() !!}
        <input type="text" id="email" name="email">
        <input type="password" id="password" name="password">
        <button type="submit">Log In</button>
    </form>
@endsection