(function() {
    tinymce.create('tinymce.plugins.pokerShortCodes', {
        init: function(ed, url) {
            ed.addButton('pokershortcodes', {
                title: 'pokershortcodes.youtube',
                image: url + '/cards.png',
                onclick: function() {
                    ed.windowManager.open({
                        file: url + '/poker.php',
                        width: 320 + ed.getLang('example.delta_width', 0),
                        height: 200 + ed.getLang('example.delta_height', 0),
                        inline: 1
                    }, {
                        plugin_url: url, // Plugin absolute URL
                        some_custom_arg: 'custom arg' // Custom argument
                    });
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        },
        getInfo: function() {
            return {
                longname: "Alex Stoicuta Poker Shortcode",
                author: 'Alex Stoicuta',
                authorurl: 'http://www.alexstoicuta.ro/',
                infourl: 'http://www.alexstoicuta.ro/',
                version: "1.0"
            };
        }
    });
    tinymce.PluginManager.add('pokershortcodes', tinymce.plugins.pokerShortCodes);
})();