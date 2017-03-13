@extends('layout.master')

@section('contents')
<link href="{{ asset('css/tooltipster.css') }}" rel="stylesheet" />

<div class="panel panel-success">


    <div class="panel-heading">Data types<a href="{{url('datatype/add')}}" class="btn btn-success btn-xs pull-right">
            New data type <i class="fa fa-plus"></i> </a></div>


@if(isset($name))
<h3 class="text-success"> {{ $name }}</h3>
@endif

        <div class="panel-body">
            @if ($alert = Session::get('alert-success'))
            <div class="alert alert-success">
                {{ $alert }}
            </div>
            @endif
            <div class="panel-body">

                <table  class="display table table-bordered table-striped" id="dynamic-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(DataTypeDetails::all() as $type)
                    <tr>
                        <td>{{ $type->name }}</td>
                        <td class="table-condensed col-xs-pull-2">
                            <div class="btn-group btn-group-xs" >
                                <a href="{{ url('datatype/edit')}}/{{$type->id}}" class="btn btn-info" title="edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a data-toggle="modal" class="open-DeleteDialog btn btn-danger" data-id="{{$type->id}}" href="#deleteDialog" title="delete">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                        </td>

                    </tr>
                    @endforeach

                    </tbody>

                </table>
            </div>
        </div>




    <!-- Delete modal -->

    <div class="modal fade bs-example-modal-sm" id="deleteDialog" role="dialog" aria-hidden="true" style="padding-top: 20%" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-body">
                <?php
                $datatype_id = 'datatypeId';
                ?>
                @include('datatype.delete')

            </div>
        </div>
    </div>


    <script>
        $(document).on("click", ".open-DeleteDialog", function(){
            var myId = $(this).data('id');
            $(".modal-body #DeleteButton").attr("href","{{url('datatype/delete')}}/"+myId);
        });
    </script>



    <!--main content end-->
    <!--script for this page only-->

    <script src="{{ asset('js/dynamic_table_init.js') }}"></script>
<!--    <script src="{{ asset('js/jquery.tooltipster.js') }}"></script>-->




    @stop