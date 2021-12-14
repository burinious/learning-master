<?php

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

if(Session::has('student_id')) {
?>

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
        <link href="{{ URL::asset('/panels/assets/plugins/html5-editor/bootstrap-wysihtml5.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('/panels/css/style.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('/panels/css/colors/blue.css') }}" id="theme" rel="stylesheet">
        <script src="{{ URL::asset('/panels/assets/plugins/jquery/jquery.min.js') }}"></script>
        
    </head>

    <body class="fix-header card-no-border">
    
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
        </div>

        <div id="main-wrapper">
            
            @include("students.nav")

            @yield("content")

            <div style="clear: both"></div>
            <div style="margin-top:50%"></div>

            @include("students.footer")

        </div>

        <script src="{{ URL::asset('/panels/assets/plugins/bootstrap/js/popper.min.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::asset('/panels/js/learning.js') }}"></script>
        <script src="{{ URL::asset('/panels/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ URL::asset('/panels/js/waves.js') }}"></script>
        <script src="{{ URL::asset('/panels/js/sidebarmenu.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
        <script src="{{ URL::asset('/panels/js/custom.min.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/html5-editor/wysihtml5-0.3.0.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/html5-editor/bootstrap-wysihtml5.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/html5-editor/bootstrap-wysihtml5.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/dropzone-master/dist/dropzone.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/dropzone-master/dist/dropzone.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $(".textarea_editor").wysihtml5();
            });

            $(document).ready(function() {
                $('#myTable').DataTable();
                $(document).ready(function() {
                    var table = $('#example').DataTable({
                        "columnDefs": [{
                            "visible": false,
                            "targets": 2
                        }],
                        "order": [
                            [2, 'asc']
                        ],
                        "displayLength": 25,
                        "drawCallback": function(settings) {
                            var api = this.api();
                            var rows = api.rows({
                                page: 'current'
                            }).nodes();
                            var last = null;
                            api.column(2, {
                                page: 'current'
                            }).data().each(function(group, i) {
                                if (last !== group) {
                                    $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                                    last = group;
                                }
                            });
                        }
                    });
                    // Order by the grouping
                    $('#example tbody').on('click', 'tr.group', function() {
                        var currentOrder = table.order()[0];
                        if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                            table.order([2, 'desc']).draw();
                        } else {
                            table.order([2, 'asc']).draw();
                        }
                    });
                });
            });
            $('#example23').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
            
        </script>
<?php
}
else {
    ?>
    <script type="text/javascript">
        window.location = "/students";
    </script>
    <?php
}
?>

    </body>
</html>