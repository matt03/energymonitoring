@extends('layout.master')

@section('contents')

<body>
        <!-- page start-->
        <div class="row">
            <aside class="profile-nav col-lg-3">
                <section class="panel">

                    <div class="user-heading round">
                        <a href="profile.html#">
                            <img src="img/pro-ac-1.png" alt="">
                        </a>
                        <h1>{{ Auth::user()->firstName }} {{ Auth::user()->middleName }} {{ Auth::user()->lastName }}</h1>
                        <p>{{ Auth::user()->email }}</p>
                    </div>

                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="{{ URL::to('user/profileEdit')}}"> <i class="fa fa-edit"></i> Edit profile</a></li>
                    </ul>

                </section>
            </aside>
            <form action="{{url('user/profile')}}" method="post">
            <aside class="profile-info col-lg-9">
                <section class="panel">
                    <div class="bio-graph-heading">
                        {{ Auth::user()->firstName }} {{ Auth::user()->middleName }} {{ Auth::user()->lastName }} Profile
                    </div>

                    @if ($alert = Session::get('alert-success'))
                    <div class="alert alert-success">
                        {{ $alert }}
                    </div>
                    @endif
                    <div class="panel-body bio-graph-info">
                        <div class="row">
                            <div class="bio-row">
                                <p><span>First Name </span>: {{ Auth::user()->firstName }}</p>
                            </div>
                            <div class="bio-row">
                                <p><span>Middle Name </span>: {{ Auth::user()->middleName }}</p>
                            </div>
                            <div class="bio-row">
                                <p><span>Last Name </span>: {{ Auth::user()->lastName }}</p>
                            </div>
                            <div class="bio-row">
                                <p><span>Username </span>: {{ Auth::user()->username }}</p>
                            </div>
                            <div class="bio-row">
                                <p><span>Email</span>:{{ Auth::user()->email }}</p>
                            </div>
                            <div class="bio-row">
                                <p><span>Phone Number </span>: {{ Auth::user()->phoneNumber }}</p>
                            </div>
                        </div>
                    </div>
                </section>
                <section>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="panel">

                            </div>
                        </div>
                    </div>
                </section>
            </aside>
                </form>
        </div>

        <!-- page end-->



<!-- js placed at the end of the document so the pages load faster -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
<script src="js/jquery.scrollTo.min.js"></script>
<script src="js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="assets/jquery-knob/js/jquery.knob.js"></script>
<script src="js/respond.min.js" ></script>

<!--right slidebar-->
<script src="js/slidebars.min.js"></script>

<!--common script for all pages-->
<script src="js/common-scripts.js"></script>

<script>

    //knob
    $(".knob").knob();

</script>


</body>




@stop