<?php
 
 function sqlToXml($queryResult, $rootElementName, $childElementName)
{ 
    $xmlData = "<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n"; 
    $xmlData .= "<" . $rootElementName . ">";
 
    while($record = mysql_fetch_object($queryResult))
    { 
        /* Create the first child element */
        $xmlData .= "<" . $childElementName . ">";
 
        for ($i = 0; $i < mysql_num_fields($queryResult); $i++)
        { 
            $fieldName = mysql_field_name($queryResult, $i); 
 
            /* The child will take the name of the table column */
            $xmlData .= "<" . $fieldName . ">";
 
            /* We set empty columns with NULL, or you could set 
                it to '0' or a blank. */
            if(!empty($record->$fieldName))
                $xmlData .= $record->$fieldName; 
            else
                $xmlData .= "null"; 
 
            $xmlData .= "</" . $fieldName . ">"; 
        } 
        $xmlData .= "</" . $childElementName . ">"; 
    } 
    $xmlData .= "</" . $rootElementName . ">"; 
 
    return $xmlData; 
}
//END OF FUNCTION

    //Create Database connection
    $db = @mysql_connect("pdb7.runhosting.com","896128_paul","paulpeter2014");
    if (!$db) {
        die('Could not connect to db: ' . mysql_error());
    }
 
    //Select the Database
    mysql_select_db("896128_paul",$db);
 
    $result = mysql_query("select plateNumber,model,color,year_manufactured
	                       from vehicle_owner", $db);  
 
 /* If you want to process the returned xml rather than send it
    to the browser, remove the below line.
*/
header("Content-Type: application/xml");
echo sqlToXml($result, "menu", "item");
    