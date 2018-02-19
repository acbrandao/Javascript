# Javascript+ PHP currency converter script  
Code Sample:using and  PHP Javascript  to do an on-age Currency converter + exchange rates caching RSS feed :
Example of code expalined here www.abrandao.com/2013/04/php-currency-converter-exchange-rates/

## Installation
Simply clone  or download the  files that into your web server folder such as `var/www/html/`. 
Be sure PHP is setup and running. 

  ''Note'' Your webserver must be connected to the Internet to retrieve rates.
 
Change the permissions of the file cached_rates.xml so the script can write and update this file
``chmod 755 cached_rates.xml` 

Adjust the array of currency types t match the ones your ineterested in ..

`// Currency names that we'll use later on
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
); //end of array`


This script by default uses USD to <currency> conversions if you want the base currency to be  different change the default 
	`return exchange_rate_convert("USD",$currency,1);` 
to mactch 

## Usage

 Install all the above on a folder on your PHP supported web server.
 Simply visit the URL containing the example code  calling the example Server Side events demo such as :

http://www.your_website.com/currency_calc/index.php

''Note'' Your webserver must be connected to the Internet to retrieve rates.

## Contributing
1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D
## History
TODO: Write history
## Credits
TODO: Write credits
## License
TODO: Write license
