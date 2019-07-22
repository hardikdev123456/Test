<?php

//get API Key
$api_key            = emp_form_embed_get_form_custom_field( $pid, 'emp_form_embed_api_key' );

//get Client ID
$client_id          = emp_form_embed_get_form_custom_field( $pid, 'emp_form_embed_client_id' );

//get Form Id
$form_id            = emp_form_embed_get_form_custom_field( $pid, 'emp_form_embed_form_source_id' );

//get Source ID
$source_id          = emp_form_embed_get_form_custom_field( $pid, 'emp_form_embed_source_id' );

//get Button Title
$button_title       = emp_form_embed_get_form_custom_field( $pid, 'emp_form_embed_button_title' );
$button_title       = !empty( $button_title ) ? $button_title : 'Save';

//get Number of display fields
$number_fields      = emp_form_embed_get_form_custom_field($pid, 'emp_form_embed_fields_number');
$number_fields      = !empty($number_fields) ? $number_fields : '5';

//get Button Color code
$button_color       = emp_form_embed_get_form_custom_field($pid, 'emp_form_embed_button_color');
$button_color       = !empty($button_color) ? $button_color : 'black';

//get Button text style
$button_text_style       = emp_form_embed_get_form_custom_field($pid, 'emp_form_embed_button_text_style_default');
$button_text_style       = !empty($button_text_style) ? $button_text_style : 'normal';

//get Button text weight
$button_text_weight      = emp_form_embed_get_form_custom_field($pid, 'emp_form_embed_button_text_weight_default');
$button_text_weight      = !empty($button_text_weight) ? $button_text_weight : 'normal';


//get Button Text color
$button_text_color  = emp_form_embed_get_form_custom_field($pid, 'emp_form_embed_button_text_color');
$button_text_color  = !empty($button_text_color) ? $button_text_color : 'white';

//get Active Dots color
$dot_active_color   = emp_form_embed_get_form_custom_field($pid, 'emp_form_embed_active_dots_color');
$dot_active_color   = !empty($dot_active_color) ? $dot_active_color : '#020005';

//get Deactive Dots Color
$dot_deactive_color = emp_form_embed_get_form_custom_field($pid, 'emp_form_embed_deactive_dots_color');
$dot_deactive_color = !empty($dot_deactive_color) ? $dot_deactive_color : '#a5a2a9';

$config['SpectrumEMPAPIKey']    = $api_key;
$config['SpectrumEMPClientID']  = $client_id;
$config['SpectrumEMPFormID']    = $form_id;
$config['SpectrumEMPSourceID']  = $source_id;
$config['ButtonTitle']          = $button_title;
$config['NumberOfFields']       = $number_fields;
$config['ButtonColor']          = $button_color;
$config['ButtonTextStyle']      = $button_text_style;
$config['ButtonTextWeight']      = $button_text_weight;
$config['ButtonTextColor']      = $button_text_color;
$config['DotActiveColor']       = $dot_active_color;
$config['DotDeactiveColor']     = $dot_deactive_color;
