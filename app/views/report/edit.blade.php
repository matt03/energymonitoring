@extends('layout.master')

@section('contents')

<section class="panel panel-success" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
    <header class="panel-heading">
        Edit route
        <a class="btn btn-success btn-xs pull-right" href='{{ url("route") }}'>
            back to list <i class="fa fa-list"></i>
        </a>
    </header>
    <div class="panel-body">

    <form action="{{ url('route/edit')}}/{{$route->id}}" method="post">


        <div class="entry">
            <div class="form-group">
                <div class="col-md-6"> First Name <br> <input type="text"  name= "firstname" class="form-control" required="required" value="{{$route->firstName}}"/> </div>
                <div class="col-md-6">Middle Name <br> <input type="text"  name= "middlename" class="form-control" value="{{$route->middleName}}"/></div>

            </div>
            <div class="form-group">

                <div class="col-md-6">Last Name <br> <input type="text"  name= "lastname" class="form-control" required="required"value="{{$route->lastName}}"/> </div>
                <div class="col-md-6">route Name <br> <input type="text"  name= "routename" class="form-control" required="required"value="{{$route->routename}}"/></div>

            </div>
            <div class="form-group">
                <div class="col-md-6">Email<br><input type="text"  name= "email" class="form-control" required="required"value="{{$route->email}}"/></div>
                <div class="col-md-6">Phone Number<br> <input type="text"  name= "phonenumber" class="form-control" required="required"value="{{$route->phoneNumber}}"/></div>

            </div>

            <div class="form-group">
                <div class="col-md-6">Role<br>{{ Form::select('role',array("admin"=>"admin","report"=>"report","data"=>"data"),'',array('class'=>'form-control','required'=>'required')) }}</div>
                <div class="col-md-6"><br></div>
            </div>
            <div class="sep" style="height: 10px"></div>
            <div class="form-group" style="margin-top: 10px;" >
                <button type="submit" name="submit" class="btn btn-primary">Edit</button>
<!--                <a class="btn btn-danger" href="{{ url('route') }}"> Cancel</a>-->
            </div>
        </div>
        </div>
        <div class="clear"></div>
    </form>
    <script>
        $(document).ready(function(){
            $('select[name=stakeholder]').change(function(){

                $.post('<?php echo url("route/listStakeholderBranch") ?>/'+$(this).val(),function(data){
                    $('select[name=stakeholderBranch]').html(data)
                });
            })
        })
    </script>
    </div>
    </section>
@stop











