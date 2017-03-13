@extends('layout.master')
@section('title')


@section('contents')
<h4>Specific Indicators</h4>
{{ Form::open(array("method"=>"post","url"=>url("report/download"),"class"=>"form-horizontal","id"=>'formms')) }}
<div class='form-group' style="margin-bottom: 5px">

    <div class='col-sm-2'>
        Region<br>{{ Form::select('region[]',Region::all()->lists('region','id'),'',array('multiple'=>"multiple",'class'=>'form-control multi')) }}
    </div>
    <div class='col-sm-2'>
        District<br><span id="district-area">{{ Form::select('district[]',District::lists('district','id'),'',array('multiple'=>"multiple",'class'=>'form-control multi')) }}</span>
    </div>
    <div class='col-sm-2'>
        Hospital<br><span id="district-area">{{ Form::select('energy',Hospital::lists('name','id'),'',array('multiple'=>"multiple",'class'=>'form-control multi')) }}
    </div>
    <div class='col-sm-2'>
        Diagnosis<br>{{ Form::select('diagnosis[]',Diagnosis::lists('name','id'),'',array('multiple'=>"multiple",'class'=>'form-control multi')) }}
    </div>

    <div class='col-sm-2'>
        From:{{ Form::text('from','',array('class'=>'form-control','placeholder'=>'Start Date','id'=>'from','min'=>'1899-01-01', 'max'=>'2000-13-13')) }}
    </div>
    <div class='col-sm-2'>
        To:{{ Form::text('to','',array('class'=>'form-control','placeholder'=>'End Date','id'=>'to','min'=>'1899-01-01', 'max'=>'2000-13-13')) }}
    </div>
</div>
<div class='form-group'>
    <div class='col-sm-2'>
        <?php
        $arrayy = array(
            "General" => "General",
            "Regions" => "Regions",
            "Districts" => "Districts",
            "Hospital" => "Hospital",
            "Diagnosis" => "Diagnosis",
            "Gender" => "Gender",
            "Payment" => "Payment",
        );
        ?>
        Show<br>{{ Form::select('show',$arrayy,'',array('class'=>'form-control multi')) }}
    </div>
    <div class='col-sm-2'>
        Patient Gender<br>{{ Form::select('vertical',array("all"=>"all","male"=>"male","female"=>"female"),'',array('class'=>'form-control','required'=>'required')) }}
    </div>
    <div class='col-sm-4'>
        Horizontal<br>{{ Form::select('horizontal',array("Year"=>"Year","Years"=>"Years","Age Range"=>"Age Range","No of Patient"=>"No of people involved in the case"),'',array('class'=>'form-control','required'=>'requiered')) }}
    </div>

    <div class='col-sm-4 year'>
        Year <br>{{ Form::select('year',array_combine(range(date('Y'),1970), range(date('Y'),1970)),date('Y'),array('class'=>'form-control')) }}
    </div>
    <div class='col-sm-4 age'>
        Age Range <br>{{ Form::select('age',array_combine(range(3,10), range(3,10)),'',array('class'=>'form-control')) }}
    </div>
    <div class='col-sm-4 years'>
        <div class='col-sm-6'>
            Start <br>{{ Form::select('start',array_combine(range(date('Y'),1970), range(date('Y'),1970)),date('Y')-7,array('class'=>'form-control')) }}
        </div>
        <div class='col-sm-6'>
            End<br>{{ Form::select('end',array_combine(range(date('Y'),1970), range(date('Y'),1970)),date('Y'),array('class'=>'form-control')) }}
        </div>
    </div>
</div>

<div class="col-xs-12" style="margin-top: 5px">
    <div class="col-md-2 btn btn-default btn-sm" id="table"><img src="{{ asset('table.png') }}" style="height: 20px;width: 20px" /> Table</div>
    <div class="col-md-2 btn btn-default btn-sm" id="bar"><img src="{{ asset('bar.png') }}" style="height: 20px;width: 20px" /> Bar</div>
    <div class="col-md-2 btn btn-default btn-sm" id="line"><img src="{{ asset('line.png') }}" style="height: 20px;width: 20px" /> Line</div>
    <div class="col-md-2 btn btn-default btn-sm" id="column"><img src="{{ asset('column.png') }}" style="height: 20px;width: 20px" /> Column</div><div class="col-md-2 btn btn-default" id="pie"><img src="{{ asset('pie.png') }}" style="height: 20px;width: 20px" /> Pie</div>
    <div class="col-md-2 btn btn-default btn-sm" id="combined"><img src="{{ asset('combined.jpg') }}" style="height: 20px;width: 20px" /> Combined</div>
    <button type="submit" class="col-md-2 btn btn-default btn-sm" id="excel"><img src="{{ asset('cvs.jpg') }}" style="height: 20px;width: 20px" /> Excel</button>
</div>
{{ Form::close() }}
<div id="chartarea" class="col-xs-12" style="margin-top: 10px"></div>
    <script>
        $(document).ready(function (){
//            $('.multi').multiselect();
            $('.multi').SumoSelect();

            //minimizing the size of input fields
            $("select,input").addClass('input-sm')
            //hidding and showing advance filters

            var year = $('.year').html();
            var years = $('.years').html();
            var age = $('.age').html();
            $(".years,.age").html("")
            $( "#from" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:"yy-mm-dd",
                onClose: function( selectedDate ) {
                    $( "#to" ).datepicker( "option", "minDate", selectedDate );
                }
            });
            $( "#to" ).datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat:"yy-mm-dd",
                onClose: function( selectedDate ) {
                    $( "#from" ).datepicker( "option", "maxDate", selectedDate );
                    if($("#from").val() != ""){
                        $("select[name=horizontal]").val("Age Range");
                        $('.year').html("");
                        $(".years").html("");
                        $('.age').html(age);
                    }
                }
            });

            $("select[name=region]").change(function(){
                $("#district-area").html("<i class='fa fa-spinner fa-spin'></i> Wait... ")
                $.post("<?php echo url('patient/region_check1') ?>/"+$(this).val(),function(dat){
                    $("#district-area").html(dat);
                })
            })


            $("select[name=horizontal]").change(function(){
                if($(this).val() == "Year"){
                    $('.year').html(year);
                    $(".years,.age").html("")
                    $( "#from,#to").val("").datepicker( "refresh" );
                }else if($(this).val() == "Years"){
                    $('.year,.age').html("");
                    $(".years").html(years);
                    $( "#from,#to").val("").datepicker( "refresh" );
                }else if($(this).val() == "Age Range"){
                    $('.year,.years').html("");
                    $('.age').html(age);
                }
            });

            //managing chats buttons
            $("#table").unbind("click").click(function(){
                $(".btn").removeClass("btn-info")
                $(this).addClass("btn-info")
                $("#chartarea").html("<h3><i class='fa fa-spin fa-spinner '></i><span>Loading...</span><h3>");
                $("#formms").ajaxSubmit({
                    url:"<?php echo url('report/general/table') ?>",
                    target: '#chartarea',
                    data: {chat:'table'},
                    success:  afterSuccess
                });
            });
            $("#table").trigger("click");

            $("#pie").unbind("click").click(function(){
                $(".btn").removeClass("btn-info")
                $(this).addClass("btn-info")
                $("#chartarea").html("<h3><i class='fa fa-spin fa-spinner '></i><span>Loading...</span><h3>");
                $("#formms").ajaxSubmit({
                    url:"<?php echo url('report/general/pie') ?>",
                    target: '#chartarea',
                    data: {chat:'table'},
                    success:  afterSuccess
                });
            });

            $("#bar").unbind("click").click(function(){
                $(".btn").removeClass("btn-info")
                $(this).addClass("btn-info")
                $("#chartarea").html("<h3><i class='fa fa-spin fa-spinner '></i><span>Loading...</span><h3>");
                $("#formms").ajaxSubmit({
                    url:"<?php echo url('report/general/bar') ?>",
                    target: '#chartarea',
                    data: {chat:'table'},
                    success:  afterSuccess
                });
            });

            $("#combined").unbind("click").click(function(){
                $(".btn").removeClass("btn-info")
                $(this).addClass("btn-info")
                $("#chartarea").html("<h3><i class='fa fa-spin fa-spinner '></i><span>Loading...</span><h3>");
                $("#formms").ajaxSubmit({
                    url:"<?php echo url('report/general/combined') ?>",
                    target: '#chartarea',
                    data: {chat:'table'},
                    success:  afterSuccess
                });
            });

            $("#exceewl").unbind("click").click(function(){
                $(".btn").removeClass("btn-info")
                $(this).addClass("btn-info")
                $("#chartarea").html("<h3><i class='fa fa-spin fa-spinner '></i><span>Loading...</span><h3>");
                $("#formms").ajaxSubmit({
                    url:"<?php echo url('reports/download') ?>",
                    target: '#chartarea',
                    data: {chat:'table'},
                    success:  afterSuccess
                });
            });

            $("#column").unbind("click").click(function(){
                $(".btn").removeClass("btn-info")
                $(this).addClass("btn-info")
                $("#chartarea").html("<h3><i class='fa fa-spin fa-spinner '></i><span>Loading...</span><h3>");
                $("#formms").ajaxSubmit({
                    url:"<?php echo url('report/general/column') ?>",
                    target: '#chartarea',
                    data: {chat:'table'},
                    success:  afterSuccess
                });
            });

            $("#line").unbind("click").click(function(){
                $(".btn").removeClass("btn-info")
                $(this).addClass("btn-info")
                $("#chartarea").html("<h3><i class='fa fa-spin fa-spinner '></i><span>Loading...</span><h3>");
                $("#formms").ajaxSubmit({
                    url:"<?php echo url('report/general/line') ?>",
                    target: '#chartarea',
                    data: {chat:'table'},
                    success:  afterSuccess
                });
            });
        });

        function afterSuccess(){

        }

    </script>
<script>
    $(function(){
        $('[type="date"]').prop('max', function(){
            return new Date().toJSON().split('T')[0];
        });
    });
</script>
    @stop