<?php

class ReportDController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return View::make("report.index");
    }

    public function processQuery($offencequery){
        $quer = parent::processRegion($offencequery,Input::get('region'),"");
        $query = parent::processDistrict($quer[0],Input::get('district'),$quer[1]);
//        $query1 = parent::processOffence($query[0],Input::get('offence'),$query[2]);
//        $query2 = parent::processSection($query1[0],Input::get('section'),$query1[2]);


        echo ($quer);

        return $query;
    }

    public function generateArray($value){
        if($value == "General"){
            $columntype = array("Offences"=>"Offences");
        }
        if($value == "Regions"){
            $columntype = Input::get('region');
        }
        if($value == "Districts"){
            $columntype = Input::get('district');
        }
        if($value == "Hospital"){
            $columntype = Input::get('energy');
        }
        if($value == "Diagnosis"){
            $columntype = Input::get('diagnosis');
        }
        if($value == "Gender"){
            $columntype = array('Male'=>'Male','Female'=>'Female');
        }
        if($value == "Payment"){
            $columntype = array('Cleared'=>'Cleared','Not Cleared'=>'Not Cleared');
        }
        echo ($columntype);
//        return $columntype;
    }
    public function checkCondition($query,$pat,$key1){
        switch(Input::get('show')){
            case "General":
                $que = $query[0]->where('id','!=',$key1);
                break;
            case "Gender":
                $que = $query[0]->whereIn('license', Patient::where('gender',$key1)->get()->lists('firstName', 'id')+array('0'));
                break;
            case "Regions":
                $que = $query[0]->where('region_id', $key1);
                break;
            case "Districts":
                $que = $query[0]->where('district_id', $key1);
                break;
            case "Payment":
                $que = $query[0]->where('id', $key1);
                break;
        }
        echo ($que);
        return $que;
    }

    public function makeTable(){
        echo "mefika";

        $title = "";
        $pat = true;
        $row = array();
        $column = array();

        $columntype = $this->generateArray(Input::get("show"));
        echo ($columntype);

        if(Input::get("horizontal") == "Year"){
            $row = array("01"=>"jan","02"=>"feb","03"=>"mar","04"=>"apr","05"=>"may","06"=>"jun","07"=>"jul","08"=>"aug","09"=>"sep","10"=>"oct","11"=>"nov","12"=>"dec");

            foreach($row as $key => $value){
                $from = Input::get('year')."-".$key."-01";
                $to = Input::get('year')."-".$key."-31";
                if(isset($columntype)){
                    foreach($columntype as $key1=>$value1){
                        $sampleQuery = DB::table('samples');
                        $query = $this->processQuery($sampleQuery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereBetween('created_at',array($from,$to));
                        $column[$value1][] = $que->count();
                    }
                    $title = Input::get('vertical')." ". $query[1]." ".Input::get('year');;
                }
            }

        }
        elseif(Input::get("horizontal") == "Years"){
            $row = range(Input::get('start'),Input::get('end'));

            foreach($row as $value){
                $from = $value."-01-01";
                $to = $value."-12-31";
                if(isset($columntype)){
                    foreach($columntype as $key1=>$value1){
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereBetween('created_at',array($from,$to));
                        $column[$value1][] = $que->count();
                    }
                    $title = Input::get('vertical')." ". $query[1]." ".Input::get('start')." - ".Input::get('end');
                }
            }
        }
        elseif(Input::get("horizontal") == "Age Range"){
            //setting the limits
            if((parent::maxAge()%Input::get('age')) == 0){
                $limit = parent::maxAge();
            } else{
                $limit = (parent::maxAge()-(parent::maxAge()%Input::get('age')))+Input::get('age');
            }
            //making a loop for values
            //year iterator
            $k = 0;
            //getting age
            $range = Input::get('age');
            $yeardate = date("Y")+1;
            $yaerdate1 = $yeardate."-01-01";

            //creating title
            $data = array();
            for($i=$range;$i<=$limit;$i+=$range){
                $row[] = $k ." - ". $i;
                //start year
                $time = $k*365*24*3600;
                $today = date("Y-m-d");
                $timerange = strtotime($today) - $time;
                $start  = (date("Y",$timerange)+1)."-01-01";
                //end year
                $time1 = $i*365*24*3600;
                $timerange1 = strtotime($today) - $time1;
                $end = date("Y",$timerange1)."-01-01";
                if(isset($columntype)){
                    foreach($columntype as $key1=>$value1){
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereIn('license', Licence::whereBetween('dob',array($end,$start))->get()->lists('licenceNo')+array('0'));
                        $column[$value1][] = $que->count();
                    }
                    $title = Input::get('vertical')." Age Range ". $query[1];
                }
                $k=$i;
            }
        }


        ?>
        <h4 class="text-center"><?php echo $title ?></h4>
        <table class="table table-responsive table-bordered">
            <tr>
                <th><?php echo Input::get("show") ?></th>
                <?php
                foreach($row as $header){
                    echo "<th>$header</th>";
                }
                ?>
            </tr>
            <?php foreach($column as $keys => $cols){ ?>
                <tr>
                    <td><?php
                        if(Input::get('show') == 'Regions'){
                            echo Region::find($keys)->region;
                        }elseif(Input::get('show') == 'Districts' ){
                            echo District::find($keys)->district;
                        }else{
                            echo $keys;
                        }
                        ?></td>
                    <?php
                    foreach($cols as $colsval){
                        echo "<td>$colsval</td>";
                    }
                    ?>
                </tr>
            <?php } ?>
        </table>

    <?php

    }

    public function makeBar(){
        echo "mefika";

        $title = "";$pat = false;
        $row = "categories: [";
        $column = "";
        $columntype = $this->generateArray(Input::get("show"));

        if(Input::get("horizontal") == "Year"){
            $row1 = array("01"=>"jan","02"=>"feb","03"=>"mar","04"=>"apr","05"=>"may","06"=>"jun","07"=>"jul","08"=>"aug","09"=>"sep","10"=>"oct","11"=>"nov","12"=>"dec");
            $j = 1;
            foreach($row1 as $value){
                $row .= ($j < count($row1))?"'".$value."',":"'".$value."'";
                $j++;
            }
            $col = 1;
            if(isset($columntype)){
                foreach($columntype as $key1=>$value1){
                    $column.= "{ name: '".$value1."', data: [ ";
                    $i = 1;
                    foreach($row1 as $key => $value){
                        $from = Input::get('year')."-".$key."-01";
                        $to = Input::get('year')."-".$key."-31";
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereBetween('created_at',array($from,$to));
                        $column .= ($i < count($row1))?$que->count().",":$que->count();
                        $i++;
                    }
                    $column .= ($col < count($columntype))?"]},":"]}";
                    $col++;
                }
            }
            $title = Input::get('vertical')." ". $query[1]." ".Input::get('Year');
        }
        elseif(Input::get("horizontal") == "Years"){
            $row1 = range(Input::get('start'),Input::get('end'));
            $j = 1;
            foreach($row1 as $value){
                $row .= ($j < count($row1))?"'".$value."',":"'".$value."'";
                $j++;
            }
            $col = 1;
            if(isset($columntype)){
                foreach($columntype as $key1=>$value1){
                    $column.= "{ name: '".$value1."', data: [ ";
                    $i = 1;
                    foreach($row1 as $key => $value){
                        $from = $value."-01-01";
                        $to = $value."-12-31";
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereBetween('created_at',array($from,$to));
                        $column .= ($i < count($row1))?$que->count().",":$que->count();
                        $i++;
                    }
                    $column .= ($col < count($columntype))?"]},":"]}";
                    $col++;
                }
            }
            $title = Input::get('vertical')." ". $query[1]." ".Input::get('Year');
        }
        elseif(Input::get("horizontal") == "Age Range"){
            //setting the limits
            if((parent::maxAge()%Input::get('age')) == 0){
                $limit = parent::maxAge();
            } else{
                $limit = (parent::maxAge()-(parent::maxAge()%Input::get('age')))+Input::get('age');
            }
            //making a loop for values
            $k = 0;
            //getting age
            $range = Input::get('age');
            $yeardate = date("Y")+1;
            $yaerdate1 = $yeardate."-01-01";

            //creating title
            $j = 1;
            for($i=$range;$i<=$limit;$i+=$range){
                $row .= ($i < $limit)?"'".$k ." - ". $i."',":"'".$k ." - ". $i."'";
                $k=$i;
            }
            $col = 1;
            if(isset($columntype)){
                foreach($columntype as $key1=>$value1){
                    $column.= "{ name: '".$value1."', data: [ ";
                    $i = 1;
                    for($i=$range;$i<=$limit;$i+=$range){
                        //start year
                        $time = $k*365*24*3600;
                        $today = date("Y-m-d");
                        $timerange = strtotime($today) - $time;
                        $start  = (date("Y",$timerange)+1)."-01-01";
                        //end year
                        $time1 = $i*365*24*3600;
                        $timerange1 = strtotime($today) - $time1;
                        $end = date("Y",$timerange1)."-01-01";
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereIn('license', Licence::whereBetween('dob',array($end,$start))->get()->lists('licenceNo')+array('0'));
                        $column .= ($i < $limit)?$que->count().",":$que->count();
                        $k=$i;
                    }
                    $column .= ($col < count($columntype))?"]},":"]}";
                    $col++;
                }
            }

            $title = Input::get('vertical')." Age Range ". $query[1]." ";

        }

        $row .= "]";
        ?>
        <script type="text/javascript">
            $(function () {
                $('#chartarea').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: '<?php echo $title ?>'
                    },
                    xAxis: {
                        <?php echo $row  ?>
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '<?php echo Input::get('vertical') ?>'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:12px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0"> {series.name} :   </td> ' +
                            '<td style="padding:0"><b>{point.y}  </b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [<?php echo $column ?>]
                });
            });


        </script>
    <?php

    }

    public function makeColumn(){
        $title = "";$pat = false;
        $row = "categories: [";
        $column = "";
        $columntype = $this->generateArray(Input::get("show"));

        if(Input::get("horizontal") == "Year"){
            $row1 = array("01"=>"jan","02"=>"feb","03"=>"mar","04"=>"apr","05"=>"may","06"=>"jun","07"=>"jul","08"=>"aug","09"=>"sep","10"=>"oct","11"=>"nov","12"=>"dec");
            $j = 1;
            foreach($row1 as $value){
                $row .= ($j < count($row1))?"'".$value."',":"'".$value."'";
                $j++;
            }
            $col = 1;
            if(isset($columntype)){
                foreach($columntype as $key1=>$value1){
                    $column.= "{ name: '".$value1."', data: [ ";
                    $i = 1;
                    foreach($row1 as $key => $value){
                        $from = Input::get('year')."-".$key."-01";
                        $to = Input::get('year')."-".$key."-31";
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereBetween('created_at',array($from,$to));
                        $column .= ($i < count($row1))?$que->count().",":$que->count();
                        $i++;
                    }
                    $column .= ($col < count($columntype))?"]},":"]}";
                    $col++;
                }
            }
            $title = Input::get('vertical')." ". $query[1]." ".Input::get('Year');
        }
        elseif(Input::get("horizontal") == "Years"){
            $row1 = range(Input::get('start'),Input::get('end'));
            $j = 1;
            foreach($row1 as $value){
                $row .= ($j < count($row1))?"'".$value."',":"'".$value."'";
                $j++;
            }
            $col = 1;
            if(isset($columntype)){
                foreach($columntype as $key1=>$value1){
                    $column.= "{ name: '".$value1."', data: [ ";
                    $i = 1;
                    foreach($row1 as $key => $value){
                        $from = $value."-01-01";
                        $to = $value."-12-31";
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereBetween('created_at',array($from,$to));
                        $column .= ($i < count($row1))?$que->count().",":$que->count();
                        $i++;
                    }
                    $column .= ($col < count($columntype))?"]},":"]}";
                    $col++;
                }
            }
            $title = Input::get('vertical')." ". $query[1]." ".Input::get('Year');
        }
        elseif(Input::get("horizontal") == "Age Range"){
            //setting the limits
            if((parent::maxAge()%Input::get('age')) == 0){
                $limit = parent::maxAge();
            } else{
                $limit = (parent::maxAge()-(parent::maxAge()%Input::get('age')))+Input::get('age');
            }
            //making a loop for values
            $k = 0;
            //getting age
            $range = Input::get('age');
            $yeardate = date("Y")+1;
            $yaerdate1 = $yeardate."-01-01";

            //creating title
            $j = 1;
            for($i=$range;$i<=$limit;$i+=$range){
                $row .= ($i < $limit)?"'".$k ." - ". $i."',":"'".$k ." - ". $i."'";
                $k=$i;
            }
            $col = 1;
            if(isset($columntype)){
                foreach($columntype as $key1=>$value1){
                    $column.= "{ name: '".$value1."', data: [ ";
                    $i = 1;
                    for($i=$range;$i<=$limit;$i+=$range){
                        //start year
                        $time = $k*365*24*3600;
                        $today = date("Y-m-d");
                        $timerange = strtotime($today) - $time;
                        $start  = (date("Y",$timerange)+1)."-01-01";
                        //end year
                        $time1 = $i*365*24*3600;
                        $timerange1 = strtotime($today) - $time1;
                        $end = date("Y",$timerange1)."-01-01";
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereIn('license', Licence::whereBetween('dob',array($end,$start))->get()->lists('licenceNo')+array('0'));
                        $column .= ($i < $limit)?$que->count().",":$que->count();
                        $k=$i;
                    }
                    $column .= ($col < count($columntype))?"]},":"]}";
                    $col++;
                }
            }

            $title = Input::get('vertical')." Age Range ". $query[1]." ";

        }

        $row .= "]";
        ?>
        <script type="text/javascript">
            $(function () {
                $('#chartarea').highcharts({
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: '<?php echo $title ?>'
                    },
                    xAxis: {
                        <?php echo $row  ?>
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '<?php echo Input::get('vertical') ?>'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:12px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0"> {series.name} :   </td> ' +
                            '<td style="padding:0"><b>{point.y}  </b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [<?php echo $column ?>]
                });
            });


        </script>
    <?php

    }

    public function makeCombined(){
        $title = "";$pat = false;
        $row = "categories: [";
        $column = "";
        $column1 = "";
        $columntype = $this->generateArray(Input::get("show"));
        if(Input::get("vertical") == "Patients"){
            $pat = true;
        }elseif(Input::get("vertical") == "Visits"){
            $vis = true;
        }


        if(Input::get("horizontal") == "Year"){
            $row1 = array("01"=>"jan","02"=>"feb","03"=>"mar","04"=>"apr","05"=>"may","06"=>"jun","07"=>"jul","08"=>"aug","09"=>"sep","10"=>"oct","11"=>"nov","12"=>"dec");
            $j = 1;
            foreach($row1 as $value){
                $row .= ($j < count($row1))?"'".$value."',":"'".$value."'";
                $j++;
            }
            $col = 1;
            if(isset($columntype)){
                foreach($columntype as $key1=>$value1){
                    $column.= "{type: 'column', name: '".$value1."', data: [ ";
                    $column1.= "{type: 'spline', name: '".$value1."', data: [ ";
                    $i = 1;
                    foreach($row1 as $key => $value){
                        $from = Input::get('year')."-".$key."-01";
                        $to = Input::get('year')."-".$key."-31";
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereBetween('created_at',array($from,$to));
                        $column .= ($i < count($row1))?$que->count().",":$que->count();
                        $column1 .= ($i < count($row1))?$que->count().",":$que->count();
                        $i++;
                    }
                    $column .= "]},";
                    $column1 .= ($col < count($columntype))?"]},":"]}";
                    $col++;
                }
            }
            $title = Input::get('vertical')." ". $query[1]." ".Input::get('Year');
        }
        elseif(Input::get("horizontal") == "Years"){
            $row1 = range(Input::get('start'),Input::get('end'));
            $j = 1;
            foreach($row1 as $value){
                $row .= ($j < count($row1))?"'".$value."',":"'".$value."'";
                $j++;
            }
            $col = 1;
            if(isset($columntype)){
                foreach($columntype as $key1=>$value1){
                    $column.= "{type: 'column', name: '".$value1."', data: [ ";
                    $column1.= "{type: 'spline', name: '".$value1."', data: [ ";
                    $i = 1;
                    foreach($row1 as $key => $value){
                        $from = $value."-01-01";
                        $to = $value."-12-31";
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereBetween('created_at',array($from,$to));
                        $column .= ($i < count($row1))?$que->count().",":$que->count();
                        $column1 .= ($i < count($row1))?$que->count().",":$que->count();
                        $i++;
                    }
                    $column .= "]},";
                    $column1 .= ($col < count($columntype))?"]},":"]}";
                    $col++;
                }
            }
            $title = Input::get('vertical')." ". $query[1]." ".Input::get('Year');
        }
        elseif(Input::get("horizontal") == "Age Range"){
            //setting the limits
            if((parent::maxAge()%Input::get('age')) == 0){
                $limit = parent::maxAge();
            } else{
                $limit = (parent::maxAge()-(parent::maxAge()%Input::get('age')))+Input::get('age');
            }
            //making a loop for values
            $k = 0;
            //getting age
            $range = Input::get('age');
            $yeardate = date("Y")+1;
            $yaerdate1 = $yeardate."-01-01";

            //creating title
            $j = 1;
            for($i=$range;$i<=$limit;$i+=$range){
                $row .= ($i < $limit)?"'".$k ." - ". $i."',":"'".$k ." - ". $i."'";
                $k=$i;
            }
            $col = 1;
            if(isset($columntype)){
                foreach($columntype as $key1=>$value1){
                    $column.= "{type: 'column', name: '".$value1."', data: [ ";
                    $column1.= "{type: 'spline', name: '".$value1."', data: [ ";
                    $i = 1;
                    for($i=$range;$i<=$limit;$i+=$range){
                        //start year
                        $time = $k*365*24*3600;
                        $today = date("Y-m-d");
                        $timerange = strtotime($today) - $time;
                        $start  = (date("Y",$timerange)+1)."-01-01";
                        //end year
                        $time1 = $i*365*24*3600;
                        $timerange1 = strtotime($today) - $time1;
                        $end = date("Y",$timerange1)."-01-01";
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereIn('license', Licence::whereBetween('dob',array($end,$start))->get()->lists('licenceNo')+array('0'));
                        $column .= ($i < $limit)?$que->count().",":$que->count();
                        $column1 .= ($i < $limit)?$que->count().",":$que->count();
                        $k=$i;
                    }
                    $column .= "]},";
                    $column1 .= ($col < count($columntype))?"]},":"]}";
                    $col++;
                }
            }


            $title = Input::get('vertical')." Age Range ". $query[1]." ";

        }

        $row .= "]";
        ?>
        <script type="text/javascript">
            $(function () {
                $('#chartarea').highcharts({
                    title: {
                        text: '<?php echo $title ?>'
                    },
                    xAxis: {
                        <?php echo $row  ?>
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: '<?php echo Input::get('vertical') ?>'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:12px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0"> {series.name} :   </td> ' +
                            '<td style="padding:0"><b>{point.y}  </b></td></tr>',
                        footerFormat: '</table>',
                        shared: true,
                        useHTML: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: [<?php echo $column.$column1 ?>]
                });
            });


        </script>
    <?php

    }

    public function makeLine(){
        $title = "";$pat = false;
        $row = "categories: [";
        $column = "";
        $columntype = $this->generateArray(Input::get("show"));
        if(Input::get("vertical") == "Patients"){
            $pat = true;
        }elseif(Input::get("vertical") == "Visits"){
            $vis = true;
        }


        if(Input::get("horizontal") == "Year"){
            $row1 = array("01"=>"jan","02"=>"feb","03"=>"mar","04"=>"apr","05"=>"may","06"=>"jun","07"=>"jul","08"=>"aug","09"=>"sep","10"=>"oct","11"=>"nov","12"=>"dec");
            $j = 1;
            foreach($row1 as $value){
                $row .= ($j < count($row1))?"'".$value."',":"'".$value."'";
                $j++;
            }
            $col = 1;
            if(isset($columntype)){
                foreach($columntype as $key1=>$value1){
                    $column.= "{ name: '".$value1."', data: [ ";
                    $i = 1;
                    foreach($row1 as $key => $value){
                        $from = Input::get('year')."-".$key."-01";
                        $to = Input::get('year')."-".$key."-31";
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereBetween('created_at',array($from,$to));
                        $column .= ($i < count($row1))?$que->count().",":$que->count();
                        $i++;
                    }
                    $column .= ($col < count($columntype))?"]},":"]}";
                    $col++;
                }
            }
            $title = Input::get('vertical')." ". $query[1]." ".Input::get('Year');
        }
        elseif(Input::get("horizontal") == "Years"){
            $row1 = range(Input::get('start'),Input::get('end'));
            $j = 1;
            foreach($row1 as $value){
                $row .= ($j < count($row1))?"'".$value."',":"'".$value."'";
                $j++;
            }
            $col = 1;
            if(isset($columntype)){
                foreach($columntype as $key1=>$value1){
                    $column.= "{ name: '".$value1."', data: [ ";
                    $i = 1;
                    foreach($row1 as $key => $value){
                        $from = $value."-01-01";
                        $to = $value."-12-31";
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereBetween('created_at',array($from,$to));
                        $column .= ($i < count($row1))?$que->count().",":$que->count();
                        $i++;
                    }
                    $column .= ($col < count($columntype))?"]},":"]}";
                    $col++;
                }
            }
            $title = Input::get('vertical')." ". $query[1]." ".Input::get('Year');
        }
        elseif(Input::get("horizontal") == "Age Range"){
            //setting the limits
            if((parent::maxAge()%Input::get('age')) == 0){
                $limit = parent::maxAge();
            } else{
                $limit = (parent::maxAge()-(parent::maxAge()%Input::get('age')))+Input::get('age');
            }
            //making a loop for values
            $k = 0;
            //getting age
            $range = Input::get('age');
            $yeardate = date("Y")+1;
            $yaerdate1 = $yeardate."-01-01";

            //creating title
            $j = 1;
            for($i=$range;$i<=$limit;$i+=$range){
                $row .= ($i < $limit)?"'".$k ." - ". $i."',":"'".$k ." - ". $i."'";
                $k=$i;
            }
            $col = 1;
            if(isset($columntype)){
                foreach($columntype as $key1=>$value1){
                    $column.= "{ name: '".$value1."', data: [ ";
                    $i = 1;
                    for($i=$range;$i<=$limit;$i+=$range){
                        //start year
                        $time = $k*365*24*3600;
                        $today = date("Y-m-d");
                        $timerange = strtotime($today) - $time;
                        $start  = (date("Y",$timerange)+1)."-01-01";
                        //end year
                        $time1 = $i*365*24*3600;
                        $timerange1 = strtotime($today) - $time1;
                        $end = date("Y",$timerange1)."-01-01";
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereIn('license', Licence::whereBetween('dob',array($end,$start))->get()->lists('licenceNo')+array('0'));
                        $column .= ($i < $limit)?$que->count().",":$que->count();
                        $k=$i;
                    }
                    $column .= ($col < count($columntype))?"]},":"]}";
                    $col++;
                }
            }

            $title = Input::get('vertical')." Age Range ". $query[1]." ";

        }
        $row .= "]";
        ?>
        <script type="text/javascript">
            $(function () {
                $('#chartarea').highcharts({
                    title: {
                        text: '<?php echo $title ?>'
                    },
                    xAxis: {
                        <?php echo $row  ?>
                    },
                    yAxis: {
                        title: {
                            text: '<?php echo Input::get('vertical') ?>'
                        },
                        plotLines: [{
                            value: 0,
                            width: 1,
                            color: '#808080'
                        }]
                    },
                    tooltip: {
                        valueSuffix: '<?php  Input::get('vertical') ?>'
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0
                    },
                    series: [<?php echo $column ?>]
                });
            });
        </script>
    <?php

    }

    public function makePie(){
        $title = "";$pat = false;
        $row = "categories: [";
        $column = "";
        $columntype = $this->generateArray(Input::get("show"));
        if(Input::get("vertical") == "Patients"){
            $pat = true;
        }elseif(Input::get("vertical") == "Visits"){
            $vis = true;
        }


        if(Input::get("horizontal") == "Year"){
            $row1 = array("01"=>"jan","02"=>"feb","03"=>"mar","04"=>"apr","05"=>"may","06"=>"jun","07"=>"jul","08"=>"aug","09"=>"sep","10"=>"oct","11"=>"nov","12"=>"dec");
            $j = 1;
            foreach($row1 as $value){
                $row .= ($j < count($row1))?"'".$value."',":"'".$value."'";
                $j++;
            }
            $col = 1;
            if(isset($columntype)){
                $column.= "{ type:'pie' name: 'Patients', data: [ ";
                foreach($columntype as $key1=>$value1){

                    $i = 1;
                    foreach($row1 as $key => $value){
                        $from = Input::get('year')."-".$key."-01";
                        $to = Input::get('year')."-".$key."-31";
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereBetween('created_at',array($from,$to));
                        $column .= ($i < count($row1))?"['".$value."',".$que->count()."],":"['".$value."',".$que->count()."]";
                        $i++;
                    }

                    $col++;
                }
                $column .= "]}";
            }
            $title = Input::get('vertical')." ". $query[1]." ".Input::get('Year');
        }
        elseif(Input::get("horizontal") == "Years"){
            $row1 = range(Input::get('start'),Input::get('end'));
            $j = 1;
            foreach($row1 as $value){
                $row .= ($j < count($row1))?"'".$value."',":"'".$value."'";
                $j++;
            }
            $col = 1;
            if(isset($columntype)){
                foreach($columntype as $key1=>$value1){
                    $column.= "{ name: '".$value1."', data: [ ";
                    $i = 1;
                    foreach($row1 as $key => $value){
                        $from = $value."-01-01";
                        $to = $value."-12-31";
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereBetween('created_at',array($from,$to));
                        $column .= ($i < count($row1))?$que->count().",":$que->count();
                        $i++;
                    }
                    $column .= ($col < count($columntype))?"]},":"]}";
                    $col++;
                }
            }
            $title = Input::get('vertical')." ". $query[1]." ".Input::get('Year');
        }
        elseif(Input::get("horizontal") == "Age Range"){
            //setting the limits
            if((parent::maxAge()%Input::get('age')) == 0){
                $limit = parent::maxAge();
            } else{
                $limit = (parent::maxAge()-(parent::maxAge()%Input::get('age')))+Input::get('age');
            }
            //making a loop for values
            $k = 0;
            //getting age
            $range = Input::get('age');
            $yeardate = date("Y")+1;
            $yaerdate1 = $yeardate."-01-01";

            //creating title
            $j = 1;
            for($i=$range;$i<=$limit;$i+=$range){
                $row .= ($i < $limit)?"'".$k ." - ". $i."',":"'".$k ." - ". $i."'";
                $k=$i;
            }
            $col = 1;
            if(isset($columntype)){
                foreach($columntype as $key1=>$value1){
                    $column.= "{ name: '".$value1."', data: [ ";
                    $i = 1;
                    for($i=$range;$i<=$limit;$i+=$range){
                        //start year
                        $time = $k*365*24*3600;
                        $today = date("Y-m-d");
                        $timerange = strtotime($today) - $time;
                        $start  = (date("Y",$timerange)+1)."-01-01";
                        //end year
                        $time1 = $i*365*24*3600;
                        $timerange1 = strtotime($today) - $time1;
                        $end = date("Y",$timerange1)."-01-01";
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereIn('license', Licence::whereBetween('dob',array($end,$start))->get()->lists('licenceNo')+array('0'));
                        $column .= ($i < $limit)?$que->count().",":$que->count();
                        $k=$i;
                    }
                    $column .= ($col < count($columntype))?"]},":"]}";
                    $col++;
                }
            }

            $title = Input::get('vertical')." Age Range ". $query[1]." ";

        }

        $row .= "]";
        ?>
        <script type="text/javascript">
            $(function () {
                $('#chartarea').highcharts({
                    chart: {
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0
                        }
                    },
                    title: {
                        text: 'Browser market shares at a specific website, 2014'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            depth: 35,
                            dataLabels: {
                                enabled: true,
                                format: '{point.name}'
                            }
                        }
                    },
                    series: [<?php echo $column ?>]
                });
            });


        </script>
    <?php

    }

    /**
     * a function to export data to excel
     */
    public function excelDownload(){
        /** Include PHPExcel */
        require_once dirname(__FILE__) . '/Classes/PHPExcel.php';
        $title = "";$pat = false;
        $row = array();
        $column = array();
        $columntype = $this->generateArray(Input::get("show"));

        if(Input::get("horizontal") == "Year"){
            $row = array("01"=>"jan","02"=>"feb","03"=>"mar","04"=>"apr","05"=>"may","06"=>"jun","07"=>"jul","08"=>"aug","09"=>"sep","10"=>"oct","11"=>"nov","12"=>"dec");

            foreach($row as $key => $value){
                $from = Input::get('year')."-".$key."-01";
                $to = Input::get('year')."-".$key."-31";
                if(isset($columntype)){
                    foreach($columntype as $key1=>$value1){
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereBetween('created_at',array($from,$to));
                        $column[$value1][] = $que->count();
                    }
                    $title = Input::get('vertical')." ". $query[1]." ".Input::get('year');;
                }
            }
        }
        elseif(Input::get("horizontal") == "Years"){
            $row = range(Input::get('start'),Input::get('end'));

            foreach($row as $value){
                $from = $value."-01-01";
                $to = $value."-12-31";
                if(isset($columntype)){
                    foreach($columntype as $key1=>$value1){
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereBetween('created_at',array($from,$to));
                        $column[$value1][] = $que->count();
                    }
                    $title = Input::get('vertical')." ". $query[1]." ".Input::get('start')." - ".Input::get('end');
                }
            }
        }
        elseif(Input::get("horizontal") == "Age Range"){
            //setting the limits
            if((parent::maxAge()%Input::get('age')) == 0){
                $limit = parent::maxAge();
            } else{
                $limit = (parent::maxAge()-(parent::maxAge()%Input::get('age')))+Input::get('age');
            }
            //making a loop for values
            //year iterator
            $k = 0;
            //getting age
            $range = Input::get('age');
            $yeardate = date("Y")+1;
            $yaerdate1 = $yeardate."-01-01";

            //creating title
            $data = array();
            for($i=$range;$i<=$limit;$i+=$range){
                $row[] = $k ." - ". $i;
                //start year
                $time = $k*365*24*3600;
                $today = date("Y-m-d");
                $timerange = strtotime($today) - $time;
                $start  = (date("Y",$timerange)+1)."-01-01";
                //end year
                $time1 = $i*365*24*3600;
                $timerange1 = strtotime($today) - $time1;
                $end = date("Y",$timerange1)."-01-01";
                if(isset($columntype)){
                    foreach($columntype as $key1=>$value1){
                        $offencequery = DB::table('samples');
                        $query = $this->processQuery($offencequery);
                        $que = $this->checkCondition($query,$pat,$key1)->whereIn('license', Licence::whereBetween('dob',array($end,$start))->get()->lists('licenceNo')+array('0'));
                        $column[$value1][] = $que->count();
                    }
                    $title = Input::get('vertical')." Age Range ". $query[1];
                }
                $k=$i;
            }
        }





        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle( $title )
            ->setSubject($title)
            ->setDescription($title)
            ->setKeywords("office 2007 openxml php")
            ->setCategory($title);

        ?>
        <?php

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', Input::get('show'));

        $k=0;
        $latter = array("B","C","D","E","F","G","H","I","J","K","L","M");
        foreach($row as $header){
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($latter[$k]."1", $header);
            $k++;
        }
        ?>
        <?php
        $j=2;

        foreach($column as $keys => $cols){ ?>
            <tr>
                <td><?php
                    if(Input::get('show') == 'Regions'){
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$j, Region::find($keys)->region);
                    }elseif(Input::get('show') == 'Districts' ){
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$j, District::find($keys)->district);
                    }else{
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A'.$j, $keys);
                    }
                    ?></td>
                <?php
                $m=0;
                foreach($cols as $colsval){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($latter[$m].$j, $colsval);
                    $k++;
                }
                ?>
            </tr>
            <?php
            $j++;} ?>

        <?php

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle($title);


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="01simple.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

}