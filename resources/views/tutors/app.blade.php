<?php

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

if(Session::has('tutor_id')) {
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
        
        <link href="{{ URL::asset('/panels/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" id="theme" rel="stylesheet">
        <link href="{{ URL::asset('/panels/assets/plugins/select2/dist/css/select2.min.css') }}" id="theme" rel="stylesheet">
        <link href="{{ URL::asset('/panels/assets/plugins/switchery/dist/switchery.min.css') }}" id="theme" rel="stylesheet">
        <link href="{{ URL::asset('/panels/assets/plugins/bootstrap-select/bootstrap-select.min.css') }}" id="theme" rel="stylesheet">
        <link href="{{ URL::asset('/panels/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" id="theme" rel="stylesheet">
        <link href="{{ URL::asset('/panels/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css') }}" id="theme" rel="stylesheet">
        <link href="{{ URL::asset('/assets/plugins/multiselect/css/multi-select.css') }}" id="theme" rel="stylesheet">
        <script src="{{ URL::asset('/panels/assets/plugins/jquery/jquery.min.js') }}"></script>
        
    </head>

    <body class="fix-header card-no-border">
    
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
        </div>

        <div id="main-wrapper">
            
            @include("tutors.nav")

            @yield("content")

            <div style="clear: both"></div>
            <div style="margin-top:50%"></div>

            @include("tutors.footer")

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

        <script src="{{ URL::asset('/panels/assets/plugins/switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/select2/dist/js/select2.full.min.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
        <script src="{{ URL::asset('/panels/assets/plugins/multiselect/js/jquery.multi-select.js') }}"></script>

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
            
                jQuery(document).ready(function() {
        // Switchery
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });
        // For select 2
        $(".select2").select2();
        $('.selectpicker').selectpicker();
        //Bootstrap-TouchSpin
        $(".vertical-spin").TouchSpin({
            verticalbuttons: true,
            verticalupclass: 'ti-plus',
            verticaldownclass: 'ti-minus'
        });
        var vspinTrue = $(".vertical-spin").TouchSpin({
            verticalbuttons: true
        });
        if (vspinTrue) {
            $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
        }
        $("input[name='tch1']").TouchSpin({
            min: 0,
            max: 100,
            step: 0.1,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
            postfix: '%'
        });
        $("input[name='tch2']").TouchSpin({
            min: -1000000000,
            max: 1000000000,
            stepinterval: 50,
            maxboostedstep: 10000000,
            prefix: '$'
        });
        $("input[name='tch3']").TouchSpin();
        $("input[name='tch3_22']").TouchSpin({
            initval: 40
        });
        $("input[name='tch5']").TouchSpin({
            prefix: "pre",
            postfix: "post"
        });
        // For multiselect
        $('#pre-selected-options').multiSelect();
        $('#optgroup').multiSelect({
            selectableOptgroup: true
        });
        $('#public-methods').multiSelect();
        $('#select-all').click(function() {
            $('#public-methods').multiSelect('select_all');
            return false;
        });
        $('#deselect-all').click(function() {
            $('#public-methods').multiSelect('deselect_all');
            return false;
        });
        $('#refresh').on('click', function() {
            $('#public-methods').multiSelect('refresh');
            return false;
        });
        $('#add-option').on('click', function() {
            $('#public-methods').multiSelect('addOption', {
                value: 42,
                text: 'test 42',
                index: 0
            });
            return false;
        });
        $(".ajax").select2({
            ajax: {
                url: "https://api.github.com/search/repositories",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: formatRepo, // omitted for brevity, see the source of this page
            templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
        });
    });
        </script>
<?php
}
else {
    ?>
    <script type="text/javascript">
        window.location = "/tutors";
    </script>
    <?php
}
?>

    </body>
</html>