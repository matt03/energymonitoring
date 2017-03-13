<?php
session_start();
/**
 PHP API for Login, Register, Changepassword, Resetpassword Requests and for Email Notifications.
 **/
if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // Get tag
    $tag = $_POST['tag'];
    // Include Database handler
    require_once 'include/DB_Functions.php';
    $db = new DB_Functions();
    // response Array
    $response = array("tag" => $tag, "success" => 0, "error" => 0);
    $res=array(array()); 


 // check for tag type
    if ($tag == 'login') {
        // Request type is check Login
        $username = $_POST['username'];
        $password = $_POST['password'];
    //the email will be used in querying
     //   session_regenerate_id();
	   // $_SESSION['email'] = $_POST['email'];
	    //session_write_close();			
        // check for user
		
        $user = $db->getUser($username, $password);
        if ($user != false) {
            // user found
            // echo json with success = 1
            $response["success"] = 1;
            $response["user"]["rankNo"] = $user["rankNo"];
       
            $response["user"]["fullName"] = $user["fullName"];
            $response["user"]["station"] = $user["station"];
          
            $response["user"]["created_at"] = $user["created_at"];
            echo json_encode($response);
        } else {
            // user not found
            // echo json with error = 1
            $response["error"] = 1;
            $response["error_msg"] = "Incorrect username or password!";
            echo json_encode($response);
        }
    }else if ($tag == 'verification') {
        // Request type is car and license verification
        $license = $_POST['license'];
        $plateNumber = $_POST['plateNumber'];
    //the email will be used in querying
     //   session_regenerate_id();
	   // $_SESSION['email'] = $_POST['email'];
	    //session_write_close();			
        // check for user
        $car = $db->getCar($plateNumber);
        $person =$db->getLicence($license);
        if ($car != false) {
            // user found
            // echo json with success = 1
            
            $response["detail"]["type"] = $car["type"];
            $response["detail"]["make"] = $car["make"];
            $response["detail"]["color"] = $car["color"];
            $response["detail"]["registered_on"] = $car["created_at"];
          //  echo json_encode($response);
        }else{
            // user not found
            // echo json with error = 1
            $response["error"] = 1;
            $response["error_msg"] = "Incorrect plateNumber!";
            echo json_encode($response);
        } 
		
		 if ($person != false && $response["error"] != 1) {
            // person found
            // echo json with success = 1
            $response["success"] = 1;	
            $response["detail"]["name"] = $person["name"];
            $response["detail"]["address"] = $person["address"];
            $response["detail"]["class"] = $person["class"];
            $response["detail"]["expiryDate"] = $person["expiryDate"];
            $response["detail"]["status"] = $person["status"];
            $response["detail"]["created_at"] = $person["created_at"];
            echo json_encode($response);
        }else {
            // user not found
            // echo json with error = 2
            $response["error"] = 2;
            $response["error_msg"] = "Incorrect licence!";
            echo json_encode($response);
        }
		
		 if($person == false && $car == false){
             $response["error"] = 3;		     
			
		 }
    }
  else if ($tag == 'chgpass'){
  $oldpassword = $_POST['oldpas'];
  $newpassword = $_POST['newpas'];
  $hash = md5($newpassword);
  $old = md5($oldpassword);
  $userToChange =$db->getUserToChangePassword($old); 

         $subject = "Change Password Notification";
         $message = "Hello User,nnYour Password is sucessfully changed.nnRegards,nAdmin.";
          $from = "pnyairema@gmail.com";
          $headers = "From:" . $from;
 if($userToChange)  {
 $rankNo=$userToChange['rankNo'];
 $user =$db->forgotPassword($rankNo,$hash);
if ($user) {
        
         $email=$userToChange['email']; 
         $response["success"] = 1;
         mail($email,$subject,$message,$headers);
         echo json_encode($response);
}
else {
$response["error"] = 1;
echo json_encode($response);
}
            // user is already existed - error response
        }
           else {
            $response["error"] = 1;
            $response["error_msg"] = "User not exist";
             echo json_encode($response);
}
}
else if ($tag == 'forpass'){
$forgotpassword = $_POST['forgotpassword'];
$subject = "Password Recovery";
         $message = "Hello User,nnYour Password resetting requesting has been sent.  . wait for an email from the System administrator or contact me via 0712763363.nnRegards,nAdmin.";
          $from = "pnyairema@gmail.com";
          $headers = "From:" . $from;
  if ($db->isUserExisted($forgotpassword)) {
 
         $response["success"] = 1;
          mail($forgotpassword,$subject,$message,$headers);
         echo json_encode($response);


            // user is already existed - error response
        }
           else {
            $response["error"] = 2;
            $response["error_msg"] = "User does not exist";
             echo json_encode($response);
}
}
else if ($tag == 'history') {
        // Request type is Register new user
        $license = $_POST['license'];
        $history = array();
		$count = $db->getNumberOfOffence($license);
            // get reported offence of a particular driver
            $history = $db->getHistory($license);
            if ($history) {
                // offence stored successfully
				
			for ($i=0; $i<$count; $i++){
            $response["success"] = 1;
			$response["count"]=$count;
            $response["history".$i]["offence"] = $history[$i]["offence"];
            $response["history".$i]["date"] = $history[$i]["created_at"];
			
			}
			
      
                echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "JSON Error occurred in getting history";
                echo json_encode($response);
            }
        
    }else if ($tag == 'register') {
        // Request type is Register new user
        $license = $_POST['license'];
        $plateNumber = $_POST['plateNumber'];
        $offence = $_POST['offence'];
        $commit = $_POST['commit'];
        $rankNo = $_POST['RankNo'];
        $amount = $_POST['amount'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];



            // store offence
            $offenceDetails = $db->storeOffence($license , $plateNumber, $offence,$commit, $rankNo,$amount,$latitude, $longitude );
            if ($offenceDetails) {
                // offence stored successfully
            $response["success"] = 1;
            $response["offenceDetails"]["license"] = $offenceDetails["license"];
            $response["offenceDetails"]["amount"] = $offenceDetails["amount"];
            $response["offenceDetails"]["plateNumber"] = $offenceDetails["plateNumber"];
            $response["offenceDetails"]["offence"] = $offenceDetails["offence"];
            $response["offenceDetails"]["commit"] = $offenceDetails["commit"];
            $response["offenceDetails"]["rankNo"] = $offenceDetails["rankNo"];
		    $response["offenceDetails"]["created_at"] = $offenceDetails["created_at"];
            $response["offenceDetails"]["latitude"] = $offenceDetails["latitude"];
            $response["offenceDetails"]["longitude"] = $offenceDetails["longitude"];
           //    mail($email,$subject,$message,$headers);
                echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "JSON Error occurred in sending data";
                echo json_encode($response);
            }
        
}
else if ($tag == 'person') {

        $acc_data_id=1;
        $name= $_POST['person_name'];
		$gender = $_POST['person_gender'];
		$DOB= $_POST['dob'];
		$physical_address= $_POST['physical_address'];
		$address= $_POST['address_box'];
		$national_id_nationality= $_POST['nationality_id'];
		$phone_number= $_POST['phone_no'];
		$drugs_alcohol_percent= $_POST['alcohol'];
		$helmet_seat_belt_use= $_POST['seat_helmet'];
		$casualty= $_POST['casuality'];
		$status= $_POST['status'];
		$vehicle_number= $_POST['vehicle_no'];
		$accident_data_id= $_POST['reg_id'];

            // store offence
    if ($name==""&&$DOB==""&&$physical_address==""&&$address==""&&$national_id_nationality==""&&$phone_number==""&&$drugs_alcohol_percent=="") {
        $person="";
    }else{
        $person = $db->store_person($name,$gender,$DOB,$physical_address,$address,$national_id_nationality,$phone_number,$drugs_alcohol_percent,$helmet_seat_belt_use,$casualty,$status,$vehicle_number,$accident_data_id );

    }


			
            if ($person) {
                // offence stored successfully
            $response["success"] = 1;
            $response["Person"]["name"] = $person["name"];
            $response["Person"]["gender"] = $person["gender"];
            $response["Person"]["gender"] = $person["gender"];
            $response["Person"]["physical_address"] = $person["physical_address"];
            $response["Person"]["address"] = $person["address"];
            $response["Person"]["national_id_nationality"] = $person["national_id_nationality"];
		    $response["Person"]["phone_number"] = $person["phone_number"];
            $response["Person"]["drugs_alcohol_percent"] = $person["drugs_alcohol_percent"];
            $response["Person"]["helmet_seat_belt_use"] = $person["helmet_seat_belt_use"];
            $response["Person"]["accident_data"] = $person["accident_data_id"];
               echo json_encode($response);
            } else {
                // user failed to store
                $response["error"] = 1;
                $response["error_msg"] = "JSON Error occurred in sending data";
                echo json_encode($response);
            }
        
    }


else if ($tag == 'driver') {
    // Request type is Register new user

    $surname = $_POST['surname'];
    $other_names = $_POST['other_names'];
    $physical_address = $_POST['physical_address'];
    $address_box = $_POST['address_box'];
    $national_id = $_POST['national_id'];
    $phone_no = $_POST['phone_no'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $nationality= $_POST['nationality'];
    $driving_licence = $_POST['driving_licence'];
    $occupation = $_POST['occupation'];
    $alcohol = $_POST['alcohol'];
    $drugs = $_POST['drugs'];
    $phone_use = $_POST['phone_use'];
    $seat_helmet = $_POST['seat_helmet'];

    if( $surname == "" && $other_names=="" && $physical_address=="" && $address_box=="" && $national_id=="" && $phone_no=="" && $gender=="" &&$dob=="" && $nationality=="" && $driving_licence=="" && $occupation=="" && $alcohol =="" && $drugs =="" && $phone_use == "" && $seat_helmet =="" )
    {

    }
    else{
        // store driver
        $driver = $db->storeDriver($surname, $other_names, $physical_address, $address_box, $national_id,$phone_no,$gender,$dob,$nationality,$driving_licence,$occupation,$drugs,$alcohol,$phone_use,$seat_helmet);
        if ($driver) {
            // user stored successfully
            $response["success"] = 1;
            $response["driver"]["surname"] = $driver["surname"];
            $response["driver"]["other_name"] = $driver["other_name"];
            $response["driver"]["physical_address"] = $driver["physical_address"];
            $response["driver"]["address_box"] = $driver["address"];
            $response["driver"]["national_id"] = $driver["national_id"];
            $response["driver"]["phone_no"] = $driver["phone_number"];
            $response["driver"]["gender"] = $driver["gender"];
            $response["driver"]["dob"] = $driver["DOB"];
            $response["driver"]["nationality"] = $driver["nationality"];
            $response["driver"]["driving_licence"] = $driver["driving_license"];
            $response["driver"]["occupation"] = $driver["occupation"];
            $response["driver"]["drugs"] = $driver["drugs"];
            $response["driver"]["alcohol"] = $driver["alcohol_percent"];
            $response["driver"]["phone_use"] = $driver["phone_use"];
        //    $response["driver"]["seat_helmet"] = $driver["seat_helmet"];

            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = 1;
            $response["error_msg"] = "JSON Error occurred in sending data";
            echo json_encode($response);
        }
    }





}else if ($tag == 'defects') {
    // Request type is Register new user
    $number = $_POST['number'];
    $defect = $_POST['defect'];
    $acc_data_id = $_POST['accident_reg'];


    //Store Location
    $defect = $db->store_vehicle_defects($number,$defect,$acc_data_id);
    if ($defect) {
        //location Stored Successfully
        $response["success"] = 1;
        $response["defect"]["vehicle_number"] = $defect["vehicle_number"];
        $response["defect"]["roadName"] = $defect["defect"];
        $response["defect"]["road_no"] = $defect["accident_data_id"];

        echo json_encode($response);


    }
    else {
        // locnatio failed to store
        $response["error"] = 1;
        $response["error_msg"] = "JSON Error occured.";
        echo json_encode($response);
    }

}else if ($tag == 'violation') {
    // Request type is Register new user
    $number = $_POST['number'];
    $violation = $_POST['violation'];
    $acc_data_id = $_POST['reg'];

    //Store Location
    $violation = $db->store_violation($number,$violation,$acc_data_id);
    if ($violation) {
        //location Stored Successfully
        $response["success"] = 1;
        $response["violation"]["number "] = $violation["vehicle_number"];
        $response["violation"]["violation"] = $violation["violation"];
        $response["violation"]["reg"] = $violation["accident_data_id"];

        echo json_encode($response);


    }
    else {
        // violation failed to store
        $response["error"] = 1;
        $response["error_msg"] = "JSON Error occured.";
        echo json_encode($response);
    }

}else if ($tag == 'junction_type') {
    // Request type is Register new user
    $junction_structure = $_POST['junction_structure'];
    $junction_control = $_POST['junction_control'];


    //Store Location
    $junction = $db->store_junction_type($junction_structure,$junction_control);
    if ($junction) {
        //location Stored Successfully
        $response["success"] = 1;
        $response["junction"]["junction_structure"] = $junction["junction_structure"];
        $response["junction"]["junction_control"] = $junction["junction_control"];

        echo json_encode($response);


    }
    else {
        // locnatio failed to store
        $response["error"] = 1;
        $response["error_msg"] = "JSON Error occured.";
        echo json_encode($response);
    }

}else if ($tag == 'street_condition') {
    // Request type is Register new user
    $road_surface = $_POST['road_surface'];
    $light = $_POST['light'];
    $weather = $_POST['weather'];
    $road_control = $_POST['road_control'];


    //Store Location
    $street = $db->store_street_condition($road_surface,$light,$weather,$road_control);
    if ($street) {
        //location Stored Successfully
        $response["success"] = 1;
        $response["street"]["road_surface"] = $street["road_surface"];
        $response["street"]["light"] = $street["light"];
        $response["street"]["weather"] = $street["weather"];
        $response["street"]["road_control"] = $street["control"];

        echo json_encode($response);

    }
    else {
        // locnatio failed to store
        $response["error"] = 1;
        $response["error_msg"] = "JSON Error occured.";
        echo json_encode($response);
    }

}else if ($tag == 'road_type') {
    // Request type is Register new user
    $surface_type = $_POST['surface_type'];
    $road_structure = $_POST['road_structure'];
    $infrastructure = $_POST['infrastructure'];
    $road_status = $_POST['road_status'];


    //Store Location
    $road_type = $db->store_road_type($surface_type,$road_structure,$infrastructure,$road_status);
    if ($road_type) {
        //location Stored Successfully
        $response["success"] = 1;
        $response["road_type"]["road_class"] = $road_type["road_class"];
        $response["road_type"]["surface_type"] = $road_type["surface_type"];
        $response["road_type"]["road_structure"] = $road_type["road_structure"];
        $response["road_type"]["road_status"] = $road_type["road_status"];

        echo json_encode($response);


    }
    else {
        // road type failed to store
        $response["error"] = 1;
        $response["error_msg"] = "JSON Error occured.";
        echo json_encode($response);
    }

}


else if ($tag == 'location') {
    // Request type is Register new user
    $area = $_POST['accident_area'];
    $roadName = $_POST['road_name'];
    $road_no = $_POST['road_no'];
    $road_mark = $_POST['road_kilo_mark'];
    $intersectionName = $_POST['intersection_name'];
    $intersection_no = $_POST['intersection_no'];
    $intersection_mark = $_POST['intersection_kilo_mark'];

    //Store Location
    $location = $db->storeLocation($area,$roadName,$road_no,$road_mark,$intersectionName,$intersection_no,$intersection_mark);
    if ($location) {
        echo "location";
        //location Stored Successfully
        $response["success"] = 1;
        $response["location"]["area"] = $location["area"];
        $response["location"]["roadName"] = $location["roadName"];
        $response["location"]["road_no"] = $location["road_no"];
        $response["location"]["road_mark"] = $location["road_mark"];
        $response["location"]["intersectionName"] = $location["intersectionName"];
        $response["location"]["intersection_no"] = $location["intersection_no"];
        $response["location"]["intersection_mark"] = $location["intersection_mark"];
        echo json_encode($response);


    }
    else {
        // location failed to store
        $response["error"] = 1;
        $response["error_msg"] = "JSON Error occured.";
        echo json_encode($response);
    }

}

else if ($tag == 'vehicle') {
    // Request type is Register new vehicle
    $type = $_POST['vehicle_type'];
    $reg_no = $_POST['vehicle_reg_no'];

    if( $type == ""  && $reg_no == "" ){}
    else{
        // store vehicle

        $vehicle = $db->storeVehicle($type, $reg_no);

        if ($vehicle) {
            // user stored successfully
            $response["success"] = 1;
            $response["vehicle"]["vehicle_type"] = $vehicle["type"];
            $response["vehicle"]["vehicle_reg"] = $vehicle["registration_number"];
            echo json_encode($response);

        } else {
            // user failed to store
            $response["error"] = 1;
            $response["error_msg"] = "JSON Error occured.";
            echo json_encode($response);
        }
    }

}

else if ($tag == 'insurance') {
    // Request type is Register new vehicle
    $name = $_POST['company_name'];
    $type = $_POST['insurance_type'];
    $phone_no = $_POST['insurance_phone_no'];
    $policy_no = $_POST['policy_no'];
    $period = $_POST['expiration_period'];
    $costs = $_POST['estimated_repair_costs'];

    if($name == "" && $type  =="" && $phone_no=="" &&$policy_no==""  &&$period=="" &&$costs=="" ){}
    else{
        // store insurance

        $insurance = $db->storeInsurance($name, $type,$phone_no,$policy_no,$period,$costs );
        if ($insurance) {
            // user stored successfully
            $response["success"] = 1;
            $response["insurance"]["name"] = $insurance["name"];
            $response["insurance"]["type"] = $insurance["type"];
            $response["insurance"]["phone_no"] = $insurance["phone_number"];
            $response["insurance"]["policy_no"] = $insurance["policy_number"];
            $response["insurance"]["period"] = $insurance["expiration_date"];
            $response["insurance"]["costs"] = $insurance["estimated_repair_amount"];
            echo json_encode($response);

        } else {
            // user failed to store
            $response["error"] = 1;
            $response["error_msg"] = "JSON Error occured.";
            echo json_encode($response);
        }
    }


}



else if ($tag == 'damage') {
    // Request type is Register new vehicle
    $vehicle = $_POST['vehicle'];
    $total = $_POST['vehicle_total'];
    $infrastructure = $_POST['infrastructure'];
    $costs = $_POST['rescue_costs'];

    if( $vehicle =="" && $total=="" && $infrastructure=="" && $costs==""){}

    else{
        // store damage
        $damage = $db->storeDamage($vehicle, $total,$infrastructure,$costs);
        if ($insurance) {
            // user stored successfully
            $response["success"] = 1;
            $response["insurance"]["name"] = $insurance["name"];
            $response["insurance"]["type"] = $insurance["type"];
            $response["insurance"]["phone_no"] = $insurance["phone_no"];
            $response["insurance"]["policy_no"] = $insurance["policy_number"];
            $response["insurance"]["period"] = $insurance["period"];
            $response["insurance"]["costs"] = $insurance["costs"];
            echo json_encode($response);

        } else {
            // user failed to store
            $response["error"] = 1;
            $response["error_msg"] = "JSON Error occured.";
            echo json_encode($response);
        }
    }


}
else if ($tag == 'category') {
    // Request type is Register new user
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $uname = $_POST['uname'];
    $password = $_POST['password'];
    $plate = $_POST['plate'];
    $model = $_POST['model'];
    $color = $_POST['color'];
    $year= $_POST['year'];
    $phone = $_POST['phone'];
    $subject = "Registration";
    $message = "Hello $fname,nnYou have sucessfully registered to our service.nnRegards,nAdmin.";
    $from = "pnyairema@gmail.com";
    $headers = "From:" . $from;
    // check if user is already existed
    if ($db->isUserExisted($email)) {
        // user is already existed - error response
        $response["error"] = 2;
        $response["error_msg"] = "User already existed";
        echo json_encode($response);
    }
    else if(!$db->validEmail($email)){
        $response["error"] = 3;
        $response["error_msg"] = "Invalid Email Id";
        echo json_encode($response);
    }
    else {
        // store user
        $user = $db->storeUser($fname, $lname, $email, $uname, $password,$plate,$model,$color,$year,$phone);
        if ($user) {
            // user stored successfully
            $response["success"] = 1;
            $response["user"]["fname"] = $user["firstname"];
            $response["user"]["lname"] = $user["lastname"];
            $response["user"]["email"] = $user["email"];
            $response["user"]["uname"] = $user["username"];
            $response["user"]["plate"] = $user["plate"];
            $response["user"]["model"] = $user["model"];
            $response["user"]["color"] = $user["color"];
            $response["user"]["year"] = $user["year"];
            $response["user"]["phone"] = $user["phone"];
            $response["user"]["uid"] = $user["unique_id"];
            $response["user"]["created_at"] = $user["created_at"];
            mail($email,$subject,$message,$headers);
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = 1;
            $response["error_msg"] = "JSON Error occured in Registartion";
            echo json_encode($response);
        }
    }
}

else if ($tag == 'accident_data') {
    // Request type is Register new user
    $reg = $_POST['accident_reg_no'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $uname = $_POST['uname'];
    $password = $_POST['password'];
    $plate = $_POST['plate'];
    $model = $_POST['model'];
    $color = $_POST['color'];
    $year= $_POST['year'];
    $phone = $_POST['phone'];
    $subject = "Registration";
    $message = "Hello $fname,nnYou have sucessfully registered to our service.nnRegards,nAdmin.";
    $from = "pnyairema@gmail.com";
    $headers = "From:" . $from;

        // store user
        $user = $db->storeUser($fname, $lname, $email, $uname, $password,$plate,$model,$color,$year,$phone);
        if ($user) {
            // user stored successfully
            $response["success"] = 1;
            $response["user"]["fname"] = $user["firstname"];
            $response["user"]["lname"] = $user["lastname"];
            $response["user"]["email"] = $user["email"];
            $response["user"]["uname"] = $user["username"];
            $response["user"]["plate"] = $user["plate"];
            $response["user"]["model"] = $user["model"];
            $response["user"]["color"] = $user["color"];
            $response["user"]["year"] = $user["year"];
            $response["user"]["phone"] = $user["phone"];
            $response["user"]["uid"] = $user["unique_id"];
            $response["user"]["created_at"] = $user["created_at"];
            mail($email,$subject,$message,$headers);
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = 1;
            $response["error_msg"] = "JSON Error occured in Registartion";
            echo json_encode($response);
        }
}
}else {
    echo "submitting offence API";
}
