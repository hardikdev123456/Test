<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Model Class
 *
 * Handles adding scripts functionality to the admin pages
 * as well as the front pages.
 *
 * @package New EMP Form Embed
 * @since 1.0.0
 */
class Emp_Embed_form_Model{
	
	public function __construct(){
		
	}
	
	/**
	 * Escape Tags & Slashes
	 *
	 * Handles escapping the slashes and tags
	 *
	 * @package New EMP Form Embed
	 * @since 1.0.0
	 */
	public function emp_embed_form_escape_attr( $data ) {
		return esc_attr( stripslashes($data) );
	}
	
	/**
	 * Strip Slashes From Array
	 *
	 * @package New EMP Form Embed
	 * @since 1.0.0
	 */
	public function emp_embed_form_escape_slashes_deep( $data = array(), $flag=false, $limited = false ) {
		
		if( $flag != true ) {
			$data = $this->emp_embed_form_nohtml_kses($data);
		} else {
			if( $limited == true ) {
				$data = wp_kses_post( $data );
			}
		}
		
		$data = stripslashes_deep($data);
		return $data;
	}
	
	/**
	 * Strip Html Tags 
	 * 
	 * It will sanitize text input (strip html tags, and escape characters)
	 * 
	 * @package New EMP Form Embed
	 * @since 1.0.0
	 */
	public function emp_embed_form_nohtml_kses($data = array()) {
		
		if ( is_array($data) ) {
			$data = array_map(array($this,'emp_embed_form_nohtml_kses'), $data);
		} elseif ( is_string( $data ) ) {
			$data = wp_filter_nohtml_kses($data);
		}
		return $data;
	}
	
	/**
	 * Convert Object To Array
	 *
	 * Converting Object Type Data To Array Type
	 * 
	 * @package New EMP Form Embed
 	 * @since 1.0.0
	 */
	public function emp_embed_form_object_to_array($result) {
		$array = array();
	    foreach ($result as $key=>$value)
	    {	
	        if (is_object($value))
	        {
	            $array[$key] = $this->emp_embed_form_object_to_array($value);
	        } else {
	        	$array[$key] = $value;
	        }
	    }
	    return $array;
	}
	
	/**
	 * Get Coupons Data
	 * 
	 * Handles get all coupons from database
	 * 
	 * @package New EMP Form Embed
 	 * @since 1.0.0
	 */
	public function emp_embed_form_get_emp( $args = array() ) {

		$data_res	= array();
		
		// Default argument
		$queryargs = array(
							'post_type' => EMP_FORM_POST_TYPE,
							'post_status' => 'publish'
						);
		
		$queryargs = wp_parse_args( $args, $queryargs );
		
		// Fire query in to table for retriving data
		$result = new WP_Query( $queryargs );
		
		//retrived data is in object format so assign that data to array for listing
		$postslist = $this->emp_embed_form_object_to_array($result->posts);
		
		$data_res['data'] 	= $postslist;
		
		//To get total count of post using "found_posts" and for users "total_users" parameter
		$data_res['total']	= isset( $result->found_posts ) ? $result->found_posts : '';

		return $data_res;
	}
} // close of model class