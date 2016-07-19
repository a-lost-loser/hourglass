@extends('Backend::bootstrap')

@section('content')
    <form method="post">
        <input type="text" name="email" vaue="{{ old('email') }}">
        <input type="password" name="password">

        <button type="submit">Login</button>
    </form>
@endsection