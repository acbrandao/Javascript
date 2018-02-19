<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Widget Currency Calc</title>
</head>
<body>
<h1>PHP Exchange Rate Calculator</h1>
<?php

require "widget_currency_calc.php"; //import class containing the exchange rates

echo "<hr>";


$rates = new exchange_rates();  //instantiate the class

//Some Test rates
echo "1 USD equals ".$rates->exchange_rate_convert("USD","EUR",1) . " EUR <br>";
echo "1 USD equals ".$rates->exchange_rate_convert("USD","GBP",1) . " GBP <br>";
echo "1 USD equals ".$rates->exchange_rate_convert("USD","CAN",1) . " CAN <br>";
echo "1 USD equals ".$rates->exchange_rate_convert("USD","CNY",1) . " EUR <br>";

$rates->show_rates();

?>
</body>
</html>
