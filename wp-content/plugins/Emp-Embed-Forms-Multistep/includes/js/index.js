(function ($){
    $(document).ready(function () {

        main();

        var j= 1;
        $('div.section > div').each(function(i) {
            if( i % SITE.data.field_numbers == 0 ) {
                $(this).nextAll().andSelf().slice(0,SITE.data.field_numbers).wrapAll('<div class="setup-content" id="step-'+j+'"></div>');

                if(j==1) {

                    $('div#step-'+j).append('<div class="form-group alert alert-success form-submit-success"></div><div class="form-group alert alert-danger form-submit-danger"></div><div class="form-group"><button type="button" id="step-'+j+'" class="btn btn-black nextBtn  regbutton">Next</button></div>');
                    var btnClass = 'btn-primary active-step';
                    var disable  = '';
                } else {
                    $('div#step-'+j).append('<div class="form-group alert alert-success form-submit-success"></div><div class="form-group alert alert-danger form-submit-danger"></div><div class="form-group"> <button type="button" id="step-\'+j+\'" class="btn btn-black backBtn  regbutton">Back</button> <button type="button" id="step-'+j+'" class="btn btn-black nextBtn  regbutton">Next</button></div>');
                    var btnClass = 'btn-default';
                    var disable  = disabled="disabled";
                }

                $('.stepwizard-row.setup-panel').append('<div class="stepwizard-step"><a href="#step-'+j+'" type="button" class="btn '+btnClass+' btn-circle" '+disable+'></a><p></p></div>');
                j++;
            }
        });


        var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');
        allBackBtn = $('.backBtn');

        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                $item = $(this);

            var numItems = $('div.setup-content').length-1;
            var strp = ($(this).attr('href'));
            if(numItems == 0 ) {
                $('button.nextBtn').text(SITE.data.form_button);
                $('.stepwizard').css('display', 'none');
            }
            if (!$item.hasClass('disabled')) {
                $('button.nextBtn').attr("type", "button");
                if('#step-'+numItems == strp) {
                    $('.nextBtn').html('Next');
                }

                navListItems.removeClass('btn-primary active-step').addClass('btn-default');
                $item.addClass('btn-primary active-step');
                allWells.hide();
                $target.show();
                //$target.find('input:eq(0)').focus();
            }
        });

        allNextBtn.click(function(){
            var numItems = $('div.setup-content').length-1;
            var strp     = $(this).closest(".setup-content").attr('id');
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                curInputs = curStep.find("input, select").not(":submit, :reset, :image, [disabled], :hidden"),
                isValid = true;

            var program = $('.programs_select_year').val();
            if(program == '2018') {
                $('.programs_select_id').prop('required',null);
            } else {
                $('.programs_select_id').prop('required',true);
            }

            var radioChecked = $("input:radio").is(':checked');
            $(".form-group").removeClass("has-error");
            $('.has-error > .custom-error').hide();
            if(!radioChecked) {
                $('.iqs-form-radio').closest(".form-group").addClass("has-error");
            } else {
                $('.iqs-form-radio').closest(".form-group").removeClass("has-error");
            }
            for(var i=0; i<curInputs.length; i++){
                var closestDiv = $(curInputs[i]).closest(".form-group");
                if (!curInputs[i].validity.valid){
                    //console.log($(closestDiv).find('.custom-error'));
                    //console.log($(closestDiv).find('.custom-error'));
                    isValid = false;
                    $(closestDiv).addClass("has-error");
                    $(closestDiv).find('.custom-error').show();
                    $(closestDiv).find('.custom-error').css("color","#a94442");
                } else if($(curInputs[i]).hasClass('required_checkbox') && $("input.required_checkbox:checked").length <= 0) {
                    isValid = false;
                    $(closestDiv).addClass("has-error");
                    $(closestDiv).find('.custom-error').show();
                    $(closestDiv).find('.custom-error').css("color","#a94442");
                } else if(curInputs[i].validity.valid && curInputs[i].id.indexOf('text-opt-in') == "-1") {

                    $(closestDiv).removeClass("has-error");
                    $(closestDiv).find('.custom-error').hide();
                    //$(closestDiv).find('.custom-error').css("color","#a94442");
                }
            }
            
            if (isValid) {
                if ('step-' + numItems === strp) {
                    $('button.nextBtn').text(SITE.data.form_button);
                } else if('step-' + (numItems + 1) === strp) {
                    $('button.nextBtn').attr("type", "submit");
                } else {
                    $('button.nextBtn').text('Next');
                }

                nextStepWizard.removeAttr('disabled').trigger('click');
            }
        });

        allBackBtn.click(function(){
            var numItems = $('div.setup-content').length-1;
            var strp     = $(this).closest(".setup-content").attr('id');
            var curStep = $(this).closest(".setup-content"),
                curStepBtn = curStep.attr("id"),
                backStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a"),
                curInputs = curStep.find("input[type='text'], select").not(":submit, :reset, :image, [disabled], :hidden"),
                isValid = true;

            if (isValid) {
                $('button.backBtn').text('Back');
                backStepWizard.removeAttr('disabled').trigger('click');
            }
        });

        $('div.setup-panel div a.btn-primary').trigger('click');

        //if($("div.setup-content").length == 1) {
        $("button#step-1").addClass('emp_full_width_button');
        //}

    });

    function main() {

        var that = [];

        that.init = function() {

            $.mask.definitions['A'] = "[A-Z ]";
            $.mask.definitions['9'] = "[0-9 ]";

            $('.twipsy').tooltip({
                'placement':'top'
            });

            $('.iqs-form-phone-number').mask("(999) 999-9999", {
                placeholder: "_"
            });

            $('.ids-form-dob').mask("9999-99-99", {
                placeholder: "_"
            });

            $('.ids-form-act-score').mask("99", {
                placeholder: "_"
            });

            $('.iqs-form-picker').mask("9999", {
                placeholder: "_"
            });

            $('.iqs-form-high-picker').mask("999999", {
                placeholder: "_"
            });

            $('.iqs-form-gpa').mask("9.9", {reverse: true});

            $.validator.setDefaults({ ignore: [] });
            $.validator.setDefaults({
                debug: true,
                success: "data valid"
            });

            $('#form_example').validate({
                ignore: "[@type=hidden]" ,
                requiredClass: 'required',
                errorClass: 'has-error',
                errorApplyTo: 'div.form-group',

                onSuccess: function($form) {
                    var sb  = $form.find('.btn-black').not('.backBtn').html('Submitting...').attr('disabled', 'disabled'),
                        pid = $('.emp-form').attr('data-pid'),
                        form_params = $form.serialize();

                    form_params += '&pid='+pid;

                    //$.post('scripts/formhandler.php', $form.serialize(), function(r) {

                    $.post(EMPFORM.ajaxurl+'?action=emp_form_embed_formhandler', form_params, function(r) {
                        if (r.status == 1) {
                            $('.form-submit-danger').hide();

                            message = 'Thank you! Everything looks great, just hang on a <span class="lblCount"></span> second while we send you to <a href="'+r.data+'">your personal site</a>.';
                            $('.form-submit-success').html(message).show();

                            if (r.new_tab == 1) {
                                //window.open(r.data, '_blank');
                                newWindow.location = r.data;
                            }
                            else {
                                newWindow.close();
                                window.location.href = r.data;
                            }

                        } else {
                            var message = r.response;
                            $('.form-submit-success').hide();
                            if (message.toLowerCase().indexOf('already exist') >= 0) {
                                var seconds = 2;
                                message = 'Thank you! Everything looks great, just hang on a <span class="lblCount"></span> second while we send you to <a href="'+r.data+'">your personalized page</a>.';

                                setInterval(function () {
                                    seconds--;
                                    if (seconds == 0) {
                                        if (r.new_tab == 1) {
                                            //window.open(r.data, '_blank');
                                            newWindow.location = r.data;
                                        }
                                        else {
                                            newWindow.close();
                                            window.location.href = r.data;
                                        }
                                    }
                                }, 1000);
                                $('.form-submit-danger').html(message).hide();
                                $('.form-submit-success').html(message).show();
                            } else if (message.toLowerCase().indexOf('invalid') >= 0) {
                                newWindow.close();
                                message += '<ul>';
                                $.each(r.data, function (i, item) {
                                    message += '<li>' + item.displayName + ': ' + item.description + '</li>';
                                    $('#' + item.id).parents('div.control-group').addClass('error');
                                });
                                message += '</ul>';
                                $('.form-submit-success').html(message).hide();
                                $('.form-submit-danger').html(message).show();
                            }
                            //$('.form-submit-danger').html(message).show();
                            sb.html(SITE.data.form_button+' <i class="icon-chevron-right icon-white"></i>').removeAttr('disabled');
                        }

                    }, 'json');
                },

                onError: function($form) {
                    $('.form-submit-success').hide();
                    $('.form-submit-danger').html('Oops, it appears you weren\'t quite finished yet. Go ahead and fill in the fields we\'ve highlighted').show();
                }
            });

            function setup_field_rules() {
                var form_rule_handler = SITE.field_rules_form_library;

                form_rule_handler.setup_library();
                var fields_by_id = {};

                $.each($('[name]'), function(key, field) {

                    // we need to strip out [] if they trail a field name - such as 608[]
                    field_name = $(field).attr('name');
                    field_name = field_name.replace('[]', '');
                    if (!fields_by_id[field_name]) {
                        fields_by_id[field_name] = [];
                    }
                    fields_by_id[field_name].push(field);
                });

                form_rule_handler.register_fields(fields_by_id, $('form'));
            }

            setup_field_rules();
        }();
    }

    $('input.datepicker').datepicker({
        dateFormat: "yy-mm-dd",
        maxDate: new Date()
    })
    .change(function(date){
        $('input.datepicker').attr("value", $(this).val());
    });

    var newWindow = null;
    $('button.nextBtn').live('click', function(){
        if($(this).attr("type") === "submit") {
            newWindow = window.open('', '_blank');
            newWindow.document.write("Please wait while we review your information and load your personal site.");
        }
    });

})(jQuery);