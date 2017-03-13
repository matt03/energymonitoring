@extends('layout.master')

@section('contents')

<section class="panel panel-success" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
    <header class="panel-heading">
        Edit Employee
        <a class="btn btn-success btn-xs pull-right" href='{{ url("employee") }}'>
            back to list <i class="fa fa-list"></i>
        </a>
    </header>
    <div class="panel-body">
        @if(isset($msg))
        <div class="alert alert-success fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
            <strong>SUCCESS!</strong> Employee {{ $employee->firstName }} {{ $employee->middleName }} {{ $employee->lastName }} {{$msg}}.
        </div>
        @endif
    <form action="{{ url('employee/edit')}}/{{$employee->id}}" method="post">


        <div class="entry">
            <div class="form-group">
                <div class="col-md-6"> First Name <br> <input type="text"  name= "f_name" class="form-control" required="required" value="{{$employee->firstName}}"/> </div>
                <div class="col-md-6">Middle Name <br> <input type="text"  name= "m_name" class="form-control" value="{{$employee->middleName}}"/></div>

            </div>
            <div class="form-group">

                <div class="col-md-6"><br>Last Name <br> <input type="text"  name= "l_name" class="form-control" required="required"value="{{$employee->lastName}}"/> </div>
                <div class="col-md-6"><br>Date of Birth <br> <input type="date"  name= "dob" class="form-control" required="required"value="{{$employee->DOB}}"/></div>

            </div>
            <div class="form-group">
                <div class="col-md-6"><br>Address<br><input type="text"  name= "address" class="form-control" required="required" value="{{$employee->address}}"/></div>
                <div class="col-md-6"><br>Date Of Employment<br> <input type="date"  name= "doe" class="form-control" required="required"value="{{$employee->DOE}}"/></div>

            </div>
            <div class="form-group">
                <div class="col-md-6"><br>Email<br><input type="text"  name= "email" class="form-control" required="required"value="{{$employee->email}}"/></div>
                <div class="col-md-6"><br>Phone Number<br> <input type="text"  name= "number" class="form-control" required="required"value="{{$employee->phoneNumber}}"/></div>

            </div>

            <div class="form-group">
                <div class="col-md-6"><br>Role<br>
                       {{ Form::select('type',array($employee->role_id=>"{$employee->hasCategory->name}")+Categories::orderBy('id','ASC')->get()->lists('name','id'),'',array('class'=>'form-control')) }}
                    <div class="col-md-6"><br></div>
                </div>
                <br><br>
                <div class="sep" style="height: 120px"><br></div></div>
                <div class="form-group text-center" style="margin-top: 150px;" >
                    <button type="submit" name="submit" class="btn btn-primary">Edit</button>

                </div>
            </div>
        </div>
        <div class="clear"></div>
    </form>

    </div>
    </section>
@stop











