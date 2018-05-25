jQuery(function(){
    var counter = $('select.auth_name').length+1;
    $('#add_bank_sign').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<div class="row clearfix" id="repeat_bank_sign_'+counter+'">' + 
                                '<div class="col-md-4">' + 
                                    '<div class="form-group form-group-default form-group-default-select2">' + 
                                        '<label class="">Authorised Signatory</label>' + 
                                        '<select id="auth_name_'+counter+'" name="auth_name[]" class="form-control auth_name full-width select2" data-error="#err_auth_name_'+counter+'" data-placeholder="Select Authorised Signatory" data-init-plugin="select2">'+contact_details+'</select>' + 
                                        '<div id="err_auth_name_'+counter+'"></div>' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="col-md-4">' + 
                                    '<div class="form-group form-group-default">' + 
                                        '<label>Purpose of AS</label>' + 
                                        '<input type="text" class="form-control" name="auth_purpose[]" placeholder="Purpose of AS" value="" />' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="col-md-3">' + 
                                    '<div class="form-group form-group-default form-group-default-select2">' + 
                                        '<label class="">Authorised Type</label>' + 
                                        '<select id="auth_type_'+counter+'" name="auth_type[]" class="form-control auth_type full-width select2" data-error="#err_auth_type_'+counter+'" data-placeholder="Select Authorised Type" data-init-plugin="select2">' + 
                                            '<option value="">Select Authorised Type</option>' + 
                                            '<option>Sole</option>' + 
                                            '<option>Joint</option>' + 
                                        '</select>' + 
                                        '<div id="err_auth_type_'+counter+'"></div>' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="delete delete_row" id="repeat_bank_sign_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>' + 
                            '</div>');
        $('#banksign').append(newRow);
        $('.select2', newRow).select2();
        $('.delete_row').click(function(event){
            delete_row($(this));
        });
        $('form :input').change(function() {
            $('.save-form').prop("disabled",false);
        });

        counter++;
    });
});

$(document).ready(function() {
    addMultiInputNamingRules('#form_bank', 'select[name="auth_name[]"]', { required: function(element) {
                                                                                if($("#submitVal").val()=="0"){
                                                                                    return true;
                                                                                } else {
                                                                                    return false;
                                                                                }
                                                                            }, 
                                                                            messages: {required: "Select correct Owner from list"}
                                                                        }, "");
    addMultiInputNamingRules('#form_bank', 'select[name="auth_type[]"]', { required: function(element) {
                                                                                if($("#submitVal").val()=="0"){
                                                                                    return true;
                                                                                } else {
                                                                                    return false;
                                                                                }
                                                                            } 
                                                                        }, "");
});