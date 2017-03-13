<div id="sidebar"  class="nav-collapse ">
    <!-- sidebar menu start-->
    <ul class="sidebar-menu" id="nav-accordion">
        <li>
            <a  href="{{ url('dashboard') }}"> <i class="fa fa-book"></i>Dashboard</a>
        </li>
        <li>
            @if((Auth::user()->role == "4"))
            <a  href="{{ url('user') }}">
                <i class="fa fa-user"></i>
                <span>Registration</span>
            </a>
            @endif
        </li>
        <li>
            @if((Auth::user()->role == "4"))
                <a  href="{{ url('energy') }}">
                    <i class="fa fa-user"></i>
                    <span>Energy Consumption</span>
                </a>
            @endif
        </li>

        <li>
            <a  href="{{ url('dashboard') }}">
                <i class="fa fa-user"></i>
                <span>Report</span>
            </a>
        </li>
        <li class="sub-menu">
            <a href="javascript:;" >
                <i class="fa fa-cogs"></i>
                <span>Settings</span>
            </a>
            <ul class="sub">
                <li><a  href="{{ url('energy') }}">Hospital</a></li>
                <li><a  href="{{ url('price') }}">Mapping Price</a></li>

            </ul>
        </li>

    </ul>
    <!-- sidebar menu end-->
</div>