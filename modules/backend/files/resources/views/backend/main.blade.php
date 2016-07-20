@extends('Backend::bootstrap')

@section('links')
    <link href="{{ url('/_assets/css') }}">
@endsection

@section('content')
    @templatesection('Hourglass.Backend::testing')
    <p>Section 1</p>
    @endtemplatesection

    <p>@templateevent('Hourglass.Backend::testing') <i>(Event: 'Hourglass.Backend::testing')</i></p>

    <p>Content</p>
@endsection