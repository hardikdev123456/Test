<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode Class
 *
 * Handles adding scripts functionality to the admin pages
 * as well as the front pages.
 *
 * @package New EMP Form Embed
 * @since 1.0.0
 */
class Emp_Embed_form_Shortcodes{

    public function __construct(){

    }

	/**
     * Adding Hooks for shortcode
     *
     * Adding hooks for the Set counter and check expire
     *
     * @package New EMP Form Embed
     * @since 1.0.0
     */

	function emp_form_embed_form_shortcode($atts, $content) {

        global $shortCodeId;
        $shortCodeId = $atts['pid'];

        extract( shortcode_atts( array(
            'pid'		=>	'0',
        ), $atts ) );

        ob_start();
        include_once( EMP_FORM_DIR . '/includes/shortcode/content-emp_form.php');
        wp_enqueue_style( 'emp_form_embed_bootstrap_org' );
        wp_enqueue_style( 'emp_form_embed_bootstrap_emp' );
        wp_enqueue_style( 'emp_form_embed_bootstrap_theme_emp' );
        wp_enqueue_style( 'empformembed' );
        wp_enqueue_style( 'empformembed-color-css' );
        wp_enqueue_style( 'empformembed-font' );
        $content = ob_get_clean();

        return apply_filters( 'emp_form_embed_form_shortcode', $content, $atts );

    }
    /**
     * Adding Hooks
     *
     * Adding hooks for the styles and scripts.
     *
     * @package New EMP Form Embed
     * @since 1.0.0
     */
    public function add_hooks() {

        //Adding hooks for the Set counter and check expier
        add_shortcode( 'emp_form_embed', array( $this, 'emp_form_embed_form_shortcode' ) );
    }
}
