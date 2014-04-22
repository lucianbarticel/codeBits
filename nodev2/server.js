var express = require("express");
var jade = require("jade");
var bodyParser = require("body-parser");
var routes = require("./routes");
var app = express();


app.set("views", __dirname+"/views");
app.set("view engine", "jade");
app.use(bodyParser());

routes.init(app);

app.listen(3000);