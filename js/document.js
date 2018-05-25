// $(function() { $('.datepicker1').datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0', changeYear: true }); });

function getExpiryDateStatus(element){
    var id = element.id;
    var doc_name = element.value;
    var index = id.substr(id.lastIndexOf('_')+1);

    $.ajax({
            url: BASE_URL+'index.php/documents/getDocumentDetails',
            data: 'doc_name='+doc_name,
            type: "POST",
            dataType: 'html',
            global: false,
            async: false,
            success: function (data) {
                var d_show_expiry_date = $.trim(data);
                if(d_show_expiry_date=='Yes') {
                    $("#date_expiry_" + index).show();
                } else {
                    $("#date_expiry_" + index).hide();
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                $("#date_expiry_" + index).hide();
            }
    });
}

jQuery(function(){
    $('#repeat-documents').click(function(event){
        var counter = $('input.doc_file').length+1;
        event.preventDefault();
        var newRow = jQuery('<div id="repeat_doc_'+counter+'" class="form-group" style="background:none; border:none;">' + 
                                '<div class="block1">' + 
                                    '<div class="row clearfix">' + 
                                        '<div class="col-md-10">' + 
                                            '<input type="hidden" class="form-control" id="d_m_status_'+counter+'" value="No" />' + 
                                            '<div class="form-group form-group-default form-group-default-select2">' + 
                                                '<label class="">Select Document Type</label>' + 
                                                '<select name="doc_type[]" class="full-width select2" data-placeholder="Select Document Type" data-init-plugin="select2" id="doc_type_'+counter+'">'+document_type_options+'</select>' + 
                                            '</div>' + 
                                        '</div>' + 
                                        '<div class="col-md-2">' + 
                                            '<div class="remove delete_row" id="repeat_doc_'+counter+'_delete">Remove <i class="fa fa-times" aria-hidden="true"></i></div>' + 
                                        '</div>' + 
                                    '</div>' + 
                                    '<div class="row clearfix">' + 
                                        '<div class="col-md-4">' + 
                                            '<div class="form-group form-group-default form-group-default-select2">' + 
                                                '<input type="hidden" id="doc_name_'+counter+'_id" name="doc_doc_name[]" class="form-control doc_name" value="" />' + 
                                                '<label>Select Document</label>' + 
                                                '<select name="doc_name[]" class="full-width select2" data-placeholder="Select Document" data-init-plugin="select2" id="doc_name_'+counter+'" onChange="getExpiryDateStatus(this);">'+document_details+'</select>' + 
                                            '</div>' + 
                                        '</div>' + 
                                        '<div class="col-md-4">' + 
                                            '<div class="form-group form-group-default">' + 
                                                '<label>Description</label>' + 
                                                '<input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="" />' + 
                                            '</div>' + 
                                        '</div>' + 
                                        '<div class="col-md-4">' + 
                                            '<div class="form-group form-group-default">' + 
                                                '<label>Refernce No</label>' + 
                                                '<input type="text" class="form-control" name="ref_no[]" id="ref_no_'+counter+'" placeholder="Reference No" value=""/>' + 
                                            '</div>' + 
                                        '</div>' + 
                                    '</div>' + 
                                    '<div class="row clearfix">' + 
                                        '<div class="col-md-4">' + 
                                            '<div class="form-group form-group-default">' + 
                                                '<label>Date Of Issue</label>' + 
                                                '<input type="text" class="form-control date1" name="date_issue[]" placeholder="Date of Issue" value="" />' + 
                                            '</div>' + 
                                        '</div>' + 
                                        '<div class="col-md-4" style="padding-right:7px!important;" id="date_expiry_'+counter+'">' + 
                                            '<div class="form-group form-group-default">' + 
                                                '<label>Date Of Expiry</label>' + 
                                                '<input type="text" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry" value="" />' + 
                                            '</div>' + 
                                        '</div>' + 
                                    '</div>' + 
                                    '<p class="attachments">Attachments</p>' + 
                                    '<div class="row clearfix">' + 
                                        '<div class="col-md-8">' + 
                                            '<div class="fileUpload blue-btn btn width100">' + 
                                                '<span><i class="fa fa-cloud-upload"></i></span>' + 
                                                '<input type="hidden" class="form-control" name="doc_document[]" value="" />' + 
                                                '<input type="hidden" class="form-control" name="document_name[]" value="" />' + 
                                                '<input type="file" class="uploadlogo fileinput btn btn-success padding-height doc_file" name="doc_'+counter+'" id="doc_file_'+counter+'" data-error="#doc_'+counter+'_error"/>' + 
                                                '<div id="doc_'+counter+'_error"></div>' + 
                                            '</div>' + 
                                        '</div>' + 
                                    '</div>' + 
                                '</div>' + 
                            '</div>');
        $('#document_details').append(newRow);
        // $('.auto_document', newRow).autocomplete(autocomp_opt_document);
        $('.select2', newRow).select2();
        $('.datepicker').datepicker({  changeMonth: true,yearRange:'-100:+100',changeYear: true });
        $('.date1').datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
        $('.delete_row').click(function(event){
            delete_row($(this));
        });
        $(".uploadlogo").change(function() {
            readURL(this);
        });
        $('form :input').change(function() {
            $('.save-form').prop("disabled",false);
        });
        // counter++;
    });
    // $('#reverse-documents').click(function(event){
    //     var id="#repeat_doc_"+(counter-1).toString();
    //     if($(id).length>0){
    //         $(id).remove();
    //         counter--;
    //     }
    // });
});





// jQuery(function(){
//     var counter = $('input.doc_file').length;
//     $('#repeat-documents').click(function(event){
//         event.preventDefault();
//         var newRow = jQuery('<div class="form-group" id="repeat_doc_'+counter+'" style="background:none;border:none;">' + 
//                                 '<div class="col-md-3">' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="hidden" class="form-control" id="d_m_status_'+counter+'" value="No" />' + 
//                                         '<select class="form-control" name="doc_type[]" id="doc_type_'+counter+'">'+document_type_options+'</select>' + 
//                                     '</div>' + 
//                                     '<div class="col-md-6" >' + 
//                                         '<input type="hidden" id="doc_name_'+counter+'_id" name="doc_name[]" class="form-control doc_name" value="" data-error="#doc_name_'+counter+'_error"/>' + 
//                                         '<input type="text" id="doc_name_'+counter+'" name="doc_doc_name[]" class="form-control auto_document" value="" placeholder="Type to choose document from database..." />' + 
//                                         '<div id="doc_name_'+counter+'_error"></div>' + 
//                                     '</div>' + 
//                                 '</div>' + 
//                                 '<div class="col-md-4">' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="" />' + 
//                                     '</div>' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="text" class="form-control" name="ref_no[]" id="ref_no_'+counter+'" placeholder="Reference No"/>' + 
//                                     '</div>' + 
//                                 '</div>' + 
//                                 '<div class="col-md-3">' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue"/>' + 
//                                     '</div>' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="text" id="date_expiry_'+counter+'" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry"/>' + 
//                                     '</div>' + 
//                                 '</div>' + 
//                                 '<div class="col-md-2">' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="hidden" class="form-control" name="doc_document[]" value="" />' + 
//                                         '<input type="hidden" class="form-control" name="document_name[]" value="" />' + 
//                                         '<a class="file-input-wrapper btn   fileinput btn-success">' + 
//                                             '<span>Browse</span>' + 
//                                             '<input type="file" class="fileinput btn btn-successy doc_file" name="doc_'+counter+'" id="doc_file_'+counter+'" data-error="#doc_'+counter+'_error" style="width: 100%;height: 28px;">' + 
//                                         '</a>' + 
//                                         '<div id="doc_'+counter+'_error"></div>' + 
//                                     '</div>' + 
//                                     '<div class="col-md-3" >' + 
//                                         ' &nbsp;' + 
//                                     '</div>' + 
//                                     '<div class="col-md-1" >' + 
//                                         '<a title="Delete" id="repeat_doc_'+counter+'_delete" class="delete_row" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a>' + 
//                                     '</div>' + 
//                                 '</div>' + 
//                             '</div>');
//         $('#document_details').append(newRow);
//         $('.auto_document', newRow).autocomplete(autocomp_opt_document);
//         $('.datepicker').datepicker({  changeMonth: true,yearRange:'-100:+100',changeYear: true });
//         $('.datepicker1').datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
//         $('.delete_row').click(function(event){
//             delete_row($(this));
//         });
//         $('form :input').change(function() {
//             $('.save-form').prop("disabled",false);
//         });
//         counter++;
//     });
//     $('#reverse-documents').click(function(event){
//         var id="#repeat_doc_"+(counter-1).toString();
//         if($(id).length>0){
//             $(id).remove();
//             counter--;
//         }
//     });
// });

// jQuery(function(){
//     var counter = $('input.doc_file').length;
//     $('#repeat-documents').click(function(event){
//         event.preventDefault();
//         var newRow = jQuery('<div class="form-group" id="repeat_doc_'+counter+'" style="background:none;border:none;">' + 
//                                 '<div class="col-md-3">' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="hidden" class="form-control" id="d_m_status_'+counter+'" value="No" />' + 
//                                         '<select class="form-control" name="doc_type[]" id="doc_type_'+counter+'">'+document_type_options+'</select>' + 
//                                     '</div>' + 
//                                     '<div class="col-md-6" >' + 
//                                         '<input type="hidden" id="doc_name_'+counter+'_id" name="doc_name[]" class="form-control doc_name" value="" data-error="#doc_name_'+counter+'_error"/>' + 
//                                         '<input type="text" id="doc_name_'+counter+'" name="doc_doc_name[]" class="form-control auto_document" value="" placeholder="Type to choose document from database..." />' + 
//                                         '<div id="doc_name_'+counter+'_error"></div>' + 
//                                     '</div>' + 
//                                 '</div>' + 
//                                 '<div class="col-md-4">' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="" />' + 
//                                     '</div>' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="text" class="form-control" name="ref_no[]" id="ref_no_'+counter+'" placeholder="Reference No"/>' + 
//                                     '</div>' + 
//                                 '</div>' + 
//                                 '<div class="col-md-3">' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue"/>' + 
//                                     '</div>' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="text" id="date_expiry_'+counter+'" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry"/>' + 
//                                     '</div>' + 
//                                 '</div>' + 
//                                 '<div class="col-md-2">' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="hidden" class="form-control" name="doc_document[]" value="" />' + 
//                                         '<input type="hidden" class="form-control" name="document_name[]" value="" />' + 
//                                         '<a class="file-input-wrapper btn   fileinput btn-success">' + 
//                                             '<span>Browse</span>' + 
//                                             '<input type="file" class="fileinput btn btn-successy doc_file" name="doc_'+counter+'" id="doc_file_'+counter+'" data-error="#doc_'+counter+'_error" style="width: 100%;height: 28px;">' + 
//                                         '</a>' + 
//                                         '<div id="doc_'+counter+'_error"></div>' + 
//                                     '</div>' + 
//                                     '<div class="col-md-3" >' + 
//                                         ' &nbsp;' + 
//                                     '</div>' + 
//                                     '<div class="col-md-1" >' + 
//                                         '<a title="Delete" id="repeat_doc_'+counter+'_delete" class="delete_row" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a>' + 
//                                     '</div>' + 
//                                 '</div>' + 
//                             '</div>');
//         $('#document_details').append(newRow);
//         $('.auto_document', newRow).autocomplete(autocomp_opt_document);
//         $('.datepicker').datepicker({  changeMonth: true,yearRange:'-100:+100',changeYear: true });
//         $('.datepicker1').datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
//         $('.delete_row').click(function(event){
//             delete_row($(this));
//         });
//         $('form :input').change(function() {
//             $('.save-form').prop("disabled",false);
//         });
//         counter++;
//     });
//     $('#reverse-documents').click(function(event){
//         var id="#repeat_doc_"+(counter-1).toString();
//         if($(id).length>0){
//             $(id).remove();
//             counter--;
//         }
//     });
// });

// jQuery(function(){
//     var counter = $('input.doc_file').length;
//     $('#repeat-documents').click(function(event){
//         event.preventDefault();
//         var newRow = jQuery('<div class="form-group" id="repeat_doc_'+counter+'" style="background:none;border:none;">' + 
//                                 '<div class="col-md-3">' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="hidden" class="form-control" name="doc_type[]" id="doc_type_'+counter+'" />' + 
//                                         '<input type="hidden" class="form-control" id="d_m_status_'+counter+'" value="No" />' + 
//                                         '<label class="doc_file">Others </label>' + 
//                                     '</div>' + 
//                                     '<div class="col-md-6" >' + 
//                                         '<input type="hidden" id="doc_name_'+counter+'_id" name="doc_name[]" class="form-control doc_name" value="" data-error="#doc_name_'+counter+'_error"/>' + 
//                                         '<input type="text" id="doc_name_'+counter+'" class="form-control auto_document" value="" placeholder="Type to choose document from database..." />' + 
//                                         '<div id="doc_name_'+counter+'_error"></div>' + 
//                                     '</div>' + 
//                                 '</div>' + 
//                                 '<div class="col-md-4">' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="text" class="form-control" name="doc_desc[]" placeholder="Description" value="" />' + 
//                                     '</div>' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="text" class="form-control" name="ref_no[]" id="ref_no_'+counter+'" placeholder="Reference No"/>' + 
//                                     '</div>' + 
//                                 '</div>' + 
//                                 '<div class="col-md-3">' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="text" class="form-control datepicker1" name="date_issue[]" placeholder="Date of Issue"/>' + 
//                                     '</div>' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="text" id="date_expiry_'+counter+'" class="form-control datepicker" name="date_expiry[]" placeholder="Date of Expiry"/>' + 
//                                     '</div>' + 
//                                 '</div>' + 
//                                 '<div class="col-md-2">' + 
//                                     '<div class="col-md-6">' + 
//                                         '<input type="hidden" class="form-control" name="doc_document[]" value="" />' + 
//                                         '<input type="hidden" class="form-control" name="document_name[]" value="" />' + 
//                                         '<a class="file-input-wrapper btn   fileinput btn-success">' + 
//                                             '<span>Browse</span>' + 
//                                             '<input type="file" class="fileinput btn btn-successy doc_file" name="doc_'+counter+'" id="doc_file_'+counter+'" data-error="#doc_'+counter+'_error" style="width: 100%;height: 28px;">' + 
//                                         '</a>' + 
//                                         '<div id="doc_'+counter+'_error"></div>' + 
//                                     '</div>' + 
// 									'<div class="col-md-3" >' + 
//                                         ' &nbsp;' + 
//                                     '</div>' + 
//                                     '<div class="col-md-1" >' + 
//                                         '<a title="Delete" id="repeat_doc_'+counter+'_delete" class="delete_row" href="#"><i class="fa fa-trash-o" aria-hidden="true"></i></a>' + 
//                                     '</div>' + 
//                                 '</div>' + 
//                             '</div>');
//         $('#document_details').append(newRow);
//         $('.auto_document', newRow).autocomplete(autocomp_opt_document);
//         $('.datepicker').datepicker({  changeMonth: true,yearRange:'-100:+100',changeYear: true });
//         $('.datepicker1').datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
//         $('.delete_row').click(function(event){
//             delete_row($(this));
//         });
//         $('form :input').change(function() {
//             $('.save-form').prop("disabled",false);
//         });
//         counter++;
//     });
//     $('#reverse-documents').click(function(event){
//         var id="#repeat_doc_"+(counter-1).toString();
//         if($(id).length>0){
//             $(id).remove();
//             counter--;
//         }
//     });
// });