<?php
/**
 * Plugin Name: Multistep EMP Form Embed
 * Plugin URI: http://www.liaisonedu.com/
 * Description: Embeds EMP forms into your WordPress pages.
 * Version: 1.0.2
 * Author: XYZ
 * Author URI: http://www.xyz.com
 * Text Domain: empforwp
 * Domain Path: languages
 * 
 * @package New EMP Form Embed
 * @category Core
 * @author XYZ
 */

/**
 * Define Some needed predefined variables
 * 
 * @package New EMP Form Embed
 *  
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if( !defined( 'EMP_FORM_VERSION' ) ) {
    define( 'EMP_FORM_VERSION', time() ); // plugin version
}

if( !defined( 'EMP_FORM_DIR' ) ) {
	define( 'EMP_FORM_DIR', dirname( __FILE__ ) ); // plugin dir
}
if(!defined('EMP_FORM_TEXT_DOMAIN')) { //check if variable is not defined previous then define it
	define('EMP_FORM_TEXT_DOMAIN','empforwp'); //this is for multi language support in plugin
}
if(!defined('EMP_FORM_URL')) {
	define('EMP_FORM_URL',plugin_dir_url( __FILE__ ) ); // plugin url
}
if( !defined( 'EMP_FORM_PLUGIN_BASENAME' ) ) {
	define( 'EMP_FORM_PLUGIN_BASENAME', basename( EMP_FORM_DIR ) ); //Plugin base name
}

if( !defined( 'EMP_FORM_POST_TYPE' ) ) {
    define('EMP_FORM_POST_TYPE', 'emp_form_embed_type'); // custom post type's slug
}

define('EMP_API_URL', 			'https://www.spectrumemp.com/api/');
define('EMP_REQUIREMENTS_URL', 	EMP_API_URL . 'inquiry_form/requirements');
define('EMP_SUBMIT_URL', 		EMP_API_URL . 'inquiry_form/submit');
define('EMP_CLIENT_RULES_URL', 	EMP_API_URL . 'field_rules/client_rules');
define('EMP_FIELD_OPTIONS_URL', EMP_API_URL . 'field_rules/field_options');
define('EMP_FORM_SOURCE',     EMP_API_URL . 'forms/submittable');

/**
 * Load Text Domain
 * 
 * This gets the plugin ready for translation.
 * 
 * @package New EMP Form Embed
 * @since 1.0.0
 */
function emp_form_load_textdomain() {
	
 // Set filter for plugin's languages directory
	$ww_cpt_lang_dir	= dirname( plugin_basename( __FILE__ ) ) . '/languages/';
	$ww_cpt_lang_dir	= apply_filters( 'emp_form_languages_directory', $ww_cpt_lang_dir );
	
	// Traditional WordPress plugin locale filter
	$locale	= apply_filters( 'plugin_locale',  get_locale(), 'empforwp' );
	$mofile	= sprintf( '%1$s-%2$s.mo', 'wwcpt', $locale );
	
	// Setup paths to current locale file
	$mofile_local	= $ww_cpt_lang_dir . $mofile;
	$mofile_global	= WP_LANG_DIR . '/' . EMP_FORM_PLUGIN_BASENAME . '/' . $mofile;
	
	if ( file_exists( $mofile_global ) ) { // Look in global /wp-content/languages/wp-custom-post-type folder
		load_textdomain( 'empforwp', $mofile_global );
	} elseif ( file_exists( $mofile_local ) ) { // Look in local /wp-content/plugins/wp-custom-post-type/languages/ folder
		load_textdomain( 'empforwp', $mofile_local );
	} else { // Load the default language files
		load_plugin_textdomain( 'empforwp', false, $ww_cpt_lang_dir );
	}
  
}
/**
 * Plugin Activation hook
 * 
 * This hook will call when plugin will activate
 * 
 * @package New EMP Form Embed
 */

register_activation_hook( __FILE__, 'emp_form_install' );

function emp_form_install() {
	
	global $wpdb;
	
	//register custom post type
    emp_form_register_post_types();

	//Need to call when custom post type is being used in plugin
	flush_rewrite_rules();
}




/**
 * Plugin Deactivation hook
 * 
 * This hook will call when plugin will deactivate
 * 
 * @package New EMP Form Embed
 * 
 */

register_deactivation_hook( __FILE__, 'emp_form_uninstall' );

function emp_form_uninstall() {
	
	global $wpdb;
	
}
/**
 * Load Plugin
 * 
 * Handles to load plugin after
 * dependent plugin is loaded
 * successfully
 * 
 * @package New EMP Form Embed
 * @since 1.0.0
 */
function emp_form_plugin_loaded() {
 
	// load first plugin text domain
    emp_form_load_textdomain();
}

//add action to load plugin
add_action( 'plugins_loaded', 'emp_form_plugin_loaded' );


/**
 * Global Variables
 *
 * Declaration of some needed global varibals for plugin
 *
 * @package New EMP Form Embed
 * @since 1.0.0
 */
global $emp_embed_form_model, $emp_embed_form_scripts, $emp_embed_form_shortcode, $emp_embed_form_admin;


/**
 * Includes Class Files
 * 
 * @package New EMP Form Embed
 * 
 */

//includes post types file
include_once( EMP_FORM_DIR . '/includes/emp-custom-post-types.php');
include_once( EMP_FORM_DIR . '/includes/emp-custom-fields.php');
include_once( EMP_FORM_DIR . '/includes/emp-embed-form-misc-functions.php' );

// Manage model functions
include_once( EMP_FORM_DIR . '/includes/class-emp-embed-form-model.php' );
$emp_embed_form_model = new Emp_Embed_form_Model();

// Handle script functionality at admin as well as public side
include_once( EMP_FORM_DIR . '/includes/class-emp-embed-form-scripts.php' );
$emp_embed_form_scripts = new Emp_Embed_form_Scripts();
$emp_embed_form_scripts->add_hooks();

//includes admin class file
include_once ( EMP_FORM_DIR . '/includes/admin/class-emp-embed-form-admin.php');
$emp_embed_form_admin = new Emp_Embed_form_Admin();
$emp_embed_form_admin->add_hooks();

// Manage plugin shortcodes functinality
include_once( EMP_FORM_DIR . '/includes/class-emp-embed-form-shortcodes.php' );
$emp_embed_form_shortcode = new Emp_Embed_form_Shortcodes();
$emp_embed_form_shortcode->add_hooks();

// Handles public side functionalities
include_once( EMP_FORM_DIR . '/includes/class-emp-embed-form-public.php' );
$emp_embed_form_public = new Emp_Embed_form_Public();
$emp_embed_form_public->add_hooks();

/*plugin effected admin list of EMP Forums*/

add_filter('manage_edit-emp_form_embed_type_columns', 'my_columns_embed_form_list');
function my_columns_embed_form_list($columns) {
    $columns['viewform'] = "<a class='cgc_ub_edit_badges'>" . __( 'Advance Edit', 'cgc_ub' ) . "</a>";
    $columns['viewform1'] = "<a class='cgc_ub_edit_badges'>" . __( 'QSP Form', 'cgc_ub' ) . "</a>";
    $columns['viewform2'] = "<a class='cgc_ub_edit_badges'>" . __( 'Form ID', 'cgc_ub' ) . "</a>";
    return $columns;
}

add_action('manage_emp_form_embed_type_posts_custom_column', 'my_show_columns_embed_form_list');
function my_show_columns_embed_form_list($name) {
    global $post,$wpdb;

    switch ($name) {
        case 'viewform':
            if ($post->post_type == 'emp_form_embed_type') {
                echo '<a href="post.php?action=edit&post=' . "$post->ID" . '&ae=1" title="" >Advanced Edit</a>';
            }
            break;

        case 'viewform1':
            if ($post->post_type == 'emp_form_embed_type') {
                echo '<a href="post.php?action=edit&post=' . "$post->ID" . '&qsp=1" title="" >Set QSP Para</a>';
            }
            break;

        case 'viewform2';
            echo $post->ID;
            break;
    }
}

//   2 Nov 2017 --  for add QSP field in admin
add_action('admin_enqueue_scripts', 'my_admin_script');
function my_admin_script() {
    echo '<script type="text/javascript">
       function remove_qsp(e){
            e.parentNode.parentNode.nextSibling.remove();  
            e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
         }
     </script>';
}

function save_page_meta( $post_id, $post, $update ) {

    $post_type = get_post_type($post_id);

    if ( "page" != $post_type ) return;

    $data=$post->post_content;
    $data=strstr($data,'emp_form_embed pid');
    $arr = explode("]", $data, 2);
    $first = $arr[0];
    preg_match('/\d+/', $first, $matches);
    update_post_meta($post_id, 'emp_form_embed', $matches[0]);

}
add_action( 'save_post', 'save_page_meta', 10, 3 );


add_action('wp_enqueue_scripts','jquey_load_init');
function jquey_load_init() {
    wp_enqueue_script( 'jqueryjs', plugins_url( '/includes/js/jquery.js', __FILE__ ),'false','1.12.4');
    wp_enqueue_script( 'jquerymigrate', plugins_url( '/includes/js/jquery-migrate.min.js', __FILE__ ),'false','1.4.1');
}

?>