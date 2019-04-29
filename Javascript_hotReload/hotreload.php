<?php
/**
 * hotreload.php
 *
 * Simple file checker and returns back information
 * about the state of the  file
 *
 * @copyright  2019 abrandao.com
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @author Tony Brandao <abrandao29@gmail.com>
 */
error_reporting(E_ALL);
ini_set('display_errors', 'On');
date_default_timezone_set("UTC"); 
header('Content-Type: application/json');
session_start();  //used to keep track of when the file changes
$changed=false; //assume tha the file has not changed

$basename= basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);

$referrer=isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : 'index.html';

$filename = isset($_REQUEST['file'])? trim($_REQUEST['file'])  :$referrer ; //assume that the calling web-

if (@file_exists($filename))
   $md5_file=md5_file($filename);	//let's get the MD5 file info
else
die(json_encode("file [$filename] MISSING,filename does not exist. Check name and path ."));	

//now let's save the current file
 if  ( isset($_SESSION[$filename] )    ) //do we have this session set?
 {
    if ( $md5_file != $_SESSION[$filename] )
     $changed=true;
      $_SESSION[$filename] =$md5_file;  //update the session variable
 }
 else
 {
  $_SESSION[$filename] =$md5_file;
 }

//store this information into the file array


$file_data= array("filename" =>$filename, 
 	 "hasChanged" => $changed,
	  "filetime" => date ("H:i:s m-d-Y", filemtime($filename)),
	  "filesize" => filesize($filename),
	  "basename" => $basename
 	  );

$result= json_encode($file_data);

echo $result;

 ?>