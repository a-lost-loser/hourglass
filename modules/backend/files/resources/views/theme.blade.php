<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Communalizer</title>

        <link rel="stylesheet" href="assets/css/semantic.min.css">
        <link rel="stylesheet" href="assets/css/app.css">
    </head>

    <body>

        <div class="ui padded grid middle aligned topfixed">
            <div class="ui white top fixed menu row">

                <div class="two wide yellow column">
                    <h3 class="roboto">Communalizer</h3>
                </div>

                <div class="six wide left aligned column white">
                    <div class="ui transparent large left icon input">
                        <input type="text" placeholder="Search the backend ...">
                        <i class="search icon"></i>
                    </div>
                </div>

                <div class="eight wide right aligned column white">
                    <a href="#">
                        <span>Demo User</span>
                        <img class="ui right avatar image" src="//www.gravatar.com/avatar/88e3d8cccdcf81147746f6c4038b2d00?s=60&d=retro&r=PG">
                    </a>
                </div>

            </div>

        </div>

        <div class="ui padded equal height grid fullheight">
            <div class="two wide column">
                <div class="ui left inverted vertical menu pointing fluid" style="background-color:#24262d;">
                    <div class="item">
                        <div class="header">System</div>
                        <div class="menu">
                            <a class="item active">Overview</a>
                            <a class="item">Options</a>
                            <a class="item">Updates</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="fourteen wide stretched column content">
                <div class="content">
                    @yield('content')
                </div>
            </div>
        </div>

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/semantic.min.js"></script>
        <script src="assets/js/vue.min.js"></script>

    </body>
</html>