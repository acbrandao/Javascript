///-----------------------------------------------------------------
///   Hotload.js : Simple JAvascript include file to poll server (PHP)
///   file checker code
///   
///   Description: XHTTP Request  polls for file changes
///   Author:          abrandao29@gmail.com       Date: 4/28/2019
///   Notes:          <script src="hotreload.js"> 
///
///   Revision History:
///   Name:           Date:        Description:
///-----------------------------------------------------------------
var page =location.href.split("/").slice(-1); 
if (page=="")   //defaults to index.hmtl if no name is found from the location.href
  page="index.html" ; 


console.log(" Current page: "+ page );
var url="hotreload.php?file="+page ; //change this to whatever you want it to be
var poll_interval=3000; //every x seconds poll for file changes. Ajust to suit your requirements

setInterval( function() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
           if (xmlhttp.status == 200) {
 				//console.log(xmlhttp.responseText);
 				j=JSON.parse(xmlhttp.responseText);
 				console.log(j);
 				//if file changed RESTULT is TRUE we issue a 

 				if (j.hasChanged)
 				  { 
 				    console.log("Changed!");
 				    window.location.reload(false);  //reload the entire page
 				   }	
 				
 
 				
           }
           else if (xmlhttp.status == 400) {
              alert('error 400');
           }
           else {
               alert('Error '+xmlhttp.status );
           }
        }
    };
    xmlhttp.open("GET", url, true);
    xmlhttp.send();
}

//Now let's keep checking if theres been a change.
, poll_interval);
