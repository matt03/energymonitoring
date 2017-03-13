@extends('layout.master')

@section('contents')

<section class="panel panel-success">
    <header class="panel-heading">
        Edit data type
        <a class="btn btn-success btn-xs pull-right" href='{{ url("user") }}'>
            back to list <i class="fa fa-list"></i>
        </a>
    </header>
    <div class="panel-body">
        <form action="{{ url('datatype/edit')}}/{{$type->id}}" method="post">
            @if ($alert = Session::get('alert-success'))
            <div class="alert alert-success">
                {{ $alert }}

                @endif
                <div class="entry">


                    <div class="form-group">
                        <div class=class="col-md-6"><p>Name</p></div>
                        <div class=class="col-md-6"> <input type="text"  name= "name" class="form-control" value="{{$type->name}}"/> </div>
<br>
                        <button type="submit" name="submit" class="btn btn-primary">Edit</button>
                        <a class="btn btn-danger" href="{{ url('datatype') }}"> Cancel</a>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
    </div>
    </form>
    </div></section>
@stop
