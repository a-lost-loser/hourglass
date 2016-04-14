@extends('Backend::theme')

@section('content')
    <h2>Backend</h2>

    @templatesection('Communalizer.Backend::testing')
    <p>Section 1</p>
    @endtemplatesection

    <p>@templateevent('Communalizer.Backend::testing') <i>(Event: 'Communalizer.Backend::testing')</i></p>
@endsection