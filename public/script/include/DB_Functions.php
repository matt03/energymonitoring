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
  $result = mysql_query("UPDATE `rsmsa_users` SET `password` = '$newpassword'
              WHERE `userId` = '$rankNo'");
			  
 $result2 = mysql_query("select * from rsmsa_users where rankNo = '".$rankNo."'") or die(mysql_error());
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
    public function storeOffence($license, $plateNumber, $offence, $commit, $rankNo, $amount) {
       
        $result = mysql_query("INSERT INTO psms_data( license, plateNumber, offence, commit,amount, created_at, rankNo) VALUES('$license', '$plateNumber', '$offence', '$commit', '$amount', NOW(),'$rankNo')");
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