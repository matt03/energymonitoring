@extends('layout.master')

@section('contents')



    <section class="panel panel-success" xmlns="http://www.w3.org/1999/html">
        <header class="panel-heading ">
            Lab test Queue
        </header>
            <table  class="display table table-bordered table-striped" id="dynamic-table">
                <thead>
                <?php $j=0;?>
                <tr>
                    <th>#</th>
                    <th>Patient Name (s)</th>
                </thead>
                <tbody>
                @foreach($queue as $queue)
                    <tr>

                        <td>{{++$j}}</td>
                        <td>{{$queue->patient->firstName}} {{$queue->patient->middleName}} {{$queue->patient->lastName}}</td>
                        <td>Action</td>

{{--                        <td>{{$patient->labTest->price}}</td>--}}
                        <td class="table-condensed col-xs-pull-2" id="{{ $queue->id }}">
                            <div class="btn-group btn-group-xs" >

                                <a class="btn btn-primary" title="Receive" href='{{ url("receive/{$queue->patient->id}") }}'>
                                    <i class="fa fa-hdd-o"></i>
                                    Receive.
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