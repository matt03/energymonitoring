<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Charts;


class ReportController extends \BaseController {

    /**
     * Display the specified resource.

     * @return Response
     */
    public function index()
    {
        $chart = Charts::create('line', 'highcharts')
            ->setView('custom.line.chart.view') // Use this if you want to use your own template
            ->setTitle('My nice chart')
            ->setLabels(['First', 'Second', 'Third'])
            ->setValues([5,10,20])
            ->setDimensions(1000,500)
            ->setResponsive(false);
        return view('test', ['chart' => $chart]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function download_pdf($id)
    {
        $sample= Sample::find($id);
        $view = View::make('sample.report',compact('sample'))->render();
        $content = (string) $view;

        $pdf = new \Thujohn\Pdf\Pdf();
        $pdf = $pdf->load($content)->download('trial.pdf');
//        return $pdf->downlod('trial.pdf');
//        return Response::download($file, 'filename.pdf', $headers);
//        $sample= Sample::find($id);
//        echo($sample);
//        $pdf = new \Thujohn\Pdf\Pdf();
//        $content = $pdf->load(View::make('sample.report',compact('sample')))->output();
//        print_r($content);

//        File::put(public_path('test.pdf'), $content);
//        $pdf = PDF::loadView('sample.report',compact('sample'))->setPaper('a4')->setOrientation('portrait')->setWarnings(false);
//        return $pdf->stream('trial.pdf');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function store($id)
    {
        $patient = Patient::find($id);
        foreach(Input::get('testCategory') as $option){
            if($option != 0 ){

                $testCategory = Treatment::create(array(
                    'patient_id' => Input::get('patient_id'),
                    'testCategory_id' => $option,
                    'history' => Input::get('history')

                ));

            }
            $msg = "Added successful!";

        }

        return View::make('opd.labTest', compact('testCategory','patient'));

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function download($id)
    {

        $cat = Sample::find($id);
        $file= public_path(). "/reference/".$cat->attachment;
        $filename = $cat->patient->firstName." " .$cat->patient->middleName. " ".$cat->patient->firstName." ".$cat->sample_test_Id .".".$cat->extension;


        return Response::download($file, $filename);






    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


}
