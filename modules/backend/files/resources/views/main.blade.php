@extends('Backend::theme')

@section('content')
    @templatesection('Communalizer.Backend::testing')
    <p>Section 1</p>
    @endtemplatesection

    <p>@templateevent('Communalizer.Backend::testing') <i>(Event: 'Communalizer.Backend::testing')</i></p>

    <p>Content</p>
@endsection