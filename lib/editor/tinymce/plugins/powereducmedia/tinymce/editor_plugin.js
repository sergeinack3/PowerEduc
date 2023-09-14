/**
 * @author Dongsheng Cai <dongsheng@powereduc.com>
 */

(function() {
    var each = tinymce.each;

    tinymce.PluginManager.requireLangPack('powereducmedia');

    tinymce.create('tinymce.plugins.PowerEducmediaPlugin', {
        init : function(ed, url) {
            var t = this;

            t.editor = ed;
            t.url = url;

            // Register commands.
            ed.addCommand('mcePowerEducMedia', function() {
                ed.windowManager.open({
                    file : url + '/powereducmedia.htm',
                    width : 480 + parseInt(ed.getLang('media.delta_width', 0)),
                    height : 480 + parseInt(ed.getLang('media.delta_height', 0)),
                    inline : 1
                }, {
                    plugin_url : url
                });
            });

            // Register buttons.
            ed.addButton('powereducmedia', {
                    title : 'powereducmedia.desc',
                    image : url + '/img/icon.png',
                    cmd : 'mcePowerEducMedia'});

        },

        _parse : function(s) {
            return tinymce.util.JSON.parse('{' + s + '}');
        },

        getInfo : function() {
            return {
                longname : 'PowerEduc media',
                author : 'Dongsheng Cai <dongsheng@powereduc.com>',
                version : "1.0"
            };
        }

    });

    // Register plugin.
    tinymce.PluginManager.add('powereducmedia', tinymce.plugins.PowerEducmediaPlugin);
})();
