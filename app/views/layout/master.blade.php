<!DOCTYPE html>
@if(Auth::guest())
{{Redirect::to("login")}}
@else
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
<!--    <link rel="shortcut icon" href="http://thevectorlab.net/flatlab/img/favicon.png">-->

    <title>SafeFocus</title>
    <!-- bootstrap 3.0.2 -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="{{ asset('css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />

    <!--multiselect-->
    <link href="{{ asset('jquery.multiselect.css') }} " rel="stylesheet" type="text/css"/>
    <link href="{{ asset('sumoselect.css') }} " rel="stylesheet" type="text/css"/>
    <link href="{{ asset('jquery.multiselect.filter.css') }} " rel="stylesheet" type="text/css"/>
    <!-- Morris chart -->
    <link href="{{ asset('css/morris/morris.css') }}" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="{{ asset('css/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
    <!-- Date Picker -->
    <link href="{{ asset('css/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="{{ asset('css/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
<!--    <link href="{{ asset('css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />-->
    <!-- Theme style -->
    <link href="{{ asset('css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('advanced-datatable/media/css/demo_page.css') }}" rel="stylesheet"/>

    <link href="{{ asset('advanced-datatable/media/css/demo_table.css') }}" rel="stylesheet"/>

    <link href="{{ asset('data-tables/DT_bootstrap.css') }}" rel="stylesheet"/>

{{ HTML::style("jqueryui/css/cupertino/jquery-ui.css") }}

<!-- JQuery 2.0.2 -->
    <script src="{{ asset('jquery-2.0.3.min.js') }} "></script><!-- Bootstrap -->
    <script src="{{ asset('js/bootstrap.min.js')}}" type="text/javascript"></script>

    <script type="text/javascript" language="JavaScript" src="{{ asset('advanced-datatable/media/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" language="JavaScript" src="{{ asset('data-tables/DT_bootstrap.js') }}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ asset('js/html5shiv.js') }} "></script>
    <script src="{{ asset('js/respond.min.js') }} "></script>
    <![endif]-->
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-reset.css') }}" rel="stylesheet">
    <link href="{{ asset('jquery.multiselect.css') }} " rel="stylesheet" type="text/css"/>
    <link href="{{ asset('sumoselect.css') }} " rel="stylesheet" type="text/css"/>
    <link href="{{ asset('jquery.multiselect.filter.css') }} " rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/advanced-datatable/media/css/demo_page.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/advanced-datatable/media/css/demo_table.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/data-tables/DT_bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('multiple-select.css') }}" rel="stylesheet">
    <!--external css-->
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css') }}" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.css') }}" type="text/css">

    <!--right slidebar-->
    <link href="{{ asset('css/slidebars.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style-responsive.css') }}" rel="stylesheet" />

    <!--    including jquery library-->
    <script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js') }}"></script>



<!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="{{ asset('js/html5shiv.js') }}"></script>
      <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->
    <script type="text/javascript" src="{{ asset('http://code.highcharts.com/highcharts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('Highcharts/js/highcharts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('Highcharts/js/modules/exporting.js') }}"></script>
    <script type="text/javascript" src="{{ asset('Highcharts/js/themes/sand-signika.js') }}"></script>
</head>

<body>

<section id="container" >
<!--header start-->
<header class="header white-bg">
  @include('layout.header')
</header>
<!--header end-->
<!--sidebar start-->
<aside>
  @include('layout.left_menu')
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
<section class="wrapper">
   @yield('contents')
</section>
</section>
<!--main content end-->
</section>
<!--footer start-->
<footer class="site-footer">
    <div class="text-center">
        {{ date('Y') }} &copy; Softmed Company Limited.
<!--        <a href="index.html#" class="">-->
<!--            <i class="fa fa-angle-up"></i>-->
<!--        </a>-->
    </div>
</footer>
<!--footer end-->


<!-- js placed at the end of the document so the pages load faster -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<script type="text/javascript" language="javascript" src="{{ asset('assets/advanced-datatable/media/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/data-tables/DT_bootstrap.js') }}"></script>
<script class="include" type="text/javascript" src="{{ asset('js/jquery.dcjqaccordion.2.7.js') }}"></script>
<script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('js/jquery.nicescroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.sparkline.js') }}" type="text/javascript"></script>
<script src="{{ asset('multiselect/js/jquery.multi-select.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js') }}"></script>
<script src="{{ asset('js/owl.carousel.js') }}" ></script>
<script src="{{ asset('js/jquery.customSelect.min.js') }}" ></script>
<script src="{{ asset('js/multiple-select.js') }}" ></script>


<!-- jQuery UI 1.10.3 -->
<script src="{{ asset('js/jquery.form.js') }} "></script>

{{ HTML::script("jqueryui/js/jquery-ui-1.10.4.custom.min.js") }}
<script src="{{ asset('jquery.multiselect.js') }}"></script>
<script src="{{ asset('jquery.sumoselect.min.js') }}"></script>
<script src="{{ asset('jquery.multiselect.filter.js') }}"></script>
<script type="text/javascript" src="{{ asset('Highcharts/js/highcharts.js') }}"></script>
<script type="text/javascript" src="{{ asset('Highcharts/js/modules/exporting.js') }}"></script>
<script type="text/javascript" src="{{ asset('Highcharts/js/themes/sand-signika.js') }}"></script>

<!-- Morris.js charts -->
<!--<script src="{{ asset('//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js')}}"></script>-->
<!--<script src="{{ asset('js/plugins/morris/morris.min.js')}}" type="text/javascript"></script>-->
<!--<!-- Sparkline -->
<!--<script src="{{ asset('js/plugins/sparkline/jquery.sparkline.min.js')}}" type="text/javascript"></script>-->
<!--<!-- jvectormap -->
<!--<script src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}" type="text/javascript"></script>-->
<!--<script src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}" type="text/javascript"></script>-->
<!-- jQuery Knob Chart -->
<script src="{{ asset('js/plugins/jqueryKnob/jquery.knob.js')}}" type="text/javascript"></script>

<script src="{{ asset('js/plugins/iCheck/icheck.min.js')}}" type="text/javascript"></script>


<!-- AdminLTE App -->
<script src="{{ asset('js/AdminLTE/app.js')}}" type="text/javascript"></script>


<!-- AdminLTE for demo purposes -->
<script src="{{ asset('js/AdminLTE/demo.js') }}" type="text/javascript"></script>

<!--right slidebar-->
<script src="{{ asset('js/slidebars.min.js') }}"></script>

<!--common script for all pages-->
<script src="{{ asset('js/common-scripts.js') }}"></script>

<!--script for this page-->
<script src="{{ asset('js/sparkline-chart.js') }}"></script>
<script src="{{ asset('js/easy-pie-chart.js') }}"></script>
<script src="{{ asset('js/count.js') }}"></script>

<script>

    //owl carousel

    $(document).ready(function() {
        $("#owl-demo").owlCarousel({
            navigation : true,
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem : true,
            autoPlay:true

        });
    });

    //custom select box

    $(function(){
        $('select.styled').customSelect();
    });

</script>

</body>
</html>
@endif
