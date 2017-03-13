<?php
class DB_Functions {
    private $db;
    //put your code here
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }
    // destructor
    function __destruct() {
    }
    /**
     * Random string which is sent by mail to reset password
     */
public function random_string()
{
    $character_set_array = array();
    $character_set_array[] = array('count' => 7, 'characters' => 'abcdefghijklmnopqrstuvwxyz');
    $character_set_array[] = array('count' => 1, 'characters' => '0123456789');
    $temp_array = array();
    foreach ($character_set_array as $character_set) {
        for ($i = 0; $i < $character_set['count']; $i++) {
            $temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
        }
    }
    shuffle($temp_array);
    return implode('', $temp_array);
}

public function forgotPassword($rankNo, $newpassword){
  $result = mysql_query("UPDATE `psms_users` SET `password` = '$newpassword'
              WHERE `rankNo` = '$rankNo'");
			  
 $result2 = mysql_query("select * from psms_users where rankNo = '".$rankNo."'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result2);
  if ($no_of_rows > 0) {
      return true;
      } else
     {
	 return false;
      }
}
   /*
     * Adding new user to mysql database
     * returns user details
     */
    public function storeOffence($license, $plateNumber, $offence, $commit, $rankNo, $amount, $latitude, $longitude) {
       
        $result = mysql_query("INSERT INTO psms_data( license, plateNumber, offence, commit,amount, created_at, rankNo, latitude, longitude) VALUES('$license', '$plateNumber', '$offence', '$commit', '$amount', NOW(),'$rankNo','$latitude','$longitude')");
        // check for successful store
        if ($result) {
            // get user details
            $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM psms_data WHERE id = $uid");
            // return user details
           
			$res=mysql_fetch_array($result);
			return $res;
        } else {
            return false;
        }
    }

     /*
     * Adding new accident data to mysql database
     * returns accident_data id
     */
    public function store_accident_data($registration_number, $driver_id_1, $driver_id_2, $car_id_1,$car_id_2,$road_type_id,$damage_id,$street_condition_id,$junction_type_id,$vehicle_defect_id,$violation_id, $category_id, $other_damage_id) {

        $result = mysql_query("INSERT INTO psms_accident_data(registration_number,driver_id_1,driver_id_2,car_id_1,car_id_2,road_type_id,damage_id,street_condition_id,junction_type_id,vehicle_defect_id,violation_id, category_id, other_damage_id)
                                              VALUES('$registration_number', '$driver_id_1', '$driver_id_2','$car_id_1','$car_id_2','$road_type_id','$damage_id','$street_condition_id', '$junction_type_id', '$vehicle_defect_id','$violation_id','$category_id','$other_damage_id',NOW())");
        // check for successful store
        if ($result) {
            // get user details
            $uid = mysql_insert_id(); // last inserted id

	       //$res=mysql_fetch_array($result);
			return $uid; //retuirns the id of the reported accident
        } else {
            return false;
        }
    }

     /*
     * Adding new accident_description to mysql database
     * returns accident_description id
     */
    public function store_accident_description($accident_site_condition, $direction, $image_path) {

        $result = mysql_query("INSERT INTO psms_accident_description( accident_site_condition, direction, image_path,created_at ) VALUES('$accident_site_condition', '$direction', '$image_path',  NOW())");
        // check for successful store
        if ($result) {
            // get user details
            $uid = mysql_insert_id(); // last inserted id
            // $result = mysql_query("SELECT * FROM psms_data WHERE id = $uid");
            // return user details
            // $res=mysql_fetch_array($result);
			return $uid;
        } else {
            return false;
        }
    }

     /*
     * Adding new category to mysql database
     * returns category id
     */
    public function store_category($category_name,$category_number,$description) {

        $result = mysql_query("INSERT INTO psms_category(category_name,category_number ,description ,created_at ) VALUES('$category_name','$category_number','$description', NOW())");
        // check for successful store

        if ($result) {
            // get user details
            $uid = mysql_insert_id(); // last inserted id
            // $result = mysql_query("SELECT * FROM psms_data WHERE id = $uid");
            // return user details
            // $res=mysql_fetch_array($result);
            return $uid;
        } else {
            return false;
        }
    }



     /*
     * Adding new junction_type to mysql database
     * returns junction_type id
     */
    public function store_junction_type($junction_structure,$junction_control ) {

        $result = mysql_query("INSERT INTO psms_junction_type( junction_structure ,junction_control,created_at) VALUES('$junction_structure','$junction_control', NOW())");
        // check for successful store
        // check for successful store
        if ($result) {
            // get user details
            $uid = mysql_insert_id(); // last inserted id
             $result = mysql_query("SELECT * FROM psms_junction_type WHERE id = $uid");
            // return user details
             $res=mysql_fetch_array($result);
            return $res;
        } else {
            return false;
        }
    }

    /*
     * Adding new other_damage to mysql database
     * returns other_damage id
     */
    public function store_other_damage($description,$name_of_property_owner,$cost_of_repair ) {

        $result = mysql_query("INSERT INTO psms_other_damage(description ,name_of_property_owner,cost_of_repair,created_at) VALUES('$description','$name_of_property_owner','$cost_of_repair', NOW())");
        // check for successful store
        // check for successful store
        if ($result) {
            // get user details
            $uid = mysql_insert_id(); // last inserted id
            // $result = mysql_query("SELECT * FROM psms_data WHERE id = $uid");
            // return user details
            // $res=mysql_fetch_array($result);
            return $uid;
        } else {
            return false;
        }
    }
    /*
     * Adding new person to mysql database
     * returns person id
     */
    public function store_person($name1,$gender,$DOB,$physical_address,$address,$national_id_nationality,$phone_number,$drugs_alcohol_percent,$helmet_seat_belt_use,$casualty,$status,$vehicle_number,$accident_data_id ) {

  $result = mysql_query("INSERT INTO psms_person(gender,DOB,physical_address,name,address,national_id_nationality,phone_number,drugs_alcohol_percent,helmet_seat_belt_use,casualty,status,vehicle_number,accident_data_id,created_at) VALUES
        ('$gender','$DOB','$physical_address','$name1','$address','$national_id_nationality','$phone_number','$drugs_alcohol_percent','$helmet_seat_belt_use','$casualty','$status','$vehicle_number','$accident_data_id',NOW())");

        // check for successful store
        if ($result) {
            // get user details

            $uid = mysql_insert_id(); // last inserted id
             $result = mysql_query("SELECT * FROM psms_person WHERE id = $uid");
            // return user details
            return mysql_fetch_array($result);

        } else {
            return false;
        }
    } /*
     * Adding new road _type to mysql database
     * returns road _type id
     */
    public function store_road_type($road_class ,$surface_type,$road_structure,$road_status ) {



        $result = mysql_query("INSERT INTO psms_road_type(road_class,surface_type,road_structure,road_status,created_at) VALUES('$road_class','$surface_type','$road_structure','$road_status',NOW())");
        // check for successful store
        // check for successful store
        if ($result) {
            // get user details
            $uid = mysql_insert_id(); // last inserted id
             $result = mysql_query("SELECT * FROM psms_road_type WHERE id = $uid");
            // return user details
             $res=mysql_fetch_array($result);
            return $res;
        } else {
            return false;
        }
    }
     /*
     * Adding new person to mysql database
     * returns person id
     */
    public function store_street_condition($road_surface,$light,$weather,$control ) {

        $result = mysql_query("INSERT INTO psms_street_condition(road_surface,light,weather,control,created_at) VALUES('$road_surface','$light','$weather','$control', NOW())");
        // check for successful store
        // check for successful store
        if ($result) {
            // get user details
            $uid = mysql_insert_id(); // last inserted id
             $result = mysql_query("SELECT * FROM psms_street_condition WHERE id = $uid");
            // return user details
             $res=mysql_fetch_array($result);
            return $res;
        } else {
            return false;
        }
    } /*
     * Adding new vehicle_defects to mysql database
     * returns vehicle_defects id
     */
    public function store_vehicle_defects($number,$defect,$accident_data_id ) {

        $result = mysql_query("INSERT INTO psms_vehicle_defects(vehicle_number,defect,accident_data_id,created_at) VALUES('$number','$defect','$accident_data_id', NOW())");
        // check for successful store
        // check for successful store
        if ($result) {
            // get user details
            $uid = mysql_insert_id(); // last inserted id
             $result = mysql_query("SELECT * FROM psms_vehicle_defects WHERE id = $uid");
            // return user details
             $res=mysql_fetch_array($result);
            return $res;
        } else {
            return false;
        }
    } /*
     * Adding new violation to mysql database
     * returns violation id
     */
    public function store_violation($number,$violation,$accident_data_id ) {

        $result = mysql_query("INSERT INTO psms_violation(vehicle_number,violation,accident_data_id,created_at) VALUES('$number','$violation','$accident_data_id', NOW())");
        // check for successful store
        // check for successful store
        if ($result) {
            // get user details
            $uid = mysql_insert_id(); // last inserted id
             $result = mysql_query("SELECT * FROM psms_violation WHERE id = $uid");
            // return user details
            $res=mysql_fetch_array($result);
            return $res;
        } else {
            return false;
        }
    }

    public function storeVehicle($vehicle_type, $vehicle_reg)
    {

        $result = mysql_query("INSERT INTO psms_car(type,registration_number)
                  VALUES('$vehicle_type','$vehicle_reg') ");

        // check for successful store
        if ($result) {

            $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM psms_car WHERE id = $uid");
            // return user details
            $res=mysql_fetch_array($result);
            return $res;

        } else {
            return false;
        }

    }


    public function storeLocation($area, $road_no, $road_mark,$intersectionName, $intersection_no, $intersection_mark)
    {

        $result = mysql_query("INSERT INTO psms_accident_location(area)
                  VALUES('$area') ");

        // check for successful store
        if ($result) {
            $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM psms_accident_location WHERE id = $uid");
            // return user details
            return mysql_fetch_array($result);
        } else {
            return false;
        }

    }


    public function storeDriver($surname, $other_names, $physical_address, $address_box, $national_id,$phone_no,$gender,$dob,$nationality,$licence,$occupation,$drugs,$alcohol,$phone_use,$seat_helmet)
    {

        $result = mysql_query( "INSERT INTO psms_driver(surname)
         VALUES('$surname')");

        // check for successful driver
        if ($result) {


            $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM psms_driver WHERE id = $uid");
            // return user details
            return mysql_fetch_array($result);
        } else {
            return false;
        }

    }

    public function storeInsurance($name, $type, $phone_no, $policy_no, $expiration,$repair_costs)
    {


        $result = mysql_query("INSERT INTO psms_insurance(name,type,phone_number,policy_number,expiration_date,estimated_repair_amount)
                  VALUES('$name' ,'$type' ,'$phone_no' ,'$policy_no' , '$expiration' , '$repair_costs') ");
        // check for successful store
        if ($result) {

            $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM psms_insurance WHERE id = $uid");
            // return user details
            return mysql_fetch_array($result);
        } else {
            return false;
        }

    }


    public function storeDamage($vehicle, $vehicle_total, $infrastructure,$rescue_costs)
    {
        $result = mysql_query("INSERT INTO psms_damage(vehicle,vehicle_total,infrastructure,rescue_cost)
                  VALUES('$vehicle', '$vehicle_total' ,'$infrastructure','$rescue_costs') ");
        // check for successful store
        if ($result) {
            $uid = mysql_insert_id(); // last inserted id
            $result = mysql_query("SELECT * FROM psms_damage WHERE id = $uid");
            // return user details
            return mysql_fetch_array($result);
        } else {
            return false;
        }

    }
    /**
     * Verifies user by rankNo and password
     */
    public function getUser($user, $password) {

	
        $result = mysql_query("select * from psms_users where rankNo = '".$user."'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
		  
            $result = mysql_fetch_array($result);
			 $encrypted_password = $result['password'];
			
            // check for password equality
            if ($encrypted_password == md5($password)) {
                // user authentication details are correct
                return $result;
            }
       
        } else {
            // user not found
            return false;
        }
    }
	
	  /**
     * Verifies user by rankNo and password
     */
    public function getUserToChangePassword($password) {

	
        $result = mysql_query("select * from psms_users where password = '".$password."'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
		  
            $result = mysql_fetch_array($result);
			  return $result;
         
        } else {
            // user not found
            return false;
        }
    }
	/**
     * Verifies car by plateNo 
     */
    public function getCar($plateNumber) {
        $result = mysql_query("select * from psms_car where plateNo = '".$plateNumber."'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
		  
            $result = mysql_fetch_array($result);
       
                return $result;
          //  }
        } else {
            // user not found
            return false;
        }
    }
	/**
     * Verifies driver by licence
     */
    public function getLicence($licence) {
        $result = mysql_query("select * from psms_licence where licenceNo = '".$licence."'") or die(mysql_error());
        // check for result
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
		  
            $result = mysql_fetch_array($result);
        

		
                return $result;
         
        } else {
            // person not found
            return false;
        }
    }
	
	/**
     * getting history of offence of a driver by license number
     */
    public function getHistory($licence) {
        $result = mysql_query("select offence,created_at from psms_data where license = '".$licence."' ORDER BY created_at DESC") or die(mysql_error());
		$array = array();
		
        // check for result
        $no_of_rows = mysql_num_rows($result);
		
		
        if ($no_of_rows > 0) {
		   while($row = mysql_fetch_assoc($result)){
             $array[] = $row;
              

            }
			
           // $result = mysql_fetch_array($result);
	
		   return $array;
        } else {
            // offence not found
            return false;
        }
    }
	
	/**
     * getting history of offence of a driver by license number
     */
    public function getNumberOfOffence($licence) {
        $result = mysql_query("select offence,created_at from psms_data where license = '".$licence."'") or die(mysql_error());
		
		
        // check for result
        $no_of_rows = mysql_num_rows($result);
		
		
        if ($no_of_rows > 0) {
		 
            $result =$no_of_rows;
	           if ($no_of_rows > 3) {
		        return 3;
				}
				return $result;
        } else {
            // offence not found
            return 0;
        }
    }
 /**
     * Checks whether the email is valid or fake
     */
public function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\.\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\-\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\.\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if
(!preg_match('/^(\\.|[A-Za-z0-9!#%&\'_=\/$\'*+?^{}|~.-])+$/',str_replace("\\","",$local)))
      {
         // character not valid in local part unless
         // local part is quoted
         if (!preg_match('/^"(\\"|[^"])+"$/',
             str_replace("\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") ||
 checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}
 /**
     * Check user is existed or not
     */
    public function isUserExisted($pass) {
        $result = mysql_query("SELECT * from psms_users WHERE email = '$pass'");
        $no_of_rows = mysql_num_rows($result);
        if ($no_of_rows > 0) {
            // user existed
            return true;
        } else {
            // user not existed
            return false;
        }
    }
    /**
     * Encrypting password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {
        $salt = md5(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(md5($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
    /**
     * Decrypting password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
        return $hash;
    }
}
?>