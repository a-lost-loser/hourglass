@extends('Backend::bootstrap')

@section('links')
    <link rel="stylesheet" href="{{ url('/_assets/css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="vertical-center">
                    <div class="card card-block m-t-3">
                        <form method="post">
                            {!! csrf_field() !!}
                            <fieldset class="form-group @if($errors->has('email')) has-danger @endif">
                                <input type="text" class="form-control @if($errors->has('email')) form-control-danger @endif" name="email" placeholder="Username" value="{{ old('email') }}">
                            </fieldset>

                            <fieldset class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </fieldset>

                            <button type="submit" class="btn form-control btn-secondary-outline btn-background-color" data-default-color="secondary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('/_assets/js') }}"></script>
@endsection