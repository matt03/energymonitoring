<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="http://thevectorlab.net/flatlab/img/favicon.png">


    <title>SafeFocus system login page</title>

    <!-- Bootstrap core CSS -->
    <link href= "{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-reset.css') }}" rel="stylesheet">
    <!--external css-->
    <link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href= "{{ asset('css/style.css') }}" rel="stylesheet">
    <link href= "{{ asset('css/style-responsive.css') }}" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login-body"  style="background-image:url('{{asset('img/fabric.png')}}')">

<div class="container">

    <form class="form-signin" action="{{ url('login') }}"  method="post">
        <h2 class="form-signin-heading">safeFocus - sign in now</h2>

        @foreach($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
        @endforeach

            @if ($alert = Session::get('alert-fail'))
                 <div class="alert alert-danger">
                    {{ $alert }}
                 </div>
        @endif

        <div class="login-wrap">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('logo.png') }}" style="height: 200px;width:320px"/>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" placeholder="User ID" autofocus name="username">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <label class="checkbox">
                        <input type="checkbox" value="remember-me" name="remember"> Remember me
                <span class="pull-right">
                    <a data-toggle="modal" href="{{ url('password/remind/') }}"> Forgot Password?</a>

                </span>
                    </label>
                    <button class="btn btn-lg btn-login btn-block"  name="submit" type="submit">Sign in</button>

                </div>
            </div>



        </div>

        <!-- Modal -->
        <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Forgot Password ?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Enter your e-mail address below to reset your password.</p>
                        <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                        <button class="btn btn-success"  type="button">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal -->

    </form>

</div>
</body>
</html>
<!-- js placed at the end of the document so the pages load faster -->


<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<!--common script for all pages-->
<script src="{{ asset('js/common-scripts.js') }}"></script>