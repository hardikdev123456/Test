<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Public Class
 *
 * Handles adding public side functionality
 *
 * @package New EMP Form Embed
 * @since 1.0.0
 */
class Emp_Embed_form_Public
{

    public function __construct()
    {

    }

    function emp_form_embed_formhandler() {

        $return = array();

        $return['status'] = 0;
        $return['response'] = 'Undefined action';

        if (count($_GET) > 0) {
            foreach ($_GET as $key => $val) {
                if (get_magic_quotes_gpc()) {
                    $_GET[$key] = stripslashes($val);
                }

                $_GET[$key] = trim($val);
            }
        }

        if (count($_POST) > 0) {
            foreach ($_POST as $key => $val) {

                if(is_array($val) && count($val) > 0) {
                    $_POST[$key] = implode(",", $val);
                } else  {
                    $_POST[$key] = trim($val);
                }
                if (get_magic_quotes_gpc()) {
                    $_POST[$key] = stripslashes($val);
                }
            }
        }

        if (isset($_POST['form_submit'])) {

            switch ($_POST['form_submit']) {

                case 'form_example':

                    unset($_POST['form_submit']);

                    $pid     = $_POST['pid'];
                    $up_pros = $_POST['UPDATE-EXISTING-PROSPECTS'];
                    $pid     = intval($pid);
                    $api_key = emp_form_embed_get_form_custom_field($pid, 'emp_form_embed_api_key');
                    $new_tab = emp_form_embed_get_form_custom_field($pid, 'emp_form_embed_new_tab');
                    $up_pros = emp_form_embed_get_form_custom_field($pid, 'emp_form_embed_up_pros');
                    $form_id = emp_form_embed_get_form_custom_field($pid, 'emp_form_embed_form_source_id');

                    unset($_POST['pid']);

                    $_POST['IQS-API-KEY']   = $api_key;
                    $_POST['formID']        = $form_id;
                    $_POST['UPDATE-EXISTING-PROSPECTS'] =$up_pros;

                    $phone_fields = $_POST['phone_fields'];
                    $phone_fields = explode(',', $phone_fields);
                    unset($_POST['phone_fields']);

                    $html = '';

                    $post_vars = array();


                    foreach ($_POST as $k => $v) {

                        $values = explode(",", $v);
                        /* echo "<pre>";
                         print_r($values);*/

                        if(count($values) == 1 ) {
                            if (in_array($k, $phone_fields) && !empty($values[0])) {
                                $v = preg_replace('/[^0-9]/', '', $values[0]);
                                $v = '%2B1' . $v;   // append +1 for US, but + needs to be %2B for posting
                            }
                            // if this checkbox field is set then it was checked
                            if (stripos($k, '-text-opt-in') !== false) {
                                $v = '1';
                            }

                            // Remove backslashes if any exist
                            if (strpos($v, '\\') !== false) {
                                $v = stripslashes($values[0]);
                            }

                            // URL encode if spaces exist
                            if (strpos($v, ' ') !== false) {
                                $v = rawurlencode($values[0]);
                            }

                            $post_vars[] = $k . '=' . $v;

                        } else {
                            for ($i=0; $i < count($values) ;$i++) {
                                $post_vars[] = $k.'[]' . '=' . $values[$i];
                            }
                        }
                    }

                    $post_vars = implode('&', $post_vars);

                    $ch = curl_init(EMP_SUBMIT_URL);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vars);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    $raw_html = curl_exec($ch);
                    $curl_errno = curl_errno($ch);
                    $curl_error = curl_error($ch);
                    curl_close($ch);

                    $json = json_decode($raw_html);

                    $return['new_tab'] = $new_tab ? 1 : 0;
                    $return['status'] = (isset($json->status) && $json->status == 'success') ? 1 : 0;
                    $return['response'] = (isset($json->message)) ? $json->message : 'Something bad happened, please refresh the page and try again.';
                    $return['data'] = (isset($json->data)) ? $json->data : '';

                    break;

                default:

                    break;
            }
        }

        echo json_encode($return);

        die();
    }

    function wp_emp_sourceid_get_api() {

        if (isset($_POST['IQS-API-KEY'])) {
            $api_key = $_POST['IQS-API-KEY'];

            $url=EMP_FORM_SOURCE.'?IQS-API-KEY='.urlencode($api_key);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $raw_html = curl_exec($ch);
            $curl_errno = curl_errno($ch);
            $curl_error = curl_error($ch);
            curl_close($ch);

            $json = json_decode($raw_html);

            $return['status'] = (isset($json->status) && $json->status == 'success') ? 1 : 0;
            $return['response'] = (isset($json->message)) ? $json->message : '';
            $return['data'] = (isset($json->data)) ? $json->data : '';
        }
        echo json_encode($return);

        die();
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
        add_action('wp_ajax_emp_form_embed_formhandler', array($this,'emp_form_embed_formhandler' ));
        add_action('wp_ajax_nopriv_emp_form_embed_formhandler', array($this, 'emp_form_embed_formhandler' ));

        add_action('wp_ajax_wp_emp_sourceid_get_api', array($this, 'wp_emp_sourceid_get_api') );
        add_action('wp_ajax_nopriv_wp_emp_sourceid_get_api', array($this, 'wp_emp_sourceid_get_api') );
    }
}