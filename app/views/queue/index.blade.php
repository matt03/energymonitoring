@extends('layout.master')

@section('contents')



<section class="panel panel-success" xmlns="http://www.w3.org/1999/html">
    <header class="panel-heading ">
        List of Sample Specimens Received

    </header>
    <div class="panel-body">
        @if(isset($msg))
        <div class="alert alert-success fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">x</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>SUCCESS!</strong> {{ $cat->sample_test_Id }} {{$msg}}.
        </div>
        @endif
        <table  class="display table table-bordered table-striped" id="dynamic-table">
            <thead>
            <?php $j=0;?>
            <tr>
            <th>#</th>
            <th>Patient Name</th>
            <th>File Number</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Procedure</th>
            <th>Assigned SampleID</th>
            <th>Action</th>
            </thead>
            <tbody>
            @foreach($sample as $sample)
            <tr>

                <td>{{++$j}}</td>
                <td>{{$sample->patient->firstName}} {{$sample->patient->middleName}} {{$sample->patient->lastName}}</td>
                <td>{{$sample->hosp_reg_no}}</td>
                <td>{{$sample->patient->dob}}</td>
                <td>{{$sample->patient->gender}}</td>

                <td>{{$sample->procedure->name}}</td>
                <td>{{$sample->sample_test_Id}}</td>
                <td class="table-condensed col-xs-pull-2" id="{{ $sample->id }}">
                    <div class="btn-group btn-group-xs" >

                        <a class="btn btn-primary" title="Accept Sample" href='{{ url("kubali/{$sample->id}") }}'>
                            <i class="fa fa-hdd-o"></i>
                            Accept Sample.
                        </a>
                        <a class="btn btn-danger"  title="Reject Sample" href='{{ url("sample/reject/{$sample->id}") }}'>
                            <i class="fa fa-minus"></i>
                            Reject Sample.
                        </a>


                    </div>
                </td>
            </tr>
            @endforeach
            </tbody>

        </table>
    </div>

</section>



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
                $.post("<?php echo url('sample/delete') ?>/"+id1,function(data){
                    btn.hide("slow").next("hr").hide("slow");
                });
            });
        });//endof deleting category
    })
</script>

<!--dynamic table initialization -->
<script src="{{ asset('js/dynamic_table_init.js') }}"></script>


@stop