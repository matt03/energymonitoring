@extends('layout.master')

@section('contents')

<section class="panel panel-success" xmlns="http://www.w3.org/1999/html">
    <header class="panel-heading ">
        Register Hospital
        <a class="btn btn-success btn-xs pull-right " href='{{ url("hospital") }}'>
            back to list <i class="fa fa-list"></i>
        </a>
    </header>
    <div class="panel-body" >
        @if(isset($msg))
        <div class="alert alert-success fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">x</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>SUCCESS!</strong> Hospital {{$hospital->name}} {{$msg}}.
        </div>
        @endif
        <br><br>
        <form action="{{url('hospitalEdit')}}" method="post">

            <div class="entry" >
                @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
                @endforeach

                <div class="row">
                    <div class="form-group" >
                        <div class="col-md-4"> Hospital Name<br><br>
                            <input type="text" placeholder="Enter Hospital Name" value="{{$hospital->name}}" name= "name" class="form-control" required="required"/> </div>
                            <input type="text" placeholder="Enter Hospital Name" value="{{$hospital->id}}" name= "id" class="form-control" required="required"/> </div>
                    </div>
                </div>
                <br><br>
                <div class="row">
                    <div class="form-group">


                        <div class="col-md-4"><br>District
                            <select class="form-control" name="district" id="district">
                                <option value="{{$hospital->district->id}}">{{$hospital->district->district}}</option>
                                @foreach($district as $district)
                                <option value="{{$district->id}}">{{$district->district}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                </div>
            </div>
            <hr>
            <div class="col-md-12" style="margin-top: 30px;" align="center">
                <button type="submit" name="submit" class="btn btn-primary">Update</button>
                <a class="btn btn-danger" href="{{ url('hospital') }}"> Cancel</a>
            </div>



    </div>
    <!--     <div class="clear"></div>-->
    </form>
    </div>

</section>

@stop