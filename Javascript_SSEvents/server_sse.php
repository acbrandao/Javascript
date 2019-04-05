<?php

date_default_timezone_set("America/New_York");
header("Content-Type: text/event-stream\n\n");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0 \n\n");
header('X-Accel-Buffering: no'); //// Setting this header instructs Nginx to disable fastcgi_buffering and disable gzip

header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache\n\n");

ob_start();


 while (true) {

  echo "event: ping\n";
  $curDate = date(DATE_ISO8601);
  $counter = rand(1, 10);
  echo 'data: {"time": "' . $curDate . '", "random": "'.$counter.'"}';
  echo "\n\n";
  ob_flush();
  ob_end_flush();
  flush();
  
  sleep(1); // sleep for 1 second before running the loop again
  }

?>