
@extends('layout.master')

@section('contents')
<div class="row">
    <div class="col-lg-12">
        <section class="panel panel-success">
            <header class="panel-heading">
                List of Employees
                <a class="btn btn-success pull-right btn-xs" href="{{ url('employee/add') }}">
                    New employee <i class="fa fa-plus"></i>
                </a>
            </header>
            @if(isset($msg))
            <div class="alert alert-success fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                <strong>SUCCESS!</strong> Employee {{ $employ->firstName }}{{ $employ->middleName }}{{ $employ->lastName }} {{$msg}}.
            </div>
            @endif
            <div class="panel-body">
                <section id="unseen">
                    <table id="dynamic-table"  class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Date Of Birth</th>
                            <th>Date Of Employement</th>
                            <th>Address</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $j = 0 ?>

                        @foreach($emp as $employee)
                        <tr>
                            <td>{{ ++$j }}</td>
                            <td>{{ $employee->firstName }}</td>
                            <td>{{ $employee->middleName }}</td>
                            <td>{{ $employee->lastName}}</td>
                            <td>{{ $employee->DOB}}</td>
                            <td>{{ $employee->DOE}}</td>
                            <td>{{ $employee->address}}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->phoneNumber }}</td>
                            <td>{{ $employee->hasCategory->name}}</td>
                            <td class="table-condensed col-xs-pull-2" id="{{ $employee->id }}">
                                <div class="btn-group btn-group-xs" >
                                    <a class="btn btn-primary" title="edit location level" href='{{ url("employee/edit/{$employee->id}") }}'>
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a class="btn btn-danger deletelevel" title="delete location level" href='#delete'>
                                        <i class="fa fa-trash-o"></i>
                                    </a>


                                </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </section>
            </div>
        </section>

    </div>

</div>
<!-- page end-->
<script>
    $(document).ready(function(){
        $(".deletelevel").click(function(){
            var id1 = $(this).parent().parent().attr('id');
            $(".deletelevel").show("slow").parent().parent().parent().find("span").remove();
            var btn = $(this).parent().parent().parent();
            $(this).hide("slow").parent().parent().append("<span><br>Are You Sure <br /> <a href='#s' id='yes' class='btn btn-success btn-xs'><i class='fa fa-check'></i> Yes</a> <a href='#s' id='no' class='btn btn-danger btn-xs'> <i class='fa fa-times'></i> No</a></span>");
            $("#no").click(function(){
                $(this).parent().parent().find(".deletelevel").show("slow");
                $(this).parent().parent().find("span").remove();
            });
            $("#yes").click(function(){
                $(this).parent().html("<br><i class='fa fa-spinner fa-spin'></i>deleting...");
                $.post("<?php echo url('employee/delete') ?>/"+id1,function(data){
                    btn.hide("slow").next("hr").hide("slow");
                });
            });
        });//endof deleting category
    })
</script>
<script src="{{ asset('js/dynamic_table_init.js') }}"></script>
@stop