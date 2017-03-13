<?php

class EnergyController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $energy = Hospital::all();
        return View::make('energy.index',compact('energy'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $region = Region::all();
        return View::make('energy.add',compact('region'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
       $hospital =  Hospital::create(array(

            'name' => Input::get('name'),
            'setting' => "n",
            'district_id' => Input::get('district')

        ));
        $msg = "was added successfully";
        $region = Region::all();
        return View::make('energy.add',compact('msg','region','hospital'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $hospital = Hospital::find($id);
        $district = District::all();
        return View::make('energy.edit', compact('hospital','district'));


    }


    /**
     * Update the specified resource in storage.
     *

     * @return Response
     */
    public function update()
    {
        $id = Input::get('id');
        $hosp = Hospital::find($id);
        $hosp->name=Input::get('name');
        $hosp->district_id=Input::get('district');
        $hosp->save();
        $msg ="Was Edited successfully ";
        $hospital = Hospital::all();
        return View::make('energy.index', compact('hosp','hospital','msg'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $hospital = Hospital::find($id);
//        $energy->delete();
        return View::make('energy.index',compact('hospital'));
    }


}
