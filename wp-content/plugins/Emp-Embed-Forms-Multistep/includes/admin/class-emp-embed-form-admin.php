<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Admin Class
 *
 * Handles generic Admin functionality and AJAX requests.
 *
 * @package New EMP Form Embed
 * @since 1.0.0
 */
class Emp_Embed_form_Admin {

    public $scripts;

    public function __construct() {

        global $emp_embed_form_scripts;
        $this->scripts = $emp_embed_form_scripts;
    }

    /**
     * Register Buttons
     *
     * Register the different content locker buttons for the editor
     *
     * @package New EMP Form Embed
     * @since 1.0.0
     */
    public function empembedform_shortcode_editor_register_button( $buttons ) {

        array_push( $buttons, "|", "empembedformshortcodes" );
        return $buttons;
    }


    /**
     * Editor Pop Up Script
     *
     * Adding the needed script for the pop up on the editor
     *
     * @package New EMP Form Embed
     * @since 1.0.0
     */
    public function empembedform_shortcode_editor_button_script( $plugin_array ) {

        wp_enqueue_script( 'tinymce' );

        $plugin_array['empembedformshortcodes'] = EMP_FORM_URL . 'includes/js/emp-embed-form-buttons.js?ver='.EMP_FORM_VERSION;
        return $plugin_array;

    }

    /**
     * Shortcode Button
     *
     * Adds the shortcode button above the WordPress editor.
     *
     * @package New EMP Form Embed
     * @since 1.0.0
     */

    public function emp_embed_form_shortcode_button() {

        if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
            return;
        }

        if ( get_user_option( 'rich_editing' ) == 'true' ) {
            add_filter( 'mce_external_plugins', array( $this, 'empembedform_shortcode_editor_button_script' ) );
            add_filter( 'mce_buttons', array( $this, 'empembedform_shortcode_editor_register_button' ) );
        }
    }


    /**
     * Pop Up On Editor
     *
     * Includes the pop up on the WordPress editor
     *
     * @package New EMP Form Embed
     * @since 1.0.0
     */
    public function emp_embed_form_shortcode_popup_markup() {
        include_once( EMP_FORM_DIR . '/includes/admin/forms/emp-embed-form-shortcodes-popup.php' );
    }


    /**
     * Adding Hooks
     *
     * @package New EMP Form Embed
     * @since 1.0.0
     */
    public function add_hooks() {
        // shortcode button
        add_action( 'init', array( $this, 'emp_embed_form_shortcode_button' ) );

        // mark up for popup
        add_action( 'admin_footer-post.php', array( $this,'emp_embed_form_shortcode_popup_markup') );

        //Includes the pop up on the WordPress editor
        add_action( 'admin_footer-post-new.php', array( $this,'emp_embed_form_shortcode_popup_markup') );
    }
}
?>