var express = require("express");
var logger = require("morgan");
var http = require("http");
var parseString = require('xml2js').parseString;

var app = express();

app.use(express.bodyParser());
app.use(logger());


app.all("*", function(request, response, next) {
    next();
});

app.get("/", function(request, response) {
    response.end("Welcome to the homepage");
});

app.get("/news", function(request, response) {

    var options = {
        host: 'www.infoworld.com',
        path: '/taxonomy/term/21668/feed'
//    port: '1337',
//    method: 'POST'
    };
    http.get(options, function(ans) {
        var str = '';
        ans.on('data', function(chunk) {
            str += chunk;
        });
        ans.on('end', function() {
            response.writeHead(200, {"Content-Type": "text/plain"});
            var xml = str;
            var toDisplay;
            parseString(xml, function(err, result) {
//                console.log(result.rss.channel[0].title);
                toDisplay = JSON.stringify(result);
//                toDisplay = result.rss.channel[0].title.toString();
            });
            response.write(toDisplay);
            response.end();



        });
    });
//response.redirect("/profile/lucian");
});

app.listen(8008);