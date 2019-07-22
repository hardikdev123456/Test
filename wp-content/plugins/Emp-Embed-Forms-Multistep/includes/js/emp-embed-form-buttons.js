// JavaScript Document
jQuery(document).ready(function($) {

    // Start Shortcodes Click
    (function() {
        tinymce.create('tinymce.plugins.empembedformshortcodes', {
            init : function(ed, url) {

                ed.addButton('empembedformshortcodes', {
                    title : 'EMP EMBED FORM LIST',
                    image : url+'/images/ww-wpsc.jpeg',
                    onclick : function() {

                        jQuery('.emp-embed-form-popup-overlay').fadeIn();
                        jQuery('.emp-embed-form-popup-content').fadeIn();
                        jQuery('#emp_embed_form_shortcode').val('');
                    }
                });
            },
            createControl : function(n, cm) {
                return null;
            },
        });

        tinymce.PluginManager.add('empembedformshortcodes', tinymce.plugins.empembedformshortcodes);
    })();

    jQuery( document ).on('click', '.emp-embed-form-popup-close-button, .emp-embed-form-popup-overlay', function () {
        jQuery('.emp-embed-form-popup-overlay').fadeOut();
        jQuery('.emp-embed-form-popup-content').fadeOut();
    });

    jQuery( document ).on('click', '#emp_embed_form_insert_shortcode', function () {

        var shortcode = jQuery('#emp_embed_form_shortcode').val();
        var shortcodestr = '';
        if(shortcode == '') {
            jQuery('.emp-embed-form-popup-error').fadeIn();
            return false;
        } else {
            tinyMCE.activeEditor.setContent('');
            jQuery('.emp-embed-form-popup-error').hide();

            shortcodestr += '[emp_form_embed pid = '+shortcode+']';

            window.send_to_editor( shortcodestr );
            jQuery('.emp-embed-form-popup-overlay').fadeOut();
            jQuery('.emp-embed-form-popup-content').fadeOut();
        }
    });

});