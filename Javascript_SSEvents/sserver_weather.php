<?php
date_default_timezone_set("America/New_York");
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache'); // recommended to prevent caching of event data.

/**
 * World City Weather Feed using APIXU - Free API dataa
 */

$Cities = ['New York','Lisbon','Paris','Rio de Janeiro','Hong Kong','Sydney','Dubai','Tokyo','Johannesburg']; //list of city names to get weather
//$Cities = ['New York','Lisbon']; //list of city names to get weather
$APIXU_API_KEY='21476d25f7cd41f6ada04741190604';  //<YOUR_APIXU_SECRET_KEY>   // see https://www.apixu.com/
$APIXU_URL="http://api.apixu.com/v1/current.json?key=$APIXU_API_KEY&q={CITY}";
$refresh = 30000;  // how often to tell  the browser to re-fresh this page.


function getWeather()
{
global $APIXU_URL, $Cities;

	foreach ($Cities as $city)
	{
	$url='';
	$url=str_replace("{CITY}",urlencode($city),$APIXU_URL);
//	$json = json_decode(file_get_contents($url), true);
	$json.= file_get_contents($url).",";	
	}
	
	 $json= "[".rtrim($json, ',')."]";


	 return  $json;
}

/**
 * Constructs the SSE data format and flushes that data to the client.
 *
 * @param string $id id of this connection.
 * @param string $message Line of text that should be transmitted.
 */
function sendMsg($id, $message ) {
global $refresh ;
  echo "retry: $refresh" . PHP_EOL;  //change retry to every second
  echo "id: $id" . PHP_EOL;
  echo "data:   $message" . PHP_EOL;

  echo PHP_EOL;
  ob_flush();  
  flush(); //don't forget to flush so the server sends it out
} 



//Query APIXU City weather and display results

sendMsg( time() , getWeather() );

?>
