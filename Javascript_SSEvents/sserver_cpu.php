<?php
date_default_timezone_set("America/New_York");
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache'); // recommended to prevent caching of event data.

$refresh = 2000;  // how often to tell  the browser to re-fresh this page.

/**
 * GetSysteInfo constructs hostname and system CPU metrics into JSON string.
 */
function GetSysteInfo()
{
  $json=null; // default json string to jold fianl values
  $sysinfo=null;

  $time=Date("h:i:s");
  //Get CPU Percentage
  $loads=sys_getloadavg();
  $core_nums=trim(shell_exec("grep -P '^physical id' /proc/cpuinfo|wc -l"));
  $cpu=$loads[0]/$core_nums;
  $sysinfo="{ \"name\": \"CPU %\", \"value\": \"$cpu\" , \"time\": \" $time\", \"icon\": \"fa fa-cog\"   }, " ;
 
  //Get SYSTEM RAM
     $mem = round( ( memory_get_peak_usage())/1024,2)  . " Kb"; //INSUFFICIENT ONLY gets RAM allocated to PHP
  
  
   $sysinfo.="{ \"name\": \"RAM\", \"value\": \"$mem\" , \"time\": \" $time\" , \"icon\": \"fa fa-stack-overflow\" }, " ;

	//Uptime
	$exec_uptime = preg_split("/[\s]+/", trim(shell_exec('uptime')));
    $uptime = $exec_uptime[2] . ' Days';
	$sysinfo.="{ \"name\": \"UPTIME\", \"value\": \"$uptime\" , \"time\": \" $time\" , \"icon\": \"fa fa-clock-o\" }, " ;



   //Get Diskspace
    $bytes = disk_free_space("."); 
   /*
    $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
    $base = 1024;
    $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
    $disk_free_size=sprintf('%1.3f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class] ;
	*/
   $bytes=number_format($bytes)." b";
	$sysinfo.="{ \"name\": \"DISK_FREE\", \"value\": \"$bytes\" , \"time\": \" $time\" , \"icon\": \"fa fa-hdd-o\" },  " ;


	//SSE count
	$size=filesize('counter.txt') ;  //Just a file that keeps an incrment counter
	$fp = fopen("counter.txt", "r+");

	while(!flock($fp, LOCK_EX)) {  // acquire an exclusive lock
	// waiting to lock the file
	}

	$counter = intval(fread($fp, filesize("counter.txt")));
	$counter++;

	ftruncate($fp, 0);      // truncate file
	fwrite($fp, $counter);  // set your data
	fflush($fp);            // flush output before releasing the lock
	flock($fp, LOCK_UN);    // release the lock

	fclose($fp);
    
	$sysinfo.="{ \"name\": \"SSE_COUNT\", \"value\": \"$counter\" , \"time\": \" $time\" , \"icon\": \"fa fa-hdd-o\" },  " ;

	$sysinfo.="{ \"name\": \"COUNT_SIZE\", \"value\": \"$size b\" , \"time\": \" $time\" , \"icon\": \"fa fa-hdd-o\" }  " ;

	//Aapche Log File REGEX: /^(\S+) (\S+) (\S+) \[([^:]+):(\d+:\d+:\d+) ([^\]]+)\] \"(\S+) (.*?) (\S+)\" (\S+) (\S+) "([^"]*)" "([^"]*)"$/

 $json= "[".rtrim($sysinfo, ',')."]";

 //echo $json;
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
  echo "data: $message" . PHP_EOL;
  echo PHP_EOL;
  ob_flush();  
  flush(); //don't forget to flush so the server sends it out
} 



//NO Need to LOOP this message as browser will re-connect every 3 seconds
sendMsg( time() ,GetSysteInfo());
 
?>
