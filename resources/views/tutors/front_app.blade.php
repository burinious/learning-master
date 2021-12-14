<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta name="description" content="Secondary E-learning System"/>
        <meta name="keywords" content="subjects, learning, e-learning, tutor, students, groups, chats, quiz, appointments"/>
        <title>@yield('title')</title>

        <link href="{{ URL::asset('/panels/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('/panels/css/style.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('/panels/css/colors/blue.css') }}" id="theme" rel="stylesheet">
    </head>

    <body>
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
        </div>

        <div class="theme-layout">
            
            @yield("content")

            @include("students.footer")

        </div>

        <script src="{{ URL::asset('/panels/assets/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/bootstrap/js/popper.min.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::asset('/panels/js/learning.js') }}"></script>
        <script src="{{ URL::asset('/panels/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ URL::asset('/panels/js/waves.js') }}"></script>
        <script src="{{ URL::asset('/panels/js/sidebarmenu.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
        <script src="{{ URL::asset('/panels/js/custom.min.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>

    </body>

</html>