# simple  HOT Reload JS
![](hotreload_page.PNG?raw=true) 
This is a simple plain vanilla JS file hot-reload checker,
	It simulates browser hot-reload through a combination of 
	polling and server-sde file checker. EXTREMELY SIMPLE SCript to 
	deploy and use.  Just add one  line of code to the bottom of any web page
	that you want to re-load on file change. 

### Prerequisites

Requires that the web page you want to hot reload be served form a 
PHP web server, so that the PHP file checker can run.

### Installing

Simple clone this repo to your development directory tree , or just 
save the hotreload.js file and add it to the bottom of your web page.

```
<script type="text/javascript" src="hotreload.js"></script>
```

Finally, make the any changes to your web page, and momentarily it 
should reload the newly saved page.  Note any form or other session 
data on your web page will not be retained. 

## Trying it out.

Make a change to the web page like change the 
```
<h1> Simpel JS Hot Reload <h1>
```
to 
```
<h1> It works! Simpel JS Hot Reload <h1>
```

and you'r web page should shoe the difference

### Tested in ..


## Deployment

This is primarily a web development AID, when you're happy with 
you're web page, simplly, remove the <Script> tag
```
<script type="text/javascript" src="hotreload.js"></script>
```

and you're page will stop the reloads.



## Authors

* **Tony Brandao** - *Initial work* - [TonyBrandao](https://github.com/PurpleBooth)

See also the list of [contributors](https://github.com/your/project/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Webpack and other modern webframeworks that hot-reload the code for you.
