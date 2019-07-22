(function ($){

    $(document).ready(function () {

        $("#post").validate({
            rules: {
                "post_title": {
                    required: true,
                },
                "emp_form_embed_api_key": {
                    required: true,
                },
                "emp_form_embed_client_id": {
                    required: true,
                }
            },
            messages: {
                "post_title": {
                    required: "Please, enter a title"
                },
                "emp_form_embed_api_key": {
                    required: "Please, enter an API key",
                },
                "emp_form_embed_client_id": {
                    required: "Please, enter an Client id",
                }
            }
        });


        $(".form-table tr td #emp_form_embed_api_key").change(function(){
            var IQSAPIKEY=$(this).val();
            IQS_API_KEY = 'IQS-API-KEY=' + IQSAPIKEY;

            jQuery.post(ajaxurl+'?action=wp_emp_sourceid_get_api', IQS_API_KEY, function( response ) {
                var x=$.parseJSON(response);

                if(x.status=='1')
                {
                    var form_source_id=x.data.sem_forms;
                    // console.log(form_source_id);
                    $.each(form_source_id, function (i, item) {
                        $('#emp_form_embed_form_source_id').append($('<option>', {
                            value: item,
                            text :item
                        }));
                    });
                }
                else
                {
                    alert(x.response);
                    return false;
                }
            });
        });
    });
})(jQuery);

