<?php

/**
 * Add meta tag for disable input zoom into safari or iphone
 *
 * @package New EMP Form Embed
 * @since 1.0.0
 */

add_action( 'wp_head', 'add_viewport_meta_tag' );
function add_viewport_meta_tag() {
    echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=0"/>';
}

/**
 * Get client and api id from post meta
 *
 * @package New EMP Form Embed
 * @since 1.0.0
 */
function emp_form_embed_get_form_custom_field($pid, $field) {
    $value = get_post_meta( $pid, $field, true );
    $value = ($value ? $value : false);
    return $value;
}



/**
 * Generate from using api key
 *
 * @package New EMP Form Embed
 * @since 1.0.0
 */

function getFormFromSpectrumEMPAPICall($spectrum_emp_api_key, $spectrum_emp_form_id, $spectrum_emp_source_id) {

    global $shortCodeId;

    $html           = '';
    $modals         = array();
    $phone_fields   = array();

    $ch = curl_init(EMP_REQUIREMENTS_URL . '?IQS-API-KEY=' . $spectrum_emp_api_key. '&formID=' . $spectrum_emp_form_id. '&SOURCE='.$spectrum_emp_source_id );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $raw_html = curl_exec($ch);
    $curl_errno = curl_errno($ch);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if( $curl_errno > 0 ) {

        $html = '<div class="alert alert-danger">
                Error ' . $curl_errno . ', please try again.
            </div>';

        return array('html' => $html, 'modals' => $modals);
    }

    $json = json_decode($raw_html);

    //echo '<pre>';
   // print_R( $json->data);exit;


    if( !isset( $json->data ) || !isset( $json->data->sections )) {

        $html = '<div class="alert alert-danger">
                    Error, please try again.
                </div>';
        return array('html' => $html, 'modals' => $modals);
    }

    $html .= '<div class="stepwizard">
    <div class="stepwizard-row setup-panel"></div>
</div><form id="form_example" class="form-horizontal" action="" method="post" >';

    $html .= '<div class="section">';

    /*$utm_campaign=isset($_GET['utm_campaign'])?$_GET['utm_campaign']:'';
    $utm_source=isset($_GET['utm_source'])?$_GET['utm_source']:'';
    $utm_medium=isset($_GET['utm_medium'])?$_GET['utm_medium']:'';
    $utm_content=isset($_GET['utm_content'])?$_GET['utm_content']:'';*/

    global $wpdb;

    $get_utm_field= $wpdb->get_results("SELECT * FROM wp_postmeta WHERE `post_id` = $shortCodeId AND meta_key = 'emp_form_embed_qsp'");

    $get_utm_field_id=json_decode($get_utm_field[0]->meta_value,true);

    if(empty($get_utm_field_id)) $get_utm_field_id = [];

    $meta = get_post_meta($shortCodeId);

    foreach( $json->data->sections as $section_index => $section ) {
        // echo '<pre>';
        //  print_r($section->fields);exit;

        foreach( $section->fields as $field_index => $field ) {

            $label = $field->displayName;
            $default = $field->default;

            if( $field->id == 6 ) { // Address Line 1
                $label = 'Address';

            } else if( $field->id == 7 ) { // Address Line 2
                $label = '';
            }

            if($field->id == '12') {
                $iconClass = 'fa fa-envelope';
            } else if($field->id == '6' || $field->id == '7') {
                $iconClass = 'fa fa-home';
            } else if($field->id == '10') {
                $iconClass = 'fa fa-area-chart';
            } else if($field->id == '8') {
                $iconClass = 'fa fa-building';
            } else if($field->id == '19357') {
                $iconClass = 'fa fa-calendar';
            } else if($field->id == '19368' || $field->id == '13616' || $field->id == '13488') {
                $iconClass = 'fa fa-university';
            } else if($field->id == '13614' || $field->id == '14114') {
                $iconClass = 'fa fa-tasks';
            } else if($field->id == '13') {
                $iconClass = 'fa fa-phone';
            } else {
                $iconClass= 'fa fa-user fa';
            }

            $fieldName = 'emp_form_embed_'.$field->id;

            $fieldDefaultValue = isset($meta[$fieldName.'_default']) ? (is_array($meta[$fieldName.'_default']) ? implode(',', $meta[$fieldName.'_default']) : $meta[$fieldName.'_default']) : $field->default;

            if($meta[$fieldName.'_hide'][0] == '1') {
                $html .= '<div class=""><input type="hidden" name="'.$field->id.'" value="'.$fieldDefaultValue.'" id="'.$field->id.'" /></div>';
            }

            elseif( $field->htmlElement == 'input-text' ) {
                $class = '';
                if( stripos( $field->description, 'phone number' ) !== false ) {

                    $class          = ' iqs-form-phone-number';
                    $phone_fields[] = $field->id;

                } else {
                    $class = ' iqs-form-text';
                }

                if($field->displayName == 'DOB' || $field->displayName == 'US Date')  {
                    $class .= ' ids-form-dob';
                } else if($field->displayName == 'ACT Score') {
                    $class .= ' ids-form-act-score';
                } else if($field->displayName == 'URL') {
                    $class .= ' iqs-form-url';
                } else if($field->displayName == 'College Picker') {
                    $class .= ' iqs-form-picker';
                } else if($field->displayName == 'High School Picker') {
                    $class .= ' iqs-form-high-picker';
                } else if($field->displayName == 'GPA') {
                    $class .= ' iqs-form-gpa';
                } else if($field->displayName == 'SAT Score') {
                    $class .= ' iqs-form-sat';
                } else if($field->id == '12') {
                    $class .= ' check_by_email';
                }

                $field_data = '';
                global $wpdb;
                $field_data = $field->id;

                $result = $wpdb->get_results( "SELECT * FROM wp_postmeta WHERE `post_id` = $shortCodeId AND `meta_key` = 'emp_form_embed_".$field_data."' ");

                $result1=$wpdb->get_results( "SELECT * FROM wp_postmeta WHERE `post_id` = $shortCodeId AND `meta_key` = 'emp_form_embed_".$field_data."_hide'");
                $result3=$wpdb->get_results( "SELECT * FROM wp_postmeta WHERE `post_id` = $shortCodeId AND `meta_key` = 'emp_form_embed_".$field_data."_default'");
                $result2=$wpdb->get_results( "SELECT * FROM wp_postmeta WHERE `post_id` = $shortCodeId AND `meta_key` = 'emp_form_embed_up_pros'");

                if($result[0]->meta_value){$field->displayName = $result[0]->meta_value;}

                if($result1[0]->meta_value){$field->hidden = '1';}

                if($result2[0]->meta_value == 'on'){
                    $user_prospect_update=1;
                }else{
                    $user_prospect_update=0;

                }

                $default_value='';
                if($result3[0]->meta_value){
                    $default_value=$result3[0]->meta_value;
                }

                //if(!strpos($class, 'iqs-form-phone-number')) {
                    $astrike = (isset($field->required) && $field->required == 1) ? "<span class='input-group-addon'><i class='fa fa-asterisk fa-1' style='font-size:10px' aria-hidden='true'></i></span>" : "" ;    
                //} else {
                    //$astrike = (isset($field->required) && $field->required == 1) ? "<span class=''><i class='fa fa-asterisk fa-1' style='font-size:10px' aria-hidden='true'></i></span>" : "" ;
                //}
                

                //$hide= '';
                //$hide = ($field->hidden == '1') ? "hide_check_field" : "" ;


                $html .= '
                <div class="form-group"> 
                    <div class=" ">
                        <div class="text-left input-group"  >
                            <span class="input-group-addon"><i class="'.$iconClass.'" aria-hidden="true"></i></span>
                            <input type="text" tabindex="1" value="'.$default_value.'" name="' . $field->id . '"
                                id="' . $field->id . '"
                                class="form-control' . ((isset($field->required) && $field->required == 1) ? ' required' : '') . $class . '"
                                placeholder="' . $field->displayName . '" '.((isset($field->required) && $field->required == 1) ? "required" : "").' >
                                '.$astrike.'
                                 </div>';

                if( $class == ' iqs-form-phone-number' && isset( $section->fields[$field_index + 1] )
                    && ( $section->fields[$field_index]->order + 0.1 ) == $section->fields[$field_index + 1]->order )
                {
                    $element_id     = $section->fields[$field_index + 1]->id;
                    $label_text     = trim($section->fields[$field_index + 1]->displayName);
                    $opt_in_text    = '<a href="#text-message-opt-in-modal" class="blue" data-toggle="modal">opt-in policy</a>';
                    $label_text = str_ireplace('opt-in policy', $opt_in_text, $label_text);

                    $modals[] = '
                                        <div id="text-message-opt-in-modal" class="modal fade">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title">Text Message Opt-in Policy</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                         ' . $section->fields[$field_index + 1]->helpText . '
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';

                    $html .= '<div class=""><input type="checkbox" name="' . $element_id . '" id="' . $element_id . '">&nbsp;' . $label_text.'</div>';
                }


                if ($field->helpText !== '') {
                    $html .= '<p class="help-block">' . $field->helpText . '</p>';
                }
                $html .= '</div><span class="custom-error" style="display:none; float: left;">Please enter valid data.</span></div><!-- end class="form-group" -->';

            }
            elseif ($field->htmlElement == 'select' || $field->htmlElement == 'select-multiple')
            {
                $astrike = (isset($field->required) && $field->required == 1) ? "<span class='input-group-addon'><i class='fa fa-asterisk fa-1' style='font-size:10px' aria-hidden='true'></i></span>" : "" ;
                $class          = ' iqs-form-single-select input-sm';
                $iconClass = 'fa fa-list-ul';
                $multiple       = '';
                $name           = $field->id;
                $blankOption    = '<option value="">Please Select '.$label.'</option>';

                $require =        (isset($field->required) && $field->required == 1) ? ' required' : '';

                if( $field->htmlElement == 'select-multiple' ) {

                    $multiple       = 'multiple';
                    $name           = $field->id.'[]';
                    $class          = ' iqs-form-multi-select';
                    $blankOption    = '';
                    $require =        (isset($field->required) && $field->required == 1) ? ' required' : '';
                }
                elseif($field->displayName == 'Programs') {
                    $class .= ' programs_select_id';
                } elseif($field->displayName == 'Entry Year') {
                    $class .= ' programs_select_year';
                }

                $html .= '
                    <div class="form-group">
                       <div class="input-group">
                            <span class="input-group-addon"><i class="'.$iconClass.'" aria-hidden="true"></i></span>
                            <select '.$multiple.'
                                name="' . $name . '"
                                id="' . $field->id . '"
                                tabindex="1"
                                 
                                '.$require.' 
                                class="form-control' . ((isset($field->required) && $field->required == 1) ? ' required' : '') . $class . '">
                                ';

                                $html .= '<option value="">--'.$field->displayName.'--</option>';
			                if ($field->id == 9) { // State
			                    $html .= '<option value="Outside US & Canada">Outside US & Canada</option>';
			                }

			                foreach ($field->options as $option) {
			                    if (isset($option->options)) {
			                        $html .= '<optgroup label="' . $option->label . '">';

			                        foreach ($option->options as $sub_option) {
			                            $html .= '<option value="' . $sub_option->id . '">' .
			                                $sub_option->value . '
			                                                      </option>';
			                        }

			                        $html .= '</optgroup>';

			                    } else {
			                        $select = "";
			                        if($default == $option->id)
			                        {
			                            $select = "selected";
			                        }
			                        $html .= '<option '.$select.' value="' . $option->id . '">' .
			                            $option->value . ' </option>';
			                    }
			                }
		                $html .=
		                    '</select>
	                            '.$astrike.'
                        </div>'.
		                    (($field->helpText !== '') ? '<p class="help-block">' . $field->helpText . '</p>' : '').'
                    <span class="custom-error" style="display:none;float: left;">Please enter valid data.</span></div>';

            }
            elseif($field->htmlElement == 'input-checkbox')
            {
                if(count($field->options)>0)
                {
                    $class = ' iqs-form-checkbox';
                    if($field->required == 1) {
                        $class .= ' required_checkbox ';
                    }
                    $html .= '
                        <div class="form-group text-left">
                            <label for="' . $field->id . '" class="control-label iqs-form-checkbox">' .
                        $label . (($field->required == 1) ? ' <span class="asterisk">*</span>' : '') . '
                            </label>';

                    foreach ($field->options as $option) {
                        if(isset($fieldDefaultValue) && !empty($fieldDefaultValue)) {
                            $field->default = $fieldDefaultValue;
                        }
	                    $defaultOption = explode(",",$field->default);
	                    $selected = "";
	                    if(in_array($option->id,$defaultOption))
	                    {
							$selected = " checked ";
	                    }

                        $html .='<div class="checkbox"><label class="checkbox">
                                    <input type="checkbox" 
                                           class="' . $class . '" 
                                           name="'.$field->id.'[]" 
                                           value="'.$option->id.'" '.$selected.'>'.$option->value.'
                                </label></div>';
                    }
                    $html .='<span class="custom-error" style="display:none;float: left;">Please select at least one checkbox.</span></div>';
                }
            }
            elseif($field->htmlElement == 'input-radio')
            {

                $class = ' iqs-form-radio';
                $html .= '
                    <div class="form-group text-left">
                        <label for="' . $field->id . '" >' .
                    $label . (($field->required == 1) ? ' <span class="asterisk">*</span>' : '') . '
                        </label>';
                foreach ($field->options as $option) {
                    if(isset($fieldDefaultValue) && !empty($fieldDefaultValue)) {
                        $field->default = $fieldDefaultValue;
                    }
	                $defaultOption = explode(",",$field->default);
	                $selected = "";
	                if(in_array($option->id,$defaultOption))
	                {
		                $selected = " checked ";
	                }
                    $html .='
                                    <div class="radio"><label class="radio">
                                        <input type="radio" 
                                               class="' . (($field->required == 1) ? ' required' : '') . $class . '"
                                               name="'.$field->id.'" 
                                               value="'.$option->id.'" '.$selected.'>'.$option->value.'
                                    </label></div>';
                }
                $html .='<span class="custom-error" style="display:none;float: left;">Please enter valid data.</span></div>';
            } elseif ($field->htmlElement == "dob-selector") {

                $astrike = (isset($field->required) && $field->required == 1) ? "<span class='input-group-addon'><i class='fa fa-asterisk fa-1' style='font-size:10px' aria-hidden='true'></i></span>" : "" ;

                $class = ' iqs-form-text datepicker';
                $html .= '<div class="form-group">
                
                <div class="input-group text-left">
                        <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>';
                
                    $html .='<input type="text" class="form-control ' . $class . '" name="'.$field->id.'" value="'.$field->default.'" placeholder="'.$field->displayName.'" '.(($field->required == 1) ? ' required="" ' : '').'>'.$astrike;

                
                $html .='</div><span class="custom-error" style="display:none;float: left;">Please enter valid data.</span></div>';
            }
        }
    }
    $html .= '</div>';

    foreach ($get_utm_field_id as $val) {

        /*$data = array_keys($val);

        if($val['emp_form_embed_qsp_name']== 'utm_content')
        {
            $value=$utm_content;
        }
        else if($val['emp_form_embed_qsp_name']== 'utm_source')
        {
            $value=$utm_source;
        }
        else if($val['emp_form_embed_qsp_name']== 'utm_medium')
        {
            $value=$utm_medium;
        }
        else if($val['emp_form_embed_qsp_name']== 'utm_campaign')
        {
            $value=$utm_campaign;
        }*/
      //  $utm_content=isset($_GET['utm_content'])?$_GET['utm_content']:'';

        if(isset($_GET[$val['emp_form_embed_qsp_name']]) || isset($_COOKIE[$val['emp_form_embed_qsp_name']]))
        {
            $value = $_COOKIE[$val['emp_form_embed_qsp_name']];
            if(isset($_GET[$val['emp_form_embed_qsp_name']]))
            {
                $value = $_GET[$val['emp_form_embed_qsp_name']];
            }
            $html .='<input type="hidden" name="'.$val['emp_form_embed_emp_field_id'].'" value="'. $value .'"  size="30">';
        }
    }

    if($get_utm_field_id['emp_form_embed_emp_field_id'] && isset($_COOKIE['__utmz']))
    {
        $html .='<input type="hidden" name="'.$get_utm_field_id['emp_form_embed_emp_field_id'].'" value="'. $_COOKIE['__utmz'] .'"  size="30">';
    }



    $html .=   ' <input type="hidden" id="UPDATE-EXISTING-PROSPECTS" name="UPDATE-EXISTING-PROSPECTS" value="'.$user_prospect_update.'"/>
        <input type="hidden" id="form_submit" name="form_submit" value="form_example"  />
		<input type="hidden" id="phone_fields" name="phone_fields" value="' . implode(',', $phone_fields) . '" />
		<input type="hidden" id="SOURCE" name="SOURCE" value="' . $spectrum_emp_source_id . '" />
		<div class="clear"></div>
		<br />';


    $html .= '</form>';

    return array('html' => $html, 'modals' => $modals ,'fields' => $json->data->sections);
}

