<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * script Class
 *
 * Handles adding scripts functionality to the admin pages
 * as well as the front pages.
 *
 * @package New EMP Form Embed
 * @since 1.0.0
 */
class Emp_Embed_form_Scripts
{

    public function __construct()
    {

    }

    public function emp_form_embed_register_styles() {

        wp_register_style(  'emp_form_embed_bootstrap_org',
                            EMP_FORM_URL.'includes/css/plugins/bootstrap/css/bootstrap.min.css',
                            array(), EMP_FORM_VERSION );

        wp_register_style(  'emp_form_embed_bootstrap_emp',
                            EMP_FORM_URL.'includes/css/plugins/bootstrap/css/bootstrap-emp.min.css',
                            array(), EMP_FORM_VERSION );

        wp_register_style(
                            'emp_form_embed_bootstrap_theme_emp',
                            EMP_FORM_URL.'includes/css/plugins/bootstrap/css/bootstrap-theme-emp.min.css',
                            array(), EMP_FORM_VERSION );

        wp_register_style(
                            'emp_form_embed_bootstrap_datepicker',
                            EMP_FORM_URL.'includes/css/plugins/bootstrap/css/bootstrap-datepicker3.min.css',
                            array(), EMP_FORM_VERSION );

		wp_register_style(
                            'themerex-options-style', EMP_FORM_URL.'includes/css/theme-options-datepicker.css',
                            array(), EMP_FORM_VERSION );
		wp_register_style(
                            'fontello-admin', EMP_FORM_URL.'includes/css/fontello-admin.css',
                            array(), EMP_FORM_VERSION );


        wp_register_style(  'empformembed',
                            EMP_FORM_URL.'includes/css/index.css',
                            array(), EMP_FORM_VERSION );

        wp_register_style(  'empformembed-font',
                            'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css',
                            array(), EMP_FORM_VERSION );

        wp_register_script( 'empformembed-jquery-ui',
                            EMP_FORM_URL.'includes/css/plugins/jquery/jquery-ui.js',
                            array(), EMP_FORM_VERSION );

        wp_register_script( 'empformembed-jquery-masked',
                            EMP_FORM_URL.'includes/css/plugins/jquery/jquery-masked.js',
                            array(), EMP_FORM_VERSION );

        wp_register_script( 'empformembed-jquery-pubsub',
                            EMP_FORM_URL.'includes/css/plugins/jquery/jquery-pubsub.js',
                            array(), EMP_FORM_VERSION );

        wp_register_script( 'empformembed-validate',
                            EMP_FORM_URL.'includes/css/plugins/iqs/validate.js',
                            array(), EMP_FORM_VERSION );

        wp_register_script( 'empformembed-field-library',
                            EMP_FORM_URL.'includes/js/field_rules_form_library.js',
                            array(), EMP_FORM_VERSION );

        wp_register_script( 'empformembed-field-handler',
                            EMP_FORM_URL.'includes/js/field_rules_handler.js',
                            array(), EMP_FORM_VERSION );

        // public script
        wp_register_script( 'emp-form-embed-public-js',
                            EMP_FORM_URL.'includes/js/index.js',
                            array(), EMP_FORM_VERSION );

        wp_localize_script( 'emp-form-embed-public-js',
                            'EMPFORM',
                            array('ajaxurl' => admin_url('admin-ajax.php')) );

        wp_register_script( 'empformembed-bootstrap',
                            EMP_FORM_URL.'includes/css/plugins/bootstrap/js/bootstrap.min.js',
                            array(), EMP_FORM_VERSION );

        wp_register_script( 'empformembed-validate-admin',
            'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js',
            array(), EMP_FORM_VERSION );

        wp_register_script( 'empformembed-bootstrap-datepicker',
                            EMP_FORM_URL.'includes/css/plugins/bootstrap/js/bootstrap-datepicker.min.js',
                            array(), EMP_FORM_VERSION );

    }

    /**
     * Short code popup page style
     * at admin side
     *
     * @package New EMP Form Embed
     * @since 1.0.0
     */
    public function emp_form_embed_admin_styles( $hook_suffix ) {

        $pages_hook_suffix = array( 'post.php', 'post-new.php' );

        //Check pages when you needed
        if( in_array( $hook_suffix, $pages_hook_suffix ) ) {

	        wp_register_style(  'emp_form_embed_bootstrap_org',
		        EMP_FORM_URL.'includes/css/plugins/bootstrap/css/bootstrap.min.css',
		        array(), EMP_FORM_VERSION );
	        wp_enqueue_style( 'emp_form_embed_bootstrap_org' );

	        wp_register_script( 'empformembed-bootstrap',
		        EMP_FORM_URL.'includes/css/plugins/bootstrap/js/bootstrap.min.js',
		        array(), EMP_FORM_VERSION );
	        wp_enqueue_script( 'empformembed-bootstrap' );

	        wp_register_style(
		        'emp_form_embed_bootstrap_datepicker',
		        EMP_FORM_URL.'includes/css/plugins/bootstrap/css/bootstrap-datepicker3.min.css',
		        array(), EMP_FORM_VERSION );
	        wp_enqueue_style( 'emp_form_embed_bootstrap_datepicker' );

	        wp_register_style(  'empformembed-font',
		        'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css',
		        array(), EMP_FORM_VERSION );
	        wp_enqueue_style( "empformembed-font" );

	        wp_register_script( 'empformembed-bootstrap-datepicker',
		        EMP_FORM_URL.'includes/css/plugins/bootstrap/js/bootstrap-datepicker.min.js',
		        array(), EMP_FORM_VERSION );
	        wp_enqueue_script( 'empformembed-bootstrap-datepicker' );

	        // loads the required styles for the Short code popup page
            wp_register_style( 'empformembed-admin',
                                EMP_FORM_URL . 'includes/css/emp-embed-form-admin.css',
                                array(), EMP_FORM_VERSION );

            wp_enqueue_style( 'empformembed-admin' );

            if(get_post_type() == 'emp_form_embed_type') {

                wp_register_script( 'empformembed-validate-admin',
                                    EMP_FORM_URL.'/includes/css/plugins/jquery/validate.min.js',
                                    array(), EMP_FORM_VERSION );

                wp_enqueue_script( 'empformembed-validate-admin' );

                wp_register_script( 'empformembed-admin-js',
                                    EMP_FORM_URL.'includes/js/admin.js',
                                    array(), EMP_FORM_VERSION );

                wp_enqueue_script( 'empformembed-admin-js' );
            }
        }
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

        add_action( 'wp_enqueue_scripts', array($this, 'emp_form_embed_register_styles'));

        add_action( 'admin_enqueue_scripts', array( $this,'emp_form_embed_admin_styles' ) );

    }
}