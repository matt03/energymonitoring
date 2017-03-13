@extends('layout.master')

@section('contents')

<section class="panel panel-success" xmlns="http://www.w3.org/1999/html">
    <header class="panel-heading ">
        Add New Employee
        <a class="btn btn-success btn-xs pull-right " href='{{ url("employee") }}'>
            back to list <i class="fa fa-list"></i>
        </a>
    </header>
    <div class="panel-body">
<form action="{{url('employee/add')}}" method="post">

    <div class="entry">
        @foreach($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
        @if(isset($msg))
        <div class="alert alert-success fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">x</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>SUCCESS!</strong> Employee {{ $employ->firstName }} {{ $employ->middleName }} {{ $employ->lastName }} {{$msg}}.
        </div>
        @endif
        <div class="form-group">
            <div class="col-md-6">First Name <br> <input type="text" placeholder="Enter First Name" name= "f_name" class="form-control"/> </div>
            <div class="col-md-6">Middle Name <br> <input type="text" placeholder="Enter Middle Name" name= "m_name" class="form-control"/></div>

        </div>
        <br><br>
        <div class="form-group">

            <div class="col-md-6"><br>Last Name <br>  <input type="text" placeholder="Last Name" name= "l_name" class="form-control"/> </div>
            <div class="col-md-6"><br>Date of Birthday <br> <input type="date"  name= "dob" class="form-control"/></div>

        </div>
        <br><br>
        <div class="form-group">
            <div class="col-md-6"><br>Address <br> <input type="text" placeholder="Enter Address" name= "address" class="form-control"/> </div>
            <div class="col-md-6"><br>Date of Employment <br> <input type="date"  name= "doe" class="form-control"/> </div>

        </div>
        <br><br>
        <div class="form-group">
            <div class="col-md-6"><br>Email<br><input type="email"  name= "email" class="form-control"/></div>
            <div class="col-md-6"><br>Phone Number<br> <input type="text"  name= "number" class="form-control"/></div>

        </div>
       <hr><br>
        <div class="form-group">
            <div class="col-md-6"><br>Role<br>
                {{ Form::select('type',array('0'=>'No Type')+Categories::orderBy('id','ASC')->get()->lists('name','id'),'',array('class'=>'form-control')) }}
                <div class="col-md-6"><br></div>
        </div>
            <br><br>
        <div class="sep" style="height: 60px"></div>
        <div class="form-group text-center" style="margin-top: 40px;" >
        <button type="submit" name="submit" class="btn btn-primary">Add</button>
               <a class="btn btn-danger" href="{{ url('employee') }}"> Cancel</a>
        </div>
    </div>
    </div>
<!--     <div class="clear"></div>-->
</form>



    </section>

@stop