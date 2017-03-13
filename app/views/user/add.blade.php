@extends('layout.master')

@section('contents')

<section class="panel panel-success" xmlns="http://www.w3.org/1999/html">
    <header class="panel-heading ">
        Add New User
        <a class="btn btn-success btn-xs pull-right " href='{{ url("user") }}'>
            back to list <i class="fa fa-list"></i>
        </a>
    </header>
    <div class="panel-body">
        @if(isset($msg))
        <div class="alert alert-success fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">x</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>SUCCESS!</strong> Employee {{ $user->firstName }} {{ $user->middleName }} {{ $user->lastName }} {{$msg}}.
        </div>
        @endif
<form action="{{url('user/add')}}" method="post">

    <div class="entry">
        @foreach($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
        @endforeach

        <div class="form-group">
            <div class="col-md-6"> First Name <br> <input type="text" placeholder="Enter First Name"  name= "firstname" class="form-control"/> </div>
            <div class="col-md-6">Middle Name <br> <input type="text"  placeholder="Enter Middle Name" name= "middlename" class="form-control"/></div>

        </div>
        <div class="form-group">

            <div class="col-md-6"><br><br>Last Name <br> <input type="text" placeholder="Enter Last Name"  name= "lastname" class="form-control"/> </div>
            <div class="col-md-6"><br><br>User Name <br> <input type="text" placeholder="Enter User Name"  name= "username" class="form-control"/></div>

        </div>

        <div class="form-group">
            <div class="col-md-6"><br><br>Password <br> <input type="password" placeholder="Enter Password " name= "password" class="form-control"/> </div>
            <div class="col-md-6"><br><br>Confirm Password <br> <input type="password" placeholder="Please Confirm Password"  id="password_confirm" name= "password_confirm" class="form-control"/> </div>

        </div>
        <div class="form-group">
            <div class="col-md-6"><br><br>Email<br><input type="text"  name= "email" class="form-control"/></div>
            <div class="col-md-6"><br><br>Phone Number<br> <input type="text"  name= "phonenumber" class="form-control"/></div>

        </div>
       <hr><br>
        <div class="form-group">
            <div class="col-md-6"><br><br>Role<br>
                {{ Form::select('role_id',array('0'=>'No Role')+Role::orderBy('id','ASC')->get()->lists('name','id'),'',array('class'=>'form-control')) }}            <div class="col-md-6"><br></div>
        </div>
        <hr>
        <div class="sep" style="height: 30px"></div>
        <div class="form-group text-center" style="margin-top: 30px;" >
        <button type="submit" name="submit" class="btn btn-primary">Add</button>
               <a class="btn btn-danger" href="{{ url('user') }}"> Cancel</a>
        </div>
    </div>
    </div>
<!--     <div class="clear"></div>-->
</form>


    <script>
        $(document).ready(function(){
            $('select[name=stakeholder]').change(function(){

                $.post('<?php echo url("user/listStakeholderBranch") ?>/'+$(this).val(),function(data){
                    $('select[name=stakeholderBranch]').html(data)
                });
            })
        })
    </script>
    </section>

@stop