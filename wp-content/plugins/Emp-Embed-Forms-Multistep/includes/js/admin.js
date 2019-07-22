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
                    $('#emp_form_embed_form_source_id').empty();
                    $.each(form_source_id, function (i, item) {

                        $('#emp_form_embed_form_source_id').append($('<option>', {
                            value: item,
                            text : i + ' ' + item
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

        $('input.datepicker').datepicker({
            maxDate: new Date(),
            dateFormat: "yy-mm-dd"
        });


        var room = 0;
        $("#addNewItem").click(function(){
            room++;
            $(this).parent().parent().before('<tr><th> EMP Field Id</th>' +
                '<td><input type="text" name="emp_form_embed_emp_field_id[]" id="emp_form_embed_emp_field_id_'+room+'" placeholder="EMP Field Id" size="30"><br>'           +
                '<span class="description">Enter the EMP Field Id for the EMP form.</span></td><td><input type="button"  id="qsp_cancel" value="Delete" onclick="remove_qsp(this)" class="button button-primary button-small"></td></tr>' +
                '<tr><th>QSP Name</th><td><input type="text" name="emp_form_embed_qsp_name[]" id="emp_form_embed_qsp_name_'+room+'" placeholder="QSP Name" size="30"><br>' +
                '<span  class="description">Enter the QSP Name for the EMP form.</span></td></tr>');
        });

    });

})(jQuery);

