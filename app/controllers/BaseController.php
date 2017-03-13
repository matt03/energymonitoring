<?php

class BaseController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }

    public function processRegion($offencequery,$value,$title=""){

        if($value != ""){
            $title.=" From ";
            foreach($value as $reg){
                $title .=  Region::find($reg)->region.",";
            }
            $title. " Regions ";

            $offencequery->whereIn('region_id', $value);

        }
        return array($offencequery,$title);
    }

    public function processDistrict($offencequery,$value,$title=""){
        if($value != ""){
            $title.=" From ";
            foreach($value as $reg){
                $title .=  District::find($reg)->district.",";
            }
            $title. " Districts ";
            $offencequery->whereIn('district_id', $value);
        }
        return array($offencequery,$title);
    }

    public function processOffence($offencequery,$value,$title=""){
        if($value != ""){
            $title.=" With ";
            foreach($value as $reg){
                $title .=  $reg.",";
            }
            $title. " Offences ";
            $offencequery->whereIn('offence', $value);
        }
        return array($offencequery,$title);
    }

    public function processSection($offencequery,$value,$title=""){
        if($value != ""){
            $title.=" With ";
            foreach($value as $reg){
                $title .=  $reg.",";
            }
            $title. " Regions ";
            $offencequery->whereIn('section', $value);
        }
        return array($offencequery,$title);
    }


    public function maxAge(){
        $query = Licence::all();
        $datearr = array();
        foreach($query as $patient) {
            $dat = strtotime($patient->dob);
            $dat1 = date("Y", $dat);
            $datearr[] = $dat1;
        }
        $len = count($datearr)-1;
        rsort($datearr,SORT_NUMERIC);
        $age  = date("Y")-$datearr[$len];
        return $age;
    }



}
