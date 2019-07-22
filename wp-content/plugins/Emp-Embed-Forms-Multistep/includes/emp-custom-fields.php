<?php
/**
 * Custom Fields
 */
/*$pid = $_REQUEST['post'];
require_once('emp-embed-form-misc-functions.php');
require_once('config.php');*/




function emp_form_embed_add_meta_box() {

    add_meta_box(
        'emp_form_embed_meta_box', // $id
        'EMP Form Settings', // $title
        'emp_form_embed_show_meta_box', // $callback
        'emp_form_embed_type', // $page
        'normal', // $context
        'high' // $priority
    );
}
//Meta fields Array
$prefix         = 'emp_form_embed_';


 
function getCustomFields($pid,$EMPAPIKey,$EMPFormID) {
    require_once('emp-embed-form-misc-functions.php');

    global $prefix;
    $customFields_API = getFormFromSpectrumEMPAPICall($EMPAPIKey,$EMPFormID,null);
    //$customFields_field=$customFields_API['fields'][0]->fields;
    foreach ($customFields_API['fields'] as $customFields_field)
    {
        foreach($customFields_field->fields as $cust_field) {
            $customFields[] = array('label' => $cust_field->displayName,
                'hidden' => $cust_field->hidden,
                'required' =>  $cust_field->required,
                'default' => $cust_field->default,
                'desc'=>$cust_field->description ,
                'id'=>$cust_field->id,
                'name'=>'emp_form_embed_'.$cust_field->id,
                'type'=>$cust_field->htmlElement,
                'placeholder'=>$cust_field->displayName,
                'options' =>json_decode(json_encode($cust_field->options),true),
            );

        }

    }

    
    return $customFields;

}

function getFormList($api_key) {
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

    //$return['status'] = (isset($json->status) && $json->status == 'success') ? 1 : 0;
    //$return['response'] = (isset($json->message)) ? $json->message : '';
    $return = (isset($json->data)) ? (array) $json->data : [];

    return $return;
}


if($_GET['ae'] == 1  ) {

    $pid= $_REQUEST['post'];
    require_once('emp-embed-form-misc-functions.php');
    require_once('config.php');
    $customFields = getCustomFields($pid,$config['SpectrumEMPAPIKey'],$config['SpectrumEMPFormID']);

}
elseif($_POST['ae'] == 1){

    $customFields = getCustomFields($_POST['pid'],$_POST['apiKEY'],$_POST['formID']);

}

elseif ($_GET['qsp'] == 1 || $_POST['qsp'] == 1 )
{

    $customFields =array(

        array( 'label'         => 'EMP Field Id',
            'desc'          => 'Enter the EMP Field Id for the EMP form.',
            'id'            => $prefix.'emp_field_id',
            'name'          => $prefix.'emp_field_id[]',
            'type'          => 'input-text',
            'placeholder'   => 'EMP Field Id'),
        array( 'label'         => 'QSP Name',
            'desc'          => 'Enter the QSP Name for the EMP form.',
            'id'            => $prefix.'qsp_name',
            'name'          => $prefix.'qsp_name[]',
            'type'          => 'text',
            'placeholder'   => 'QSP Name'),
        array(
            'value'  => 'Add QSP Field',
            'type'    => 'button',
            'class'   => 'button button-primary button-small',
            'id'      => 'addNewItem'
        )
    );

}
else{

    $customFields = array(
        array(
            'label'         => 'API Key',
            'desc'          => 'Enter the API Key for the EMP form.',
            'id'            => $prefix.'api_key',
            'name'            => $prefix.'api_key',
            'type'          => 'input-text',
            'placeholder'   => 'API Key'
        ),

        array(
            'label'         => 'Client ID',
            'desc'          => 'Enter the Client ID for the EMP form.',
            'id'            => $prefix.'client_id',
            'name'            => $prefix.'client_id',
            'type'          => 'input-text',
            'placeholder'   => 'Client ID'
        ),

        array(
            'label'         => 'Source ID',
            'desc'          => 'Enter the Source id.',
            'id'            => $prefix.'source_id',
            'name'          => $prefix.'source_id',
            'type'          => 'input-text',
            'placeholder'   => 'Source ID'
        ),



        array(
            'label'         => 'Form Source ID',
            'desc'          => 'Select the Form Source ID.',
            'id'            => $prefix.'form_source_id',
            'name'          => $prefix.'form_source_id',
            'type'          =>  'select',
            'placeholder'   => 'Form Source ID'
        ),

        array(
            'label'         => 'Active Dots Color',
            'desc'          => 'Enter the Active Dots Color.',
            'id'            => $prefix.'active_dots_color',
            'name'          => $prefix.'active_dots_color',
            'type'          => 'input-text',
            'placeholder'   => 'Active Dots Color'
        ),

        array(
            'label'         => 'Deactive Dots Color',
            'desc'          => 'Enter the Deactive Dots Color.',
            'id'            => $prefix.'deactive_dots_color',
            'name'          => $prefix.'deactive_dots_color',
            'type'          => 'input-text',
            'placeholder'   => 'Deactive Dots Color'
        ),

        array(
            'label'         => 'Button Color',
            'desc'          => 'Enter the Button Color.',
            'id'            => $prefix.'button_color',
            'name'            => $prefix.'button_color',
            'type'          => 'input-text',
            'placeholder'   => 'Button Color'
        ),

        array(
            'label'         => 'Button Text Color',
            'desc'          => 'Enter the Button Text Color.',
            'id'            => $prefix.'button_text_color',
            'name'            => $prefix.'button_text_color',
            'type'          => 'input-text',
            'placeholder'   => 'Button Text Color'
        ),
        array(
            'label'         => 'Button Text Style',
            'desc'          => 'Enter the Button Text Style.',
            'id'            => $prefix.'button_text_style',
            'name'          => $prefix.'button_text_style',
            'type'          => 'select',
            'options'       => Array(
                array(
                    'label'    => 'Normal',
                    'value'   => 'normal',
                    'id'   => 'normal',
                ),
                array(
                    'label'   => 'Italic',
                    'value'   => 'italic',
                    'id'   => 'italic'
                ),
                array(
                    'label'   => 'Oblique',
                    'value'   => 'oblique',
                    'id'   => 'oblique',
                ),
                array(
                    'label'   => 'Initial',
                    'value'   => 'initial',
                    'id'   => 'initial',
                ),
                array(
                    'label'   => 'Inherit',
                    'value'   => 'inherit',
                    'id'   => 'inherit'
                )
            ),
            'value'         => 'normal',
            'placeholder'   => 'Button Text Style'
        ),

        array(
            'label'         => 'Button Text Weight',
            'desc'          => 'Enter the Button Text Weight.',
            'id'            => $prefix.'button_text_weight',
            'name'          => $prefix.'button_text_weight',
            'type'          => 'select',
            'options'       => Array(
                array(
                    'label'    => 'Normal',
                    'id'   => 'normal',
                    'value'   => 'normal',
                ),
                array(
                    'label'   => 'Bold',
                    'id'   => 'bold',
                    'value'   => 'bold'
                ),
                array(
                    'label'   => 'Bolder',
                    'id'   => 'bolder',
                    'value'   => 'bolder',
                ),
                array(
                    'label'   => 'Lighter',
                    'id'   => 'lighter',
                    'value'   => 'lighter',
                ),

                array(
                    'label'   => 'Initial',
                    'id'   => 'initial',
                    'value'   => 'initial'
                ),
                array(
                    'label'   => 'Inherit',
                    'value'   => 'inherit',
                    'id'   => 'inherit',
                )
            ),
            'placeholder'   => 'Button Text Weight'
        ),

        array(
            'label'         => 'Button Title',
            'desc'          => 'Enter the Button Title.',
            'id'            => $prefix.'button_title',
            'name'            => $prefix.'button_title',
            'type'          => 'input-text',
            'placeholder'   => 'Button Title'
        ),

        array(
            'label'         => 'Display Number of Fields',
            'desc'          => 'Enter the Display Number of Fields',
            'id'            => $prefix.'fields_number',
            'name'            => $prefix.'fields_number',
            'type'          => 'input-text',
            'placeholder'   => 'Display Number of Fields'
        ),

        array(
            'label' => 'Display "Thank You" page in a new window',
            'id'    => $prefix.'new_tab',
            'name'    => $prefix.'new_tab',
            'type'  => 'checkbox',
        ),
        array(
            'label' => 'Update Existing Prospects',
            'id'    => $prefix.'up_pros',
            'name'    => $prefix.'up_pros',
            'type'  => 'checkbox',
        )
    );
}

if($_GET['action']=='edit' && (!isset($_REQUEST['ae']) && !isset($_REQUEST['qsp'])))
{
    //require_once 'config.php';
    require_once('emp-embed-form-misc-functions.php');
    $apiKey = emp_form_embed_get_form_custom_field( $_REQUEST['post'], 'emp_form_embed_api_key' );
    $formList = getFormList($apiKey);
    $formList = (array) $formList['sem_forms'];

}

add_action('add_meta_boxes', 'emp_form_embed_add_meta_box');

// Inline Content Callback
function emp_form_embed_show_meta_box() {

    global $customFields, $post,$config, $formList;
    // Use nonce for verification

    echo '<input type="hidden" name="emp_form_embed_meta_box" value="'.wp_create_nonce(basename(__FILE__)).'">';
    echo '<input type="hidden" name="emp_form_embed_post_type" id="emp_form_embed_post_type" value="'.get_post_type().'">';

    //begin the field table and loop

    echo '<table class="form-table">';

    if ((get_post_type($post->ID) == 'emp_form_embed_type') && (!isset($_GET['ae']) ) && (!isset($_GET['qsp']) )) {

        echo '<tr>
                <th>Shortcode</th>
                <td>[emp_form_embed pid="'.$post->ID.'"]</td>
              </tr>';
    }

   // echo '<pre>';
   // print_r($customFields);exit;

    foreach ($customFields as $field) {

        /*if($field['required']=='1')
        {
            $class='required';
        }else{
            $class='';

        }*/
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['name'], true);

        $meta_hide=get_post_meta($post->ID, $field['name'].'_hide', true);

        //echo $meta_hide."===".$field['hidden'];

        $meta_default=get_post_meta($post->ID, $field['name'].'_default', true);

        if($meta_default == "" && $field['default'] != "") {
            $meta_default = $field['default'];
        }

        if($meta_hide == "" && $field['hidden'] == "1") {
            $meta_hide = $field['hidden'];
        }

        if($_GET['qsp'] != 1 ) {
            if(!strpos($field['name'], 'opt-in')) {
                echo '<tr>
                    <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                  <td>';    
            }
            
        }
        switch ($field['type']) {

            case 'text-withreadonly':
                echo '<div class="form-group col-md-6">';
                echo '<input type="text"
                             name="'.$field['name'].'"
                             id="'.$field['id'].'"
                             placeholder= "'.$field['placeholder'].'"
                             value="'.$meta.'" 
                             readonly
                             size="30">
                             ';
                echo "</div>";
                break;
            //text
            case 'input-text':

                if(($_GET['qsp'] == '1' || $_POST['qsp'] == '1' ) && $field['id'] == 'emp_form_embed_emp_field_id') {

                    $meta1 = get_post_meta($post->ID, 'emp_form_embed_qsp', true);
                    $meta2 = json_decode($meta1, true);

                    if(empty($meta2)) $meta2 = [];

                    foreach ($meta2 as $val) {

                        $data = array_keys($val);

                        if (in_array("emp_form_embed_emp_field_id", $data) &&  !empty($val['emp_form_embed_emp_field_id']) ) {

                            echo '<tr><th><label for="EMP Field Id">EMP Field Id</label></th><td>';
	                        echo '<div class="form-group col-md-6">';
                            echo '<input type="text" name="emp_form_embed_emp_field_id[]" id="' . $val['emp_form_embed_emp_field_id'] . '"
                             value="' . $val['emp_form_embed_emp_field_id'] . '" size="30"></div>
                             <span class="description">Enter the EMP Field Id for the EMP form.</span></td>
                             <td><input type="button" class="button button-primary button-small" id="qsp_cancel" onclick="remove_qsp(this)" value="DELETE"></td></tr>';
                        }

                        if (in_array("emp_form_embed_qsp_name", $data) &&   !empty($val['emp_form_embed_qsp_name']) ) {
                            echo '<tr>
                                                <th><label for="QSP Name">QSP Name</label></th>
                                                <td>';
	                        echo '<div class="form-group col-md-6">';
                            echo '<input type="text" name="emp_form_embed_qsp_name[]" id="' . $val['emp_form_embed_qsp_name'] . '"
                             value="' . $val['emp_form_embed_qsp_name'] . '" size="30"></div> 
                             <span class="description">Enter the QSP Name for the EMP form.</span></td></tr>';
                        }
                    }
                }
                if($_GET['qsp'] !=1 ){
                    $min_length = "";
                    if($field['id'] == "emp_form_embed_primary_phone")
                    {
                       $min_length = ' minlength="10" ';
                    }
	                echo '<div class="row"><div class="form-group col-md-6">';
                    echo '<input type="text" 
                             name="'.$field['name'].'"
                             id="'.$field['id'].'"
                             placeholder= "'.$field['placeholder'].'"
                             value="'.$meta.'" 
                             class="form-control"
                             size="30">';

                    //echo  '<span class="description">'.$field['desc'].'</span>';
	                echo '</div></div>';

                    if($_GET['ae']=='1')
                    {
	                    echo '<div class="row"><div class="form-group col-md-6">';
                        echo
                            '<input type="text" '.$min_length.' 
                            class="form-control"
                             name="'.$field['name'].'_default"
                             id="'.$field['id'].'_default"
                             placeholder= "'.$field['placeholder'].'"
                             value="'.$meta_default.'" 
                             size="30"><br><b><span class="description"> Default '.$field['placeholder'].'</span></b></div></div>';
                    }

                }
                break;

            case 'textarea':
	            echo '<div class="row"><div class="form-group col-md-6">';
                echo '<textarea name="'.$field['name'].'_default" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea></div></div>';
                break;

            // checkbox
            case 'input-checkbox':
                if(count($field['options'])>0)
                {
                    $defaultOption = explode(',',$meta_default);
                    foreach ($field['options'] as $val )
                    {
                        echo ' <p><input type="checkbox" value="'.$val['id'].'" name="'.$field['name'].'_default[]" 
                             id="'.$field['id'].'" ',in_array($val['id'], $defaultOption) ? ' checked="checked"' : '','/>
					        '.$val['value'].'</p>';
                    }
                }
                break;

            // checkbox
            case 'checkbox':
                echo '<input type="checkbox" name="'.$field['name'].'" 
                             id="'.$field['name'].'" ',$meta ? ' checked="checked"' : '','/>
                            <label for="'.$field['id'].'">'.$field['desc'].'</label>';
                break;

	        // radio
	        case 'input-radio':
		        if(count($field['options'])>0)
		        {
			        $defaultOption = explode(',',$meta_default);
			        foreach ($field['options'] as $val )
			        {
				        echo ' <p><input type="radio" value="'.$val['id'].'" name="'.$field['name'].'_default" 
                             id="'.$field['id'].'" ',in_array($val['id'], $defaultOption) ? ' checked="checked"' : '','/>
					        '.$val['value'].'</p>';
			        }
		        }
		        break;

            // select
            case 'select':
                //  echo '<select required="'.$class.'" name="'.$field['id'].'" id="'.$field['id'].'" width=200>';
	            echo '<div class="row"><div class="form-group col-md-6">';
                if($field['id']=='emp_form_embed_state')
                {
                    echo '<select name="' . $field['name'] . '_default" id="' . $field['id'] . '" class="form-control" required="'.$class.'">';
                    echo '<option value="Outside US & Canada">Outside US & Canada</option>';

                }
                elseif($field['id'] == 'emp_form_embed_form_source_id') {
                    echo '<select name="' . $field['name'] . '" id="' . $field['id'] . '" class="form-control" required="'.$class.'">';

                    if(is_array($formList) && count($formList) > 0) {
                        foreach($formList AS $key => $value) {
                            if($value == $meta)
                                echo '<option value="'.$value.'" selected="selected">'.$key.' '.$value.'</option>';
                            else
                                echo '<option value="'.$value.'">'.$key.' '.$value.'</option>';
                        }
                    }
                    echo '</select>';
                }
                else
                {
                    echo '<select name="' . $field['name'] . '_default" id="' . $field['id'] . '"  class="form-control">';
                    foreach ($field['options'] as $option) {
                        
                        if($field['id'] != "emp_form_embed_entry_year" && $field['id'] != "emp_form_embed_gender" && $field['id'] != "emp_form_embed_country" && $field['id'] != "emp_form_embed_approximately_how_much_do_you_spend_on_digital_marketing_each_year?")
                        {
                            ?>
                            <option <?php if($meta_default == $option['value']) echo "selected"; ?> value="<?php echo $option['id']; ?>"><?php echo $option['value']; ?></option>
                            <?php
                        }
                        else
                        {
                            ?>
                            <option <?php if($meta_default == $option['value']) echo "selected"; ?> value="<?php echo $option['id']; ?>"><?php echo $option['value']; ?></option>
                            <?php
                        }

                    }
                    echo '</select>';
                }
                echo "</div></div>";
                break;

            case 'button';

                echo '<th><input type="button" value="'.$field['value'].'"  class="'.$field['class'].'" id="'.$field['id'].'"></th>';
                break;

            case 'dob-selector':
                echo '<div class="row"><div class="form-group col-md-6"><div class="input-group text-left"><span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>';
                echo '<input type="text" 
                             name="'.$field['name'].'"
                             id="'.$field['id'].'"
                             placeholder= "'.$field['placeholder'].'"
                             value="'.$meta.'" 
                             class="form-control datepicker"
                             size="30" ></div></div></div>';
            break;
        }

        if ($_GET['ae'] == 1) {
            if(!strpos($field['name'], 'opt-in')) {
                echo '<div class="row hidden_field"><input type="checkbox" value="1"  name="'.$field['name'].'_hide" class="" id="'.$field['name'].'_hide" ',($meta_hide) ? ' checked="checked"' : '','/>&nbsp;<label for="'.$field['id'].'_hide">Hide '.$field['placeholder'].' </label></div>';    
            }
            
            echo '</td></tr>';
        }
    }
    echo '</table>';
	echo '<input type="hidden" value="'.$_GET["qsp"].'" name="qsp">';
	echo  '<input type="hidden" value="'.$_GET["ae"].'" name="ae">';
	echo '<input type="hidden" value="'.$_REQUEST["post"].'" name="qp">';
	echo '<input type="hidden" value="'.$config['SpectrumEMPAPIKey'].'" name="apiKEY">';
	echo '<input type="hidden" value="'.$config['SpectrumEMPFormID'].'" name="formID">';
}

//save the data
function emp_form_embed_save_custom_meta($post_id) {

    global $customFields, $error;


    if ($_POST['ae'] == 1) {

        $pid=$post_id;
        $customFields_api = getCustomFields($pid,$_POST['apiKEY'],$_POST['formID']);

        $arr=[];
        foreach ($customFields_api as $field_hide) {
            $arr[] = array('id'=>$field_hide['id'].'_default','name'=>$field_hide['id'].'_default');
        }

        $customFields= array_merge($customFields_api,$arr);

    }

    //varify nonce
    if(!wp_verify_nonce($_POST['emp_form_embed_meta_box'], basename(__FILE__)))
        return $post_id;

    //check autosave
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;

    //check permission
    if('page' == $_POST['post_type']) {
        if(!current_user_can('edit_page', $post_id))
            return $post_id;
        elseif (!current_user_can('edit_post', $post_id))
            return $post_id;
    }

    $error = '';

    $qspDatas = [];



    foreach ($customFields as $field) {

        if($_POST['qsp'] == 1) {
            if($field['id'] == 'emp_form_embed_emp_field_id' || $field['id'] == 'emp_form_embed_qsp_name' ) {
                $qspDatas[$field['id']] = $_POST[$field['id']];
            }
        }

        $old = get_post_meta($post_id, $field['name'],true);

        if(isset($_POST[$field['name'].'_hide'])) {
            update_post_meta($post_id, $field['name'].'_hide', $_POST[$field['name'].'_hide']);
        } else {
            update_post_meta($post_id, $field['name'].'_hide', 0);
            //delete_post_meta($post_id, $field['name'].'_hide', $_POST[$field['name'].'_hide']);
        }

        if(isset($_POST[$field['name'].'_default'])) {

            $defaultValue = $_POST[$field['name'].'_default'];

            //var_dump($defaultValue, $_POST);exit;

            if(is_array($defaultValue)) {
              $defaultValue = implode(',', $defaultValue);
            } elseif(empty($defaultValue)) {
                delete_post_meta($post_id, $field['name'].'_default');    
            }
            
            update_post_meta($post_id, $field['name'].'_default', $defaultValue);
        } else {
            delete_post_meta($post_id, $field['name'].'_default');
        }
            

        $new = $_POST[$field['name']];

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['name'], $new);
        } elseif ('' == $new && $new != $old) {
            delete_post_meta($post_id, $field['name'], $old);
        }
    }


    if($_POST['qsp'] == 1 ){

        $emp_id = get_post_meta($post_id, 'emp_form_embed_emp_field_id', true);

        $qsp_name = get_post_meta($post_id, 'emp_form_embed_qsp_name', true);

        $combined = array();

        foreach($emp_id as $index => $emp_id) {
            if(!array_key_exists($index, $qsp_name)) {
                throw OutOfBoundsException();
            }

            $combined[] = array(
                'emp_form_embed_emp_field_id'  => $emp_id,
                'emp_form_embed_qsp_name' => $qsp_name[$index]
            );
        }
        $qsp_array=json_encode($combined);

        update_post_meta($post_id, 'emp_form_embed_qsp', $qsp_array);

    }
}

add_action('save_post', 'emp_form_embed_save_custom_meta');

add_filter( 'redirect_post_location', 'embed_redirect_post_location', 100, 2);
/**
 * Redirect to the edit.php on post save or publish.
 */
function embed_redirect_post_location( $location, $post_id ) {
    if ('emp_form_embed_type' == get_post_type()) {
        if ( isset( $_POST['save'] ) || isset( $_POST['publish'] ) ) {
            if ($_POST['ae'] == 1) {
                $location = admin_url('post.php?action=edit&post='.$post_id.'&ae=1');
            } elseif ($_POST['qsp'] == 1) {
                $location = admin_url('post.php?action=edit&post='.$post_id.'&qsp=1');
            }
        }
    }
    return $location;
}
?>