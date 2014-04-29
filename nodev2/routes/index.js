exports.init = function(app) {

    function checkAuth(req, res, next) {
        if (!req.session.username) {
            res.redirect('/login');
        } else {
            next();
        }
    }

    app.get('/login', function(req, res) {
        res.header("Content-Type", "text/html; charset=utf-8");
        res.render('login', {title: "please log in", content:"Insert credentials bellow"});
    });

    app.post('/login', function(req, res) {
        var post = req.body;
        if (post.userName === 'lucian' && post.passWord === 'lucianpass') {
            req.session.username = 'lucian';
            res.redirect('/');
        } else {
            res.render('login', {title: "please log in", content:"Bad username or password. Try again"});
        }
    });

    app.get('/', checkAuth, function(req, res) {
        res.header("Content-Type", "text/html; charset=utf-8");
        res.render('home', {title: "appLuc", name: "Lucian"});
    });
    app.post('/', function(req, res) {
//        console.log(req.body);
        res.render('home', {title: "appLuc", name: req.body.someName, content: req.body.someContent});
    });

    app.get('/logout', function(req, res) {
        delete req.session.username;
        res.redirect('/login');
    });

};