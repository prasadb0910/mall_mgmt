function get_invoice_format(){
    if($('#type').val()=='Owners'){
        $('.inv_format').show();
    } else {
        $('.inv_format').hide();
    }
}

$(document).ready(function() {
    get_invoice_format();

    addMultiInputNamingRules('#form_owner', '.doc_name', { required:function(element) {
                                                                                    if($("#submitVal").val()=="0"){
                                                                                        return true;
                                                                                    } else {
                                                                                        return false;
                                                                                    }
                                                                                }
                                                            }, "Document");
    $('input.doc_file').each(function() {
        $(this).rules("remove");
    });
    $('input.doc_file').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        if($('#d_m_status_'+index).val()=="Yes") {
            if($('#doc_file_download_'+index).length==0) {
                $(this).rules("add", { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }
                                });
            }
        }
    });

    addMultiInputNamingRules('#form_owner', 'select[name="family[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
    addMultiInputNamingRules('#form_owner', 'input[name="relation[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }
                                }, "");
    addMultiInputNamingRules('#form_owner', 'select[name="director[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0" && $("#type").val()=="Owners"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
    addMultiInputNamingRules('#form_owner', 'select[name="shareholder[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0" && $("#type").val()=="Owners"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
    addMultiInputNamingRules('#form_owner', 'input[name="shareholder_percent[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0" && $("#type").val()=="Owners"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                },
                                                numbersonly: true
                                }, "");
    addMultiInputNamingRules('#form_owner', 'input[name="no_of_shares[]"]', {numbersonly: true}, "");
    addMultiInputNamingRules('#form_owner', 'select[name="partnership[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0" && $("#type").val()=="Owners"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
    addMultiInputNamingRules('#form_owner', 'input[name="partnership_percent[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0" && $("#type").val()=="Owners"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                },
                                                numbersonly: true
                                }, "");
    addMultiInputNamingRules('#form_owner', 'select[name="trustee[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0" && $("#type").val()=="Owners"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
    addMultiInputNamingRules('#form_owner', 'select[name="beneficiary[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0" && $("#type").val()=="Owners"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
    addMultiInputNamingRules('#form_owner', 'input[name="beneficiary_percent[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0" && $("#type").val()=="Owners"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                },
                                            numbersonly: true
                                }, "");
    addMultiInputNamingRules('#form_owner', 'select[name="owner[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0" && $("#type").val()=="Owners"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
});

jQuery(function(){
    var counter = $('select.family_details').length+1;

    $('#repeat-family').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<div id="repeat_family_'+counter+'" class="row clearfix">' + 
                                '<div class="col-md-4">' + 
                                    '<div class="form-group form-group-default form-group-default-select2 required">' + 
                                        '<label>Contact</label>' + 
                                        '<select id="family_details_'+counter+'" name="family[]" class="form-control family_details full-width select2" data-placeholder="Select" data-init-plugin="select2" data-error="#family_details_'+counter+'_error">'+contact_details+'</select>' + 
            							'<span id="family_details_'+counter+'_error"></span>' + 
                                    '</div>' + 
                                '</div>' + 
                                  '<div class="col-md-4" style="padding-right:0px!important">' + 
                                    '<div class="form-group form-group-default required">' + 
                                        '<label>Relation</label>' + 
                                        '<input type="text" name="relation[]" class="form-control" placeholder="Enter Here" value="" />' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="delete delete_row" id="repeat_family_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>' + 
                            '</div>');
        $('#family_details').append(newRow);
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

jQuery(function(){
    var counter = $('select.director_details').length+1;

    $('#repeat-director').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<div id="repeat_director_'+counter+'" class="row clearfix">' + 
                                   '<div class="col-md-4" style="padding-right:0px!important">' + 
                                    '<div class="form-group form-group-default form-group-default-select2 required">' + 
                                        '<label>Director</label>' + 
                                        '<select id="director_details_'+counter+'" name="director[]" class="form-control director_details full-width select2" data-placeholder="Select" data-init-plugin="select2" data-error="#director_details_'+counter+'_error">'+contact_details+'</select>' + 
                                        '<span id="director_details_'+counter+'_error"></span>' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="delete delete_row" id="repeat_director_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>' + 
                            '</div>');
        $('#director_details').append(newRow);
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

jQuery(function(){
    var counter = $('select.shareholder_details').length+1;

    $('#repeat-shareholder').click(function(event){
        event.preventDefault();
        console.log(contact_type);
        var required = (contact_type == "Tenants" || contact_type == "Others") ? "" : "required";
        var newRow = jQuery('<div id="repeat_shareholder_'+counter+'" class="row clearfix shareholder">' + 
                                '<div class="col-md-4">' + 
                                    '<div class="form-group form-group-default form-group-default-select2 '+required+'">' + 
                                        '<label>Shareholder</label>' + 
                                        '<select id="shareholder_details_'+counter+'" name="shareholder[]" class="form-control shareholder_details full-width select2" data-placeholder="Select" data-init-plugin="select2" data-error="#shareholder_details_'+counter+'_error">'+contact_details+'</select>' + 
                                        '<span id="shareholder_details_'+counter+'_error"></span>' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="col-md-4">' + 
                                    '<div class="form-group form-group-default '+required+'">' + 
                                        '<label>Shareholder %</label>' + 
                                        '<input type="text" id="shareholder_percent_'+counter+'" name="shareholder_percent[]" class="form-control" placeholder="Enter Here" value="" />' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="col-md-3" style="padding-right:0px!important">' + 
                                    '<div class="form-group form-group-default '+required+'">' + 
                                        '<label>No Of Shares</label>' + 
                                        '<input type="text" name="no_of_shares[]" class="form-control" placeholder="Enter Here" value="" />' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="delete delete_row" id="repeat_shareholder_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>' + 
                            '</div>');
        $('#shareholder_details').append(newRow);
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

jQuery(function(){
    var counter = $('select.partnership_details').length+1;

    $('#repeat-partnership').click(function(event){
        event.preventDefault();
        var required = (contact_type == "Tenants" || contact_type == "Others") ? "" : "required";

        var newRow = jQuery('<div id="repeat_partnership_'+counter+'" class="row clearfix">' + 
                                '<div class="col-md-4">' + 
                                    '<div class="form-group form-group-default form-group-default-select2 '+required+'">' + 
                                        '<label>Partner</label>' + 
                                        '<select id="partnership_details_'+counter+'" name="partnership[]" class="form-control partnership_details full-width select2" data-placeholder="Select" data-init-plugin="select2" data-error="#partnership_details_'+counter+'_error">'+contact_details+'</select>' + 
                                        '<span id="partnership_details_'+counter+'_error"></span>' + 
                                    '</div>' + 
                                '</div>' + 
                                 '<div class="col-md-4" style="padding-right:0px!important">' + 
                                    '<div class="form-group form-group-default '+required+'">' + 
                                        '<label>Partnership %</label>' + 
                                        '<input type="text" id="partnership_percent_'+counter+'" name="partnership_percent[]" class="form-control" placeholder="Enter Here" value="" />' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="delete delete_row" id="repeat_partnership_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>' + 
                            '</div>');
        $('#partnership_details').append(newRow);
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

jQuery(function(){
    var counter = $('select.authsignatory_details').length+1;

    $('#repeat-authsignatory').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<div id="repeat_authsignatory_'+counter+'" class="row clearfix">' + 
                                '<div class="col-md-4">' + 
                                    '<div class="form-group form-group-default form-group-default-select2 required">' + 
                                        '<label>Authorised Signatory</label>' + 
                                        '<select id="authsignatory_details_'+counter+'" name="authsignatory[]" class="form-control authsignatory_details full-width select2" data-placeholder="Select" data-init-plugin="select2" data-error="#authsignatory_details_'+counter+'_error">'+contact_details+'</select>' + 
                                        '<span id="authsignatory_details_'+counter+'_error"></span>' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="col-md-4">' + 
                                    '<div class="form-group form-group-default">' + 
                                        '<label>Purpose Of AS</label>' + 
                                        '<input type="text" name="purpose[]" class="form-control" placeholder="Enter Here" value="" />' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="delete delete_row" id="repeat_authsignatory_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>' + 
                            '</div>');
        $('#authsignatory_details').append(newRow);
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

jQuery(function(){
    var counter = $('select.trustee_details').length+1;

    $('#repeat-trustee').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<div id="repeat_trustee_'+counter+'" class="row clearfix">' + 
                                '<div class="col-md-4">' + 
                                    '<div class="form-group form-group-default form-group-default-select2 required">' + 
                                        '<label>Trustee</label>' + 
                                        '<select id="trustee_details_'+counter+'" name="trustee[]" class="form-control trustee_details full-width select2" data-placeholder="Select" data-init-plugin="select2" data-error="#trustee_details_'+counter+'_error">'+contact_details+'</select>' + 
                                        '<span id="trustee_details_'+counter+'_error"></span>' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="delete delete_row" id="repeat_trustee_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>' + 
                            '</div>');
        $('#trustee_details').append(newRow);
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

jQuery(function(){
    var counter = $('select.beneficiary_details').length+1;

    $('#repeat-beneficiary').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<div id="repeat_beneficiary_'+counter+'" class="row clearfix">' + 
                                '<div class="col-md-4">' + 
                                    '<div class="form-group form-group-default form-group-default-select2 required">' + 
                                        '<label>Beneficiary</label>' + 
                                        '<select id="beneficiary_details_'+counter+'" name="beneficiary[]" class="form-control beneficiary_details full-width select2" data-placeholder="Select" data-init-plugin="select2" data-error="#beneficiary_details_'+counter+'_error">'+contact_details+'</select>' + 
                                        '<span id="beneficiary_details_'+counter+'_error"></span>' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="col-md-4">' + 
                                    '<div class="form-group form-group-default required">' + 
                                        '<label>Beneficiary %</label>' + 
                                        '<input type="text" id="beneficiary_percent_'+counter+'" name="beneficiary_percent[]" class="form-control" placeholder="Enter Here" value="" />' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="delete delete_row" id="repeat_beneficiary_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>' + 
                            '</div>');
        $('#beneficiary_details').append(newRow);
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

jQuery(function(){
    var counter = $('select.owner_details').length+1;

    $('#repeat-owner').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<div id="repeat_owner_'+counter+'" class="row clearfix">' + 
                                '<div class="col-md-4">' + 
                                    '<div class="form-group form-group-default form-group-default-select2 required">' + 
                                        '<label>Owner</label>' + 
                                        '<select id="owner_details_'+counter+'" name="owner[]" class="form-control owner_details full-width select2" data-placeholder="Select" data-init-plugin="select2" data-error="#owner_details_'+counter+'_error">'+contact_details+'</select>' + 
                                        '<span id="owner_details_'+counter+'_error"></span>' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="delete delete_row" id="repeat_owner_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>' + 
                            '</div>');
        $('#owner_details').append(newRow);
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