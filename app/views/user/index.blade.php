@extends('layout.master')

@section('contents')



<div class="panel panel-success">


<div class="panel-heading">List of Users<a href="{{ url('user/add') }}" class="btn btn-success btn-xs pull-right">
        New user <i class="fa fa-plus"></i> </a></div>
    @if ($alert = Session::get('alert-success'))
    <div class="alert alert-success">
        {{ $alert }}
    </div>
    @endif
    <div class="panel-body">

<table  class="display table table-bordered table-striped" id="dynamic-table">
<thead>
<tr>
    <th>First Name</th>
    <th>Middle Name</th>
    <th>Last Name</th>
    <th>User Name</th>
    <th>Email</th>
    <th>Phone Number</th>
    <th>Action</th>
</thead>
<tbody>
@foreach($user as $user)
    <tr>

        <td>{{ $user->firstName }}</td>
        <td>{{ $user->middleName }}</td>
        <td>{{ $user->lastName}}</td>
        <td>@if($user){{ $user->username }}@endif</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->phoneNumber }}</td>
        <td class="table-condensed col-xs-pull-2">
            <div class="btn-group btn-group-xs" >
                <a href="{{ url('user/edit')}}/{{$user->id}}" class="btn btn-info" title="edit">
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
</div>
</div>



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
                $.post("<?php echo url('user/delete') ?>/"+id1,function(data){
                    btn.hide("slow").next("hr").hide("slow");
                });
            });
        });//endof deleting category
    })
</script>

<!--dynamic table initialization -->
<script src="{{ asset('js/dynamic_table_init.js') }}"></script>


@stop