<?php 

// set the default timezone to use. Available since PHP 5.1
date_default_timezone_set('UTC');


// Prints something like: Monday
echo date("l");

// Prints something like: Monday 8th of August 2005 03:12:46 PM
echo date('l jS \of F Y h:i:s A');

?>