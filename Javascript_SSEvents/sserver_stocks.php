<?php
date_default_timezone_set("America/New_York");
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache'); // recommended to prevent caching of event data.

/**
 * SIMULATED StockFeed (not real) Stock Prices
 */

$stocks = ['GOOG','TSLA','F','BA']; //array of stock symbols/tickers
$refresh = 5000;  // tell the browser to re-fresh this page.

function RandomStockFeed()
{
global $stocks;  //use the globally defined stock symbols

$json_stock_data=null;
$symbol_idx = rand(0,count($stocks)-1 ) ; //let's pick a random sumbol
$price =   rand(100, 300) ; // some random integer will serve as price
$price = sprintf('%0.2f',$price ) ;
$time = date("h:i:s", time());
$json_stock_data=' {  "STOCK": "'.$stocks[$symbol_idx].'","ask":'.$price.' ,  "time": "'.$time.'" } ';
 return $json_stock_data;
}

/**
 * Constructs the SSE data format and flushes that data to the client.
 *
 * @param string $id id of this connection.
 * @param string $message Line of text that should be transmitted.
 */
function sendMsg($id, $message ) {
  echo "retry: $refresh" . PHP_EOL;  //change retry to every second
  echo "id: $id" . PHP_EOL;
  echo "data:   $message" . PHP_EOL;

  echo PHP_EOL;
  ob_flush();  
  flush(); //don't forget to flush so the server sends it out
} 



//Generate a RANDOM STOCK AND RANDOM Price on each call
sendMsg( time() , RandomStockFeed() );

?>
