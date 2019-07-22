<?php

require_once(EMP_FORM_DIR . '/includes/config.php');
$form = getFormFromSpectrumEMPAPICall($config['SpectrumEMPAPIKey'], $config['SpectrumEMPFormID'], $config['SpectrumEMPSourceID']);
?>

<style>
    <?php echo '#color_'.$pid ?> .btn-black {
        background-color: <?php echo $config['ButtonColor'] ?> !important;
        font-style: <?php echo $config['ButtonTextStyle']  ?> !important;
        font-weight: <?php echo $config['ButtonTextWeight']  ?>;
        color: <?php echo $config['ButtonTextColor']; ?> !important;
    }
    <?php echo '#color_'.$pid ?>  .emp-form .btn {
        color: <?php echo $config['ButtonTextColor'] ?> !important;
    }
    <?php echo '#color_'.$pid ?> .stepwizard .setup-panel .active-step.btn-primary {
        background-color: <?php echo $config['DotActiveColor'] ?> !important;
        border-color: <?php echo $config['DotActiveColor'] ?> !important;
    }
    <?php echo '#color_'.$pid ?> .stepwizard .setup-panel .active-step.btn-primary:hover {
        background-color: <?php echo $config['DotActiveColor'] ?> !important;
    }

    <?php echo '#color_'.$pid ?> .stepwizard .setup-panel .btn-default {
        background-color:  <?php echo $config['DotDeactiveColor'] ?> !important;
        border-color: <?php echo $config['DotDeactiveColor'] ?> !important;
    }
    <?php echo '#color_'.$pid ?> .stepwizard .setup-panel .btn-default:hover {
        background-color: <?php echo $config['DotDeactiveColor'] ?> !important;
    }
</style>

<!-- hide everything if javascript is disabled -->
<noscript>
    <style type="text/css">
        #body {
            display: none;
        }
        #javascript-disabled-message {
            width: 600px;
            margin: 0 auto;
            padding: 15px;
            text-align: left;
            margin-top: 220px;
            background: #e5e5e5;
        }
    </style>
</noscript>
<!-- end of EMP -->

<!-- inform the user that javascript is a required element to view this page -->
<noscript>
    <div id="javascript-disabled-message">
        <div class="page-header">
            <h1>Javascript is currently disabled...</h1>
        </div>
        <p>
            This page requires a browser feature called JavaScript. All modern browsers support JavaScript. You probably just
            need to change a setting in order to turn it on.
        </p>
        <p>
            Please see: <a href="http://www.google.com/support/bin/answer.py?answer=23852" target="_blank">How to enable
                JavaScript in your browser</a>.
        </p>
        <p>
            If you use ad-blocking software, it may require you to allow JavaScript from this site. Once you've enabled JavaScript
            you can <a href="/index.php/inquiryform">try loading this page again</a>.
        </p>
        <p>
            Thank you.
        </p>
    </div>
</noscript>

<div class="emp-form" id="<?php echo 'color_'.$pid ?>" data-pid="<?php echo $pid; // Post ID for EMP form ?>"><?= $form['html']; ?></div>

<!-- EMP -->
<?= implode('', $form['modals']); ?>

<script>
    window.SITE = {};
</script>

<?php
wp_enqueue_script( 'empformembed-jquery-ui' );
wp_enqueue_script( 'empformembed-validate-admin' );
wp_enqueue_script( 'empformembed-jquery-masked' );
wp_enqueue_script( 'empformembed-jquery-pubsub' );
wp_enqueue_script( 'empformembed-validate' );
wp_enqueue_script( 'empformembed-field-library' );
wp_enqueue_script( 'empformembed-field-handler' );
wp_enqueue_script( 'empformembed-field-handler' );
wp_enqueue_script( 'empformembed-bootstrap' );
wp_enqueue_script( 'emp-form-embed-public-js' );
wp_enqueue_script( 'empformembed-bootstrap-datepicker' );
wp_enqueue_style( 'fontello-admin' );
wp_enqueue_style( 'themerex-options-style' );
?>
<script>
    SITE.data = {
        client_rules_url    : '<?php echo EMP_CLIENT_RULES_URL ?>',
        field_options_url   : '<?php echo EMP_FIELD_OPTIONS_URL ?>',
        client_id           : '<?php echo $config['SpectrumEMPClientID'] ?>',
        form_button         : '<?php echo $config['ButtonTitle'] ?>',
        field_numbers       : '<?php echo $config['NumberOfFields'] ?>',
    };
</script>