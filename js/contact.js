// $(document).ready(function() {       
//     // $('#dob').change(function(){ 
//     //     checkdob();
//     // });
//     // $("#dob").datepicker({
//     //     onSelect: function(dateText, inst) {
//     //         checkdob();
//     //     }
//     // });
// });

// function checkdob(){
//     var age = getAge();
//     if(age<18 && age !=null){
//         $('.guardian').show();
//     } else {
//         $('.guardian').hide();
//         $('#guardian').val('');
//         $('#guardian_relation').val('');
//     }
//     return age;
// }

// function getAge(){
//     var age = null;

//     if ($('#dob').val()!=""){
//         var day = moment($('#dob').val(), "dd/mm/yyyy");
//         var dob = new Date(day);
//         var today = new Date();

//         console.log(dob);
//         console.log(today);

//         age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));

//         console.log(age);
//     }

//     return age;
// }

function get_invoice_format(){
    if($('#type').val()=='Owners'){
        $('.inv_format').show();
    } else {
        $('.inv_format').hide();
    }
}

$(document).ready(function() {

    get_invoice_format();

    $('input[type=radio][name=kyc]').on('change', function () {
        if (this.value == '1') {
            $('#nominee-section').show();
            $('#kyc-section').show();
        } else if (this.value == '0') {
            $('#kyc-section').hide();
            //$('#nominee-section').hide();
        }
    });
});

jQuery(function(){
    var counter = $('select.nm_name').length+1;

    $('#repeat-nominee').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<div id="repeat_nominee_'+counter+'" class="row clearfix">' + 
                                '<div class="col-md-4">' + 
                                    '<div class="form-group form-group-default form-group-default-select2">' + 
                                        '<label>Contact</label>' + 
                                        '<select id="nm_name_'+counter+'" name="nm_name[]" class="form-control nm_name full-width select2" data-placeholder="Select" data-init-plugin="select2">'+contact_details+'</select>' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="col-md-4" style="padding-right:0px!important">' + 
                                    '<div class="form-group form-group-default">' + 
                                        '<label>Relation</label>' + 
                                        '<input type="text" name="nm_relation[]" class="form-control" placeholder="Enter Here" value="" />' + 
                                    '</div>' + 
                                '</div>' + 
                                '<div class="delete delete_row" id="repeat_nominee_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>' + 
                            '</div>');
        $('#nominee_details').append(newRow);
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