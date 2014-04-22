exports.init = function (app){
    app.get('/', function (req, res){
        res.header("Content-Type", "text/html; charset=utf-8");
        res.render('home', {title: "appLuc", name: "Lucian"});
    });
    app.post('/', function(req, res){
//        console.log(req.body);
        res.render('home', {title: "appLuc", name: req.body.someName});
    })
};