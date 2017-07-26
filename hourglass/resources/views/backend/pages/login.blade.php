<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Hourglass Admin</title>

        <link rel="stylesheet" href="{{ asset('css/hourglass.css') }}">
    </head>
    <body class="login">
        <div class="container-fluid">
            <div class="row">
                <div class="hidden-xs col-sm-7 col-md-8">
                    <div class="logo-container">
                        <div class="faded-background"></div>

                        <img class="pull-left hidden-xs logo" src="{{ asset('images/login-background.jpeg') }}">

                        <div class="title">
                            <h1>Hourglass</h1>
                            <small>Administration Interface</small>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-5 col-md-4 login-sidebar">
                    <p>Sign in</p>

                    <form action="" method="POST">
                        {!! csrf_field() !!}

                        <div class="form-group form-group-default">
                            <div class="controls">
                                <input type="text" name="email" id="email" placeholder="Email / Username" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group form-group-default">
                            <div class="controls">
                                <input type="password" name="password" id="password" placeholder="Password" class="form-control" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-block login-button">
                            <span class="glyphicon glyphicon-lock"></span> Login
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>