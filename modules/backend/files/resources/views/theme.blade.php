<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Communalizer</title>

        <link rel="stylesheet" href="assets/css/semantic.min.css">
        <link rel="stylesheet" href="assets/css/app.css">
    </head>

    <body>

        <div class="ui padded grid">
            <div class="white row">
                <div class="two wide yellow left aligned column">
                    <div class="header">
                        Communalizer
                    </div>
                </div>
                <div class="fourteen wide left aligned column white">
                    <div class="ui transparent large left icon input">
                        <input type="text" placeholder="Search the backend ...">
                        <i class="search icon"></i>
                    </div>
                </div>
            </div>
            <div class="row negativemargin">
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
                <div class="fourteen wide column content">
                    @yield('content')
                </div>
            </div>
        </div>

        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/semantic.min.js"></script>
        <script src="assets/js/vue.min.js"></script>
    </body>
</html>