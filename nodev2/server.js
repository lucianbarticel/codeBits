var express = require("express");
var jade = require("jade");
var bodyParser = require("body-parser");
var session = require("cookie-session");
var routes = require("./routes");
//var less = require("less");
var app = express();

//less.render('.greeting { color: green }', function (e, css) {
//  console.log(css);
//});

app.use(session({secret: '1234567890QWERTY'}));
app.set("views", __dirname+"/views");
app.set("view engine", "jade");
app.use(bodyParser());

routes.init(app);

app.listen(3000);