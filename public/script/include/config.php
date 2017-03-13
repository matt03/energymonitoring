<?php
/**
* Database config variables
*/
//Get details for the database
  $host = "localhost";
  $DBname = "PSMS";
  $user = "root";
  $password = "";
  $charSet = $_POST['char_name'];
  $collation = $_POST['collation_name'];
  
  define("DB_HOST",  $host);
  define("DB_DATABASE", $DBname);
  define("DB_USER",  $user);
  define("DB_PASSWORD", $password);
  define("DB_CHARSET", $charSet);
  define("DB_COLLATION", $collation);
  define("DB_PREFIX", "");
  
   //its connection to mysql
  
        $con =mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		// Check connection
      if ($con) {
        die('Failed to connect to MySQL: ' . mysql_error());
	   }
          // selecting database
        mysql_select_db(DB_DATABASE);
     $ListOfTables = mysql_query("SHOW TABLES FROM '".DB_DATABASE."'");
          //geting the tables
     $no_of_tables = mysql_num_rows($ListOfTables);
	if( $no_of_tables >0) {
	  $response["success"] = 1;
	  $table = mysql_fetch_array($ListOfTables);
     for($i=0;$i< no_of_tables;$i++)
     {
	    
         $ListOfColumns = mysql_query("SHOW COLUMNS FROM '".$table[$i]."' FROM '".DB_DATABASE."'");
		 $no_of_columns = mysql_num_rows($ListOfColumns);
		 $column = mysql_fetch_array($ListOfColumns);
         for($j=0;$j< no_of_columns;$j++)
         {
		     
            $response["table".$i]["column".$j] = $column[$j];
         }
		  
	 }
	 echo json_encode($response);
   } 
   else{
      $response["error"] = 0;
	  $response["error_msg"] = "error in getting database";
            echo json_encode($response);
   }

if (isset($_POST['tag']) && $_POST['tag'] != '') {

    // response Array
    $response = array("tag" => $tag, "success" => 0, "error" => 0);
   // Get tag
    $tag = $_POST['tag'];
	
	
if($tag == "sqlite")
{ 
//Get details for the database
  $name = $_POST['db_name'];
  
  define("DB_DATABASE", $name);
  define("DB_PREFIX", "");
  
  //its connection details
  
}else if($tag == "sqlsrv"){
//Get details for the database
  $host = $_POST['host_name'];
  $DBname = $_POST['database_name'];
  $user = $_POST['user_name'];
  $password = $_POST['password'];
 
  
  define("DB_HOST",  $host);
  define("DB_DATABASE", $DBname);
  define("DB_USER",  $user);
  define("DB_PASSWORD", $password);
  define("DB_PREFIX", "");
  
 //its connection details
}
else if($tag == "mysql"){
 //Get details for the database
  $host = $_POST['host_name'];
  $DBname = $_POST['database_name'];
  $user = $_POST['user_name'];
  $password = $_POST['password'];
  $charSet = $_POST['char_name'];
  $collation = $_POST['collation_name'];
  
  define("DB_HOST",  $host);
  define("DB_DATABASE", $DBname);
  define("DB_USER",  $user);
  define("DB_PASSWORD", $password);
  define("DB_CHARSET", $charSet);
  define("DB_COLLATION", $collation);
  define("DB_PREFIX", "");
  
   //its connection to mysql
  
        $con =mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		// Check connection
      if ($con) {
        die('Failed to connect to MySQL: ' . mysql_error());
	   }
          // selecting database
        mysql_select_db(DB_DATABASE);
     $ListOfTables = mysql_query("SHOW TABLES FROM '".DB_DATABASE."'");
          //geting the tables
     $no_of_tables = mysql_num_rows($ListOfTables);
	if( $no_of_tables >0) {
	  $response["success"] = 1;
	  $table = mysql_fetch_array($ListOfTables);
     for($i=0;$i< no_of_tables;$i++)
     {
	    
         $ListOfColumns = mysql_query("SHOW COLUMNS FROM '".$table[$i]."' FROM '".DB_DATABASE."'");
		 $no_of_columns = mysql_num_rows($ListOfColumns);
		 $column = mysql_fetch_array($ListOfColumns);
         for($j=0;$j< no_of_columns;$j++)
         {
		     
            $response["table".$i]["column".$j] = $column[$j];
         }
		  
	 }
	 echo json_encode($response);
   } 
   else{
      $response["error"] = 0;
	  $response["error_msg"] = "error in getting database";
            echo json_encode($response);
   }
}
else if($tag == "pgsql"){
 //Get details for the database
  $host = $_POST['host_name'];
  $DBname = $_POST['database_name'];
  $user = $_POST['user_name'];
  $password = $_POST['password'];
  $charSet = $_POST['char_name'];
  $schema = $_POST['schema_name'];
  
  define("DB_HOST",  $host);
  define("DB_DATABASE", $DBname);
  define("DB_USER",  $user);
  define("DB_PASSWORD", $password);
  define("DB_CHARSET", $charSet);
  define("DB_SCHEMA", $schema);
  define("DB_PREFIX", "");
  
   //its connection details
}
	

}
?>