<?php
/**
* @version $Id: exchange.php 4408 2010-12-03 19:26:30Z tonyb $
$Date: 2010-12-03 14:26:30 -0500 (Fri, 03 Dec 2012) $
$Revision: 1001 $
$Author: tonyb $
$HeadURL:  $
$Id: exchange.php 4408 2010-12-03 19:26:30Z tonyb $
Functions to access Internet exchange rates from sources defaults to the ECB (European Central Bank) etc.
http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml
Retrieves values from RSS feed of 
*/

class exchange_rates
{

public $cache_folder=null;
protected $cache_file="cached_rates.xml"; //file holds chached rates
public $exchange_source_url=null; 
public $exchange_rate_time=null;
private  $exchrate=null;  //array that holds exchange rates
public $cache_time= null; //time to hold the rates 12 hours

// Currency names that we'll use later on
public $names = array (
'USD' => "US Dollar",
'JPY' => "Japanese Yen",
'GBP' => "Pound Sterling",
'CAD' => "Canadian Dollar",
'HKD' => "Hong Kong Dollar",
'CNY' => "Chinese yuan renminbi",		
'INR' => "Indian Rupee",				 
'AUD' => "Australian Dollar",
'SGD' => "Singapore Dollar",		
'EUR' => "European Euro" 
);   //end of array

///////////////////////////////////////////////////
// constructor loads up the the rates URL
// makes the initial call to fetch the rates
public function __construct($url="http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml") 
{
//setup the default values
$this->exchange_source_url=$url;
$this->cache_folder=dirname(__FILE__);   //default to current folder - in production place $_CONFIG['cache_path'] here.
$this->cache_time=(3600 * 24) ;			//how long in seconds to make use of the cached file

$this->fetch_exchange_rates(); //now make the initial call to get the rates
}

/* Perform the mathematical conversion from -> to currency , returns converted currency */
public function exchange_rate_convert($from,$to,$amount)
{

 if ($to=="EUR")   //converting to EUR then find the Inverse of the currency
  {
   //echo "<font color=red>invert</font>";
   if ( $this->exchrate[$to] == 0 ||  $this->exchrate[$from] == 0  )
   {
   echo "Error: Unable to retrieve exchange rates";
   $value=0;
   }
   else
   $value= $amount * (1 / $this->exchrate[$from] )/ $this->exchrate[$to];	
   }
else
  {
   if ( $this->exchrate[$from] == 0 )
   $value=0;
   else
  $value= $amount * $this->exchrate[$to] / $this->exchrate[$from];	 
  }
 return $value;
}

/* Return the currency facotr*/
public function exchange_factor($currency)
{

return  exchange_rate_convert("USD",$currency,1);
}


# Exchange rates - Grab current rates from European Central Bank all rates relative to the EUR  currency
# 1 EUR equievelant to xxx currency
public function fetch_exchange_rates()
{
$cache_time;


$now = time();
$cache =$this->cache_folder."/".$this->cache_file;  //location and filename of rates chached file
$this->exchrate['EUR'] = 1.00;
$amount = 1;
$interval=0;

# Check whether we have a recent copy of the data locally


if (file_exists($cache) )
    $interval = $now - filemtime($cache);
  if (  ( $interval > $cache_time  )  ||  !file_exists($cache)  )   //not in cahce OR cache expired
  {
        $stuff = file( $this->exchange_source_url);  
        $trace = "Fresh XML GET from URL";
		
		if (is_writable($cache))
		 { 
           $fh = fopen ($cache,"w+");
           foreach ($stuff as $line) {
                fputs($fh,$line);
                }
		  }
		  else
		  die("File $cache is not WRITABLE - check folder permissions");
    } 
	else 								//in cache use that data
	{
	$stuff = file($cache);
	$trace = "Using Cached data $interval seconds old";
	}

// Extract data from file- conversion rates between each currency and the Euro
// Now lets loop through the feed and pull out the exhcnage rates
foreach ($stuff as $line) 
{
        if( preg_match("/time='([[:graph:]]+)'/",$line,$gotval) )	//found the time, save it..
		  {
		   $this->exchange_rate_time =$gotval[1];   //extract the value
		  };
        preg_match("/currency='([[:alpha:]]+)'/",$line,$got_currency);  //regex out the currency 
        if (preg_match("/rate='([[:graph:]]+)'/",$line,$got_rate))   //regex out the rate
		        {
                $this->exchrate[$got_currency[1]] = $got_rate[1];    //assign it to the global array
                }
  }  //end of for


} //end of function	  


///////////////////////////////////////////////////
//  Just does a array dump of the exchange rates array
///////////////////////////////
public function show_rates()
{

echo "<pre>";
print_r($this->exchrate);
echo "</pre>";

}


}  //end of class

?>