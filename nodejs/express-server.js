// Super simple Express Server
// requires Express be installed use the following command
// npm install -g express

const express = require("express");
const port = 3000;

//Init express
const app = express();

//Create endpoints/routes handlers
app.get("/", function(req, res) {
  var date = new Date();
  var current_hour = date.getHours();

  res.statusCode = 200;
  res.setHeader("Content-Type", "text/html");
  res.end(
    "<html><head></head><body><h1>Hello Express - NodeJS <p>Current Time: " +
      date +
      "</p> </h1></body></html>"
  );

  if (err) console.log("error", err.message, err.stack);
});

try {
  // Listen for incoming requests and serve them.
  app.listen(port, () => {
    console.log(`Server listening on port ${port}`);
  });
} catch (err) {
  console.log(err);
  return;
}
