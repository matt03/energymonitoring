@extends('layout.master')

@section('contents')
<section class="panel panel-success">
    <header class="panel-heading">
        Update {{ $level->name }} Information
        <a class="btn btn-success btn-xs pull-right" href='{{ url("location/levels") }}'>
            back to list <i class="fa fa-list"></i>
        </a>

    </header>
    <div class="panel-body">
<div class="col-sm-12">
    @if(isset($msg))
    <div class="alert alert-success fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
        <strong>SUCCESS!</strong> Location Level {{ $level->name }} Updated Successful.
    </div>
    @endif
<!--    <h3>Update Location Level Information<a href="{{ url('location/levels') }}" class="btn btn-xs btn-info pull-right">Back to List</a></h3>-->
    <form class="form-horizontal" id="default" method="post" action='{{ url("location/levels/edit/{$level->id}") }}'>
        <div class="form-group">
            <label class="col-md-2 control-label" id="DataCat">Level Name</label>
            <div class="col-md-6">
                <input type="text" value="{{ $level->name }}" class="form-control" placeholder="Location level Name" name="location_name">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" id="DataCat"> Parent Level</label>
            <div class="col-md-6">
                {{ Form::select('parent_level',array('0'=>'No Parent')+LocationLevel::orderBy('id','ASC')->get()->lists('name','id'),$level->parentId,array('class'=>'form-control','required'=>'requiered')) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 text-center">
                <input type="submit" value="Update" class="btn btn-info">
            </div>
        </div>
    </form>

</div>
    </div>
</section>
@stop