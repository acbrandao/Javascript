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
if (page=="") 
  page="index.html" ;  //defaults to index.hmtl or index.php


console.log(" Current page: "+ page );
var url="hotreload.php?file="+page ; //change this to whatever you want it to be
var poll_interval=2000; //every x seconds poll for file changes.

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
 				    window.location.reload(false);
 				   }	
 				else
				console.log("No Change:");
 
 				
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
