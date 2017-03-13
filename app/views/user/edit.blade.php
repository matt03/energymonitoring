@extends('layout.master')

@section('contents')

<section class="panel panel-success" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
    <header class="panel-heading">
        Edit User
        <a class="btn btn-success btn-xs pull-right" href='{{ url("user") }}'>
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
    <form action="{{ url('user/edit')}}/{{$user->id}}" method="post">


        <div class="entry">
            <div class="form-group">
                <div class="col-md-6"> First Name <br> <input type="text"  name= "firstname" class="form-control" required="required" value="{{$user->firstName}}"/> </div>
                <div class="col-md-6">Middle Name <br> <input type="text"  name= "middlename" class="form-control" value="{{$user->middleName}}"/></div>

            </div>
            <div class="form-group">

                <div class="col-md-6"><br>Last Name <br> <input type="text"  name= "lastname" class="form-control" required="required"value="{{$user->lastName}}"/> </div>
                <div class="col-md-6"><br>User Name <br> <input type="text"  name= "username" class="form-control" required="required"value="{{$user->username}}"/></div>

            </div>
            <div class="form-group">
                <div class="col-md-6"><br>Email<br><input type="text"  name= "email" class="form-control" required="required"value="{{$user->email}}"/></div>
                <div class="col-md-6"><br>Phone Number<br> <input type="text"  name= "phonenumber" class="form-control" required="required"value="{{$user->phoneNumber}}"/></div>

            </div>

            <div class="form-group">
                <div class="col-md-6"><br>Role<br>
                    {{ Form::select('role_id',array($user->role=>"{$user->hasRole->name}")+Role::orderBy('id','ASC')->get()->lists('name','id'),'',array('class'=>'form-control')) }}
                <div class="col-md-6"><br></div>
            </div>
            <div class="sep" style="height: 120px"><br></div>
            <div class="form-group text-center" ce style="margin-top: 30px;" >
                <button type="submit" style="margin-top: 30px;" name="submit" class="btn btn-primary">Edit</button>
<!--                <a class="btn btn-danger" href="{{ url('user') }}"> Cancel</a>-->
            </div>
        </div>
        </div>
        <div class="clear"></div>
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
    </div>
    </section>
@stop











