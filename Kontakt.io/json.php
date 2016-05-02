<!--
<a href="csv.php">Download CSV file</a><br><br>
-->
<a href="csv.php">Download CSV file</a><br><br>

<?php
session_start();

// Get cURL resource
$curl = curl_init();

// Set URL & headers.
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://api.kontakt.io/device/',
    CURLOPT_HTTPHEADER  => array('Api-Key: ','Accept:application/vnd.com.kontakt+json;version=8'),));

// Send the request & save response
$json = curl_exec($curl);

// Use a test txt file instead
//$json = file_get_contents('json.txt');

// Close request to clear up some resources
curl_close($curl);

//Use json_decode to convert the data to an associative array.
$array=json_decode($json,true); //echo $array['devices'][0]['uniqueId'];

// Define columns to be fetched
$columns=array('uniqueId','proximity','major','minor','txPower','interval','firmware');

// Function to create the html table
function build_table($array){global $columns;$html = '<table>';global $data;global $csv;
 //headers
 $html .= '<tr>';foreach($columns as $key=>$value){$html .= '<th>' . $value . '</th>';}$html .= '</tr>';
 // data rows
 foreach( $array['devices'] as $key=>$value){$html .='<tr>';foreach($columns as $key1=>$value1){
        $html .='<td>'.$array['devices'][$key][$value1].'</td>';$data[$key][]=$array['devices'][$key][$value1];
 }$html .='</tr>';}
 // Finish table and return it
 $html .= '</table>';return $html;}

// Print html table
echo build_table($array);

// Merge arrays to turn into CSV file
$_SESSION["csv"]=array_merge(array($columns),$data);

?>
