<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::controller('password', 'RemindersController');

Route::get('/', function()
{
	return View::make('dashboard');
});

Route::get('user', function()
{
	return View::make('users.index');
});

Route::get('dashboard', function()
{
    return View::make('dashboard');
});

Route::get('login', function()
{
    return View::make('users.login');
});



;




Route::resource('dashboard' , 'DashboardController');

Route::resource('stakeholder' , 'StakeholderController');

//********************************************************/
//********************* Login **************************/
//********************************************************/
Route::get('login', array('uses'=>'LoginController@index')); //display login form
Route::post('login', array('uses'=>'LoginController@login')); //process login form
Route::get('logout', array('uses'=>'LoginController@logout')); //process logout functionality

//**********************************************************/
//********************* User *******************************/
//*************************************************?********/
Route::get('user', array('uses'=>'UserController@index')); //display list of users
Route::get('user/add', array('uses'=>'UserController@create')); //add users
Route::post('user/add', array('uses'=>'UserController@store')); //processing added users
Route::get('user/delete/{id}', array('uses'=>'UserController@destroy')); //add users
Route::get('user/edit/{id}', array('uses'=>'UserController@update')); //edit users
Route::post('user/edit/{id}', array('uses'=>'UserController@edit')); //process edited users
Route::get('userindex', array('uses'=>'UserController@index'));//displaying messages
Route::get('userprofile', array('uses'=>'UserController@profile'));//displaying messages
Route::post('user/listStakeholderBranch/{id}', array('uses' => 'UserController@listStakeholderBranch')); //return a list of stakeholderbranch of same level
Route::get('user/profile', array('uses'=>'UserController@showProfile')); //show user profile
Route::get('user/profileEdit', array('uses'=>'UserController@updateProfile')); //update user profile
Route::post('user/profileEdit/{id}', array('uses'=>'UserController@editProfile')); //process updated user profile


/***************************************************************/
//************************Patient ***************************/
/***************************************************************/
Route::get('patient', array('uses' => 'PatientController@index')); //display a list of locations
Route::get('patientAdd', array('uses' => 'PatientController@create')); //display a form to create new location level level
Route::get('patient/general/{id}', array('uses' => 'PatientController@addGeneral')); //display a form to create new location level
Route::post('patientAdd', array('uses' => 'PatientController@store')); //process a form to create new location level
Route::get('patientEdit/{id}', array('uses' => 'PatientController@edit')); //display a form to update a level of location
Route::get('patient/follow_up/{id}', array('uses' => 'PatientController@show')); //display a form to update a level of location
Route::get('patient/histo/{id}', array('uses' => 'PatientController@addHisto')); //display a form to update a level of location
Route::post('patientEdit/{id}', array('uses' => 'PatientController@update')); //process a form to update a level of location
Route::post('patient/delete/{id}', array('uses' => 'PatientController@destroy')); //delete a level of location
Route::get('vital/add/{id}', array('uses' => 'PatientController@addVital')); //delete a level of location
Route::post('vital/add/{id}', array('uses' => 'PatientController@storeVital')); //delete a level of location
Route::get('patient/opd/{id}', array('uses' => 'PatientController@addVital')); //delete a level of location

Route::get('patient/clinical/{id}', array('uses' => 'TreatmentController@index')); //delete a level of location
Route::post('patient/opd/{id}', array('uses' => 'TreatmentController@store')); //delete a level of location
Route::get('sampleQueue', array('uses' => 'TreatmentController@sampleQueue')); //delete a level of location
Route::get('receive/{id}', array('uses' => 'TreatmentController@receive')); //delete a level of location
Route::get('lab', array('uses' => 'TreatmentController@labIndex')); //delete a level of location
Route::post('labInvestigation/{id}', array('uses' => 'TreatmentController@labDescription')); //delete a level of location
Route::get('diagnosis', array('uses' => 'TreatmentController@diagnosisQueue')); //delete a level of location
Route::get('diagnosis/{id}', array('uses' => 'TreatmentController@diagnosis')); //delete a level of location
Route::post('diagnosis/{id}', array('uses' => 'TreatmentController@diagnosisStore')); //delete a level of location

Route::get('districtAdd', function (){

    $region_id = Input::get('region_id');
    $district = District::where('region_id', '=', $region_id)->get();

    return Response::json($district);

});Route::get('districtEdit', function (){

    $region_id = Input::get('region_id');
    $district = District::where('region_id', '=', $region_id)->get();

    return Response::json($district);

});


/***************************************************************/
//************************Sample ***************************/
/***************************************************************/
Route::get('sample', array('uses'=>'SampleController@index')); //display list of references
Route::get('sample/add', array('uses'=>'SampleController@create')); //display form to add new reference
Route::post('sample/add', array('uses' => 'SampleController@store')); //process a form to create new location level
Route::get('sample/edit/{id}', array('uses' => 'SampleController@edit')); //display a form to update a level of location
Route::post('sample/edit/{id}', array('uses' => 'SampleController@update')); //process a form to update a level of location
Route::get('sample/delete/{id}', array('uses' => 'SampleController@notActive')); //delete a level of location
Route::post('sample/delete/{id}', array('uses' => 'SampleController@notActive')); //delete a level of location
Route::get('sample/report/{id}', array('uses' => 'SampleController@report')); //delete a level of location
Route::post('sample/report/{id}', array('uses' => 'SampleController@displayReport')); //delete a level of location
Route::get('sample/reject/{id}', array('uses' => 'SampleController@reject')); //delete a level of location
Route::post('sample/reject/{id}', array('uses' => 'SampleController@displayReject')); //delete a level of location
//Route::get('sampleReport/{id}', array('uses' => 'ReportController@download')); //delete a level of location


/***************************************************************/
//************************price ***************************/
/***************************************************************/
Route::get('price', array('uses' => 'PriceController@index')); //display a list of locations
Route::get('price/add', array('uses' => 'PriceController@create')); //display a form to create new location level
Route::post('price/add', array('uses' => 'PriceController@store')); //process a form to create new location level
Route::get('price/edit/{id}', array('uses' => 'PriceController@edit')); //display a form to update a level of location
Route::post('price/edit', array('uses' => 'PriceController@update')); //process a form to update a level of location
Route::post('price/delete/{id}', array('uses' => 'PriceController@destroy')); //delete a level of location


/***************************************************************/
//************************transaction ***************************/
/***************************************************************/
Route::get('transaction/{id}', array('uses' => 'TransactionController@index')); //display a list of locations
Route::get('transaction/add', array('uses' => 'TransactionController@create')); //display a form to create new location level
Route::post('transaction/add', array('uses' => 'TransactionController@store')); //process a form to create new location level
Route::get('transaction/edit/{id}', array('uses' => 'TransactionController@edit')); //display a form to update a level of location
Route::post('transaction/edit/{id}', array('uses' => 'TransactionController@update')); //process a form to update a level of location
Route::post('transaction/delete/{id}', array('uses' => 'TransactionController@destroy')); //delete a level of location


/***************************************************************/
//************************Payment ***************************/
/***************************************************************/
Route::get('payment', array('uses' => 'PaymentController@index')); //display a list of locations
Route::get('payment/hospital/{id}', array('uses' => 'PaymentController@showHospital')); //display a list of locations
Route::get('payment/view/{id}', array('uses' => 'PaymentController@showIndividual')); //display a list of locations
Route::get('payment/individual', array('uses' => 'PaymentController@show')); //display a list of locations
Route::get('payment/add/{id}', array('uses' => 'PaymentController@create')); //display a form to create new location level
Route::post('payment/add/{id}', array('uses' => 'PaymentController@store')); //process a form to create new location level
Route::get('payment/edit/{id}', array('uses' => 'PaymentController@edit')); //display a form to update a level of location
Route::post('payment/edit/{id}', array('uses' => 'PaymentController@update')); //process a form to update a level of location
Route::post('payment/delete/{id}', array('uses' => 'PaymentController@destroy')); //delete a level of location

/***************************************************************/
//************************Queue ***************************/
/***************************************************************/
Route::get('queue', array('uses'=>'SampleController@queue')); //display list of sample in queue
Route::get('kubali/{id}', array('uses' => 'SampleController@accept')); //display a list of locations
Route::post('reject/{$id}', array('uses' => 'SampleController@reject')); //display a list of locations

/***************************************************************/
//************************Energy ***************************/
/***************************************************************/
Route::get('energy', array('uses' => 'EnergyController@index')); //display a list of locations
Route::get('energyAdd', array('uses' => 'EnergyController@create')); //display a form to create new location level
Route::post('energyAdd', array('uses' => 'EnergyController@store')); //process a form to create new location level
Route::get('energy/edit/{id}', array('uses' => 'EnergyController@edit')); //display a form to update a level of location
Route::post('energyEdit', array('uses' => 'EnergyController@update')); //process a form to update a level of location
Route::post('energy/delete/{id}', array('uses' => 'EnergyController@destroy')); //delete a level of location


/***************************************************************/
//************************SampleTest  ***************************/
/***************************************************************/
Route::get('sampleTest', array('uses' => 'SampleTestsController@index')); //display a list of locations
Route::get('sampleTest/add', array('uses' => 'SampleTestsController@create')); //display a form to create new location level
Route::post('sampleTest/add', array('uses' => 'SampleTestsController@store')); //process a form to create new location level
Route::get('sampleTest/description/{id}', array('uses' => 'SampleTestsController@description')); //display a form to update a level of location
Route::post('sampleTest/description/{id}', array('uses' => 'SampleTestsController@store')); //display a form to update a level of location
Route::get('sampleTest/result/{id}', array('uses' => 'SampleTestsController@result')); //process a form to update a level of location
Route::post('sampleTest/result/{id}', array('uses' => 'SampleTestsController@displayResult')); //delete a level of location
Route::get('sampleTest/comment/{id}', array('uses' => 'SampleTestsController@comment')); //delete a level of location
Route::post('sampleTest/comment/{id}', array('uses' => 'SampleTestsController@displayComment')); //delete a level of location


/***************************************************************/
//************************Report  ***************************/
/***************************************************************/
//Route::get('report', array('uses' => 'ReportDController@index')); //display a list of locations
Route::get('report/add', array('uses' => 'ReportDController@create')); //display a form to create new location level
Route::post('report/add', array('uses' => 'ReportDController@store')); //process a form to create new location level
Route::post('report/listchild/{id}', array('uses' => 'ReportDController@listchild')); //return a list of location of same level
Route::get('report/edit/{id}', array('uses' => 'ReportDController@edit')); //display a form to update a level of location
Route::post('report/edit/{id}', array('uses' => 'ReportDController@update')); //process a form to update a level of location
Route::post('report/delete/{id}', array('uses' => 'ReportDController@destroy')); //delete a level of location
Route::get('report/child/{$id}', array('uses' => 'ReportDController@childindex')); //display a list of locations
Route::get('sampleReport/{id}', array('uses' => 'ReportController@download_pdf'));
Route::get('attachmentReport/{id}', array('uses' => 'ReportController@download'));

/***************************************************************/
//************************Category ***************************/
/***************************************************************/
Route::get('category', array('uses' => 'CategoryController@index')); //display a list of locations
Route::get('category/add', array('uses' => 'CategoryController@create')); //display a form to create new location level
Route::post('category/add', array('uses' => 'CategoryController@store')); //process a form to create new location level
Route::get('category/edit/{id}', array('uses' => 'CategoryController@edit')); //display a form to update a level of location
Route::post('category/edit/{id}', array('uses' => 'CategoryController@update')); //process a form to update a level of location
Route::post('category/delete/{id}', array('uses' => 'CategoryController@destroy')); //delete a level of location


/***************************************************************/
//************************Locations  ***************************/
/***************************************************************/
Route::get('location', array('uses' => 'LocationController@index')); //display a list of locations
Route::get('location/add', array('uses' => 'LocationController@create')); //display a form to create new location level
Route::post('location/add', array('uses' => 'LocationController@store')); //process a form to create new location level
Route::post('location/listchild/{id}', array('uses' => 'LocationController@listchild')); //return a list of location of same level
Route::get('location/edit/{id}', array('uses' => 'LocationController@edit')); //display a form to update a level of location
Route::post('location/edit/{id}', array('uses' => 'LocationController@update')); //process a form to update a level of location
Route::post('location/delete/{id}', array('uses' => 'LocationController@destroy')); //delete a level of location
Route::get('location/child/{$id}', array('uses' => 'LocationController@childindex')); //display a list of locations


/***************************************************************/
//***************** Locations Levels ***************************/
/***************************************************************/
Route::get('location/levels', array('uses' => 'LocationLevelController@index')); //display a list of locations
Route::get('location/levels/add', array('uses' => 'LocationLevelController@create')); //display a form to create new location level
Route::post('location/levels/add', array('uses' => 'LocationLevelController@store')); //process a form to create new location level
Route::get('location/levels/edit/{id}', array('uses' => 'LocationLevelController@edit')); //display a form to update a level of location
Route::post('location/levels/edit/{id}', array('uses' => 'LocationLevelController@update')); //process a form to update a level of location
Route::post('location/levels/delete/{id}', array('uses' => 'LocationLevelController@destroy')); //delete a level of location


//*******************************************************//
//********************CHATS***************************//
//*******************************************************//
Route::get('report',array('uses'=>'ReportDController@index'));

Route::get('accident_reports',array('uses'=>'ReportDController@index'));

Route::post('report/download',array('uses'=>'ReportDController@excelDownload'));

//displaying table chart
Route::post('report/general/table',array('uses'=>'ReportDController@makeTable'));

//displaying bar chart
Route::post('report/general/bar',array('uses'=>'ReportDController@makeBar'));

//displaying column chart
Route::post('report/general/column',array('uses'=>'ReportDController@makeColumn'));

//displaying combined chart
Route::post('report/general/combined',array('uses'=>'ReportDController@makeCombined'));

//displaying combined chart
Route::post('report/general/pie',array('uses'=>'ReportDController@makePie'));

//displaying line chart
Route::post('report/general/line',array('uses'=>'ReportDController@makeLine'));




