<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Shortocde UI
 *
 * This is the code for the pop up editor, which shows up when an user clicks
 * on the icon within the WordPress editor.
 *
 * @package New EMP Form Embed
 * @since 1.0.0
 */
global $emp_embed_form_model;
?>

<div class="emp-embed-form-popup-content">

    <div class="emp-embed-form-header-popup">
        <div class="emp-embed-form-popup-header-title">
            <?php _e( 'Add a Shortcodes', 'empforwp' );?>
        </div>
        <div class="emp-embed-form-popup-close">
            <a href="javascript:void(0);" class="emp-embed-form-popup-close-button">
                <img src="<?php echo EMP_FORM_URL;?>includes/images/tb-close.png">
            </a>
        </div>
    </div>
    <div class="emp-embed-form-popup-error">
        <?php _e( 'Select a Shortcode', 'empforwp' );?>
    </div>
    <div class="ww-wpsc-popup-container">
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">
                    <label><?php _e( 'Select a EMP Form', 'wwwpsc' );?></label>
                </th>
                <td>
                    <select id="emp_embed_form_shortcode">
                        <option value=""><?php _e( '--Select EMP Form--', 'wpscm' );?></option>
                            <?php
                            $args=array(
                                'post_status' => 'publish',
                                'posts_per_page' => -1,
                            );

                            $wp_scm_data= $emp_embed_form_model->emp_embed_form_get_emp( $args );

                        foreach($wp_scm_data['data'] as $key => $value) { ?>

                            <option value="<?php echo $value['ID'] ?>">
                                <?php _e( $value['post_title'], 'wpscm' );?>
                            </option>
                            <?php
                        } ?>
                    </select>
                </td>
            </tr>
            </tbody>
        </table>
        <div id="emp_embed_form_insert_container" >
            <input type="button"
                   class="button-primary"
                   id="emp_embed_form_insert_shortcode"
                   value="<?php _e( 'Insert Shortcode', 'wwwpsc' ); ?>" >
        </div>
    </div>
</div><!--.emp-embed-form-popup-contentt-->
<div class="emp-embed-form-popup-overlay" ></div><!--.emp-embed-form-popup-overlay-->