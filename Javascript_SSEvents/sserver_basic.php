<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache'); // recommended to prevent caching of event data.

/**
 * Constructs the SSE data format and flushes that data to the client.
 *
 * @param string $id id of this connection.
 * @param string $message Line of text that should be transmitted.
 */
function sendMsg($id, $message ) {
  echo "id: $id" . PHP_EOL;
  echo "data: $message" . PHP_EOL;
  echo PHP_EOL;
  ob_flush();  
  flush(); //don't forget to flush so the server sends it out
} 



//NO Need to LOOP this message as browser will re-connect every 3 seconds
sendMsg( time() , 'server time: ' . date("h:i:s", time()));

?>
