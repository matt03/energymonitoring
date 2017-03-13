@extends('layout.master')

@section('contents')
<section class="panel panel-success">
    <header class="panel-heading">
        Add New Location
        <a class="btn btn-success btn-xs pull-right" href='{{ url("location") }}'>
            back to list <i class="fa fa-list"></i>
        </a>

    </header>
    <div class="panel-body">
<div class="col-sm-12">
    @if(isset($msg))
    <div class="alert alert-success fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
        <strong>SUCCESS!</strong> Location {{ $location->name }} Added Successful.
    </div>
    @endif
<!--    <h3>Add New Location<a href="{{ url('location') }}" class="btn btn-xs btn-info pull-right">Back to List</a></h3>-->
    <form class="form-horizontal" id="default" method="post" action="{{ url('location/add') }}">
        <div class="form-group">
            <label class="col-md-2 control-label" id="DataCat">Level Name</label>
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Location Name" name="location_name">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" id="DataCat">Level</label>
            <div class="col-md-6">
                {{ Form::select('parent_level',LocationLevel::orderBy('id','ASC')->get()->lists('name','id'),'',array('class'=>'form-control','required'=>'requiered')) }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" id="DataCat">Parent</label>
            <div class="col-md-6">
                {{ Form::select('Parent',array('0'=>'No Parent')+Location::orderBy('id','ASC')->get()->lists('name','id'),'',array('class'=>'form-control','required'=>'requiered')) }}
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" id="DataCat">Longitude</label>
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Longitude" name="longitude">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" id="DataCat">Latitude</label>
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Latitude" name="latitude">
            </div>
        <div class="form-group">
            <div class="col-md-6 text-center">
                <input type="submit" value="Add" class="btn btn-info">
            </div>
        </div>
    </form>
<script>
    $(document).ready(function(){
        $('select[name=parent_level]').change(function(){

            $.post('<?php echo url("location/listchild") ?>/'+$(this).val(),function(data){
                $('select[name=Parent]').html(data)
            });
        })
    })
</script>
</div>
        </div>
    </section>
@stop