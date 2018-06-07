// ----------------- COMMON FUNCTIONS -------------------------------------
$.validator.addMethod("lettersonly", function(value, element) {
    return this.optional(element) || /^[a-z\s]+$/i.test(value);
}, "Letters only please");

$.validator.addMethod("numbersonly", function(value, element) {
    return this.optional(element) || /^[0-9]+$/i.test(value);
}, "Numbers only please");

$.validator.addMethod("numbersandcommaonly", function(value, element) {
    return this.optional(element) || /^[0-9]|^,+$/i.test(value);
}, "Numbers only please");

$.validator.addMethod("checkemail", function(value, element) {
    return this.optional(element) || (/^[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,8}$/i.test(value) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/i.test(value));
}, "Please enter valid email address");

function addMultiInputNamingRules(form, field, rules, type){
    // alert(field);
    $(form).find(field).each(function(index){
        if (type=="Document") {
            var id = $(this).attr('id');
            var index = id.substr(id.lastIndexOf('_')+1);
            if($('#d_m_status_'+index).val()=="Yes"){
                $(this).attr('alt', $(this).attr('name'));
                $(this).attr('name', $(this).attr('name')+'-'+index);
                $(this).rules('add', rules);
            }
        } else {
            $(this).attr('alt', $(this).attr('name'));
            $(this).attr('name', $(this).attr('name')+'-'+index);
            $(this).rules('add', rules);
        }
    });
}

function removeMultiInputNamingRules(form, field){    
    $(form).find(field).each(function(index){
        $(this).attr('name', $(this).attr('alt'));
        $(this).removeAttr('alt');
    });
}

// function getMStatus(element){
//     var id = element.id;
//     var doc_name = element.value;
//     var index = id.substr(id.lastIndexOf('_')+1);

//     var doc_type = $('#doc_type_'+index).val();

//     $.ajax({
//             url: BASE_URL+'index.php/contacts/get_m_status',
//             data: 'doc_name='+doc_name+'&doc_type='+doc_type,
//             type: "POST",
//             dataType: 'html',
//             global: false,
//             async: false,
//             success: function (data) {
//                 $('#d_m_status_'+index).val($.trim(data));
//             },
//             error: function (xhr, ajaxOptions, thrownError) {
//                 $('#d_m_status_'+index).val("");
//             }
//         });
// }

$('.save-form').click(function(){ 
    $("#submitVal").val('1');
});
$('.submit-form').click(function(){ 
    $("#submitVal").val('0');
});




// ----------------- POP UP CONTACT FORM VALIDATION -------------------------------------
$("#contact_popup_form").validate({
    rules: {
        con_first_name: {
            required: true,
            lettersonly: true
        },
        con_last_name: {
            required: true,
            lettersonly: true
        },
        con_email_id1: {
            required: true,
            checkemail: true
        },
        con_mobile_no1: {
            required: true,
            numbersonly: true,
            checkContactAvailability: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

//--------Revenue Sharing---------//
$("#form_revenue").validate({
    rules: {
        property: {
            required: true
        },
        revenue_schedule_id: {
            required: true
        },
        revenue_amount: {
            required: true,
            check_revenue: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("check_revenue", function (value, element) {
    var result;

    $.ajax({
            url:BASE_URL+"index.php/Rent_revenue_sharing/check_revenue",
            data:{'revenue_id':$('#month').val()},
            dataType:"json",
            type:"POST",
            async:false,
            success:function(response){
               result = parseInt(response);
            },
            error:function(xhr, ajaxOptions, thrownError) {
                /*alert(xhr.status);
                alert(thrownError);*/
            },
        });
    if (result) {
        return false;
    } else {
        return true;
    }
}, 'It cant be edited as payment is done for this entry');


$('#form_revenue').submit(function() {
    if (!$("#form_revenue").valid()) {
        return false;
    } else {
        return true;
    }
});




$.validator.addMethod("checkContactAvailability", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/contacts/check_contact_availablity',
        data: 'con_first_name='+$("#con_first_name").val()+'&con_last_name='+$("#con_last_name").val()+'&con_email_id1='+$("#con_email_id1").val()+'&con_mobile_no1='+$("#con_mobile_no1").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'First_name, Last_name, Email ID-1 & Mobile No-1 already in use');

$('#contact_popup_form').submit(function() {
    if (!$("#contact_popup_form").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- CONTACT FORM VALIDATION -------------------------------------
$("#form_contact").validate({
    rules: {
        c_name: {
            required: true,
            lettersonly: true
        },
        c_middle_name: {
            lettersonly: true
        },
        c_last_name: {
            required: function(element) {
                        return true;
                    },
            lettersonly: true
        },
        // owner_type: {
        //     required: function(element) {
        //                 return ($("#type").val()=="Others");
        //             }
        // },
        // type: {
        //     required: function(element) {
        //                 if($("#submitVal").val()=="0"){
        //                     return true;
        //                 } else {
        //                     return false;
        //                 }
        //             }
        // },
        // company: {
        //     required: function(element) {
        //                 if($("#submitVal").val()=="0"){
        //                     return ($("#type").val()=="Others");
        //                 } else {
        //                     return false;
        //                 }
        //             }
        // },
		
		 type: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        date_of_birth: {
            required: function(element) {
                        if($("#type").val()=="Owners"){
                            return true;
                        } else {
                            return false;
                        }
                    }
					
			// required: {
			// depends: function(element) {
			 // return $("#type").val() = "Owners"
			// }
			// }	
					
        },
        gender: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        // guardian: {
        //     required: function(element) {
        //                 if($("#submitVal").val()=="0"){
        //                     var age = getAge();
        //                     if(age<18 && age !=null){
        //                         return true;
        //                     } else {
        //                         return false;
        //                     }
        //                 } else {
        //                     return false;
        //                 }
        //             }
        // },
        // guardian_relation: {
        //     required: function(element) {
        //                 if($("#submitVal").val()=="0"){
        //                     var age = getAge();
        //                     if(age<18 && age !=null){
        //                         return true;
        //                     } else {
        //                         return false;
        //                     }
        //                 } else {
        //                     return false;
        //                 }
        //             }
        // },
        address: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        landmark: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        state: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        city: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        pincode: {
            numbersonly: true,
        },
        country: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        email_id1: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            checkemail: true
        },
        email_id2: {
            checkemail: true
        },
        mobile_no1: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true,
            checkAvailability: true
        },
        mobile_no2: {
            numbersonly: true,
        },
        kyc: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
       
        // invoice_format: {
        //     required: true
        // },
        // invoice_no: {
        //     required: true,
        //     numbersonly: true
        // },
        // gst_no: {
        //     required: true
        // }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    },

    invalidHandler: function(e,validator) {
        var errors="";
        if ($('#panel-personal-details').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in personal details. <br/>";
        }
        if ($('#kyc-section').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in KYC Details. <br/>";
        }
        if ($('#nominee-section').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in Nominee Details. <br/>";
        }

        $('#form_errors').html(errors);

        if(errors!=""){
            $('#form_errors').show();
        } else {
            $('#form_errors').hide();
        }
    }
});

$.validator.addMethod("checkAvailability", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/contacts/check_availablity',
        data: 'c_id='+$("#c_id").val()+'&c_name='+$("#c_name").val()+'&c_last_name='+$("#c_last_name").val()+'&email_id1='+$("#email_id1").val()+'&mobile_no1='+$("#mobile_no1").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'First_name, Last_name, Email ID-1 & Mobile No-1 already in use');

$('#form_contact').submit(function() {
    removeMultiInputNamingRules('#form_contact', '.doc_name');
    // removeMultiInputNamingRules('#form_contact', 'input[alt="ref_no[]"]');
    // removeMultiInputNamingRules('#form_contact', 'input[alt="nm_contact_name[]"]');
    // removeMultiInputNamingRules('#form_contact', 'input[alt="nm_relation[]"]');

    addMultiInputNamingRules('#form_contact', '.doc_name', { required: function(element) {
                                                                        if($("#submitVal").val()=="0"){
                                                                            return $("#kyc_yes").is(":checked");
                                                                        } else {
                                                                            return false;
                                                                        }
                                                                    }
                                                                }, "Document");
    // addMultiInputNamingRules('#form_contact', 'input[name="ref_no[]"]', { required:function(element) {
    //                                                                                 return $("#kyc_yes").is(":checked");
    //                                                                             }
    //                                                                     }, "Document");
    $('input.doc_file').each(function() {
        $(this).rules("remove");
    });
    $('input.doc_file').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);

        if($('#d_m_status_'+index).val()=="Yes") {
            if($('#doc_document_'+index).val()=='') {
                $(this).rules("add", { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        if($("#kyc_yes").is(":checked")){
                                                            // if($("#type").val()=="Others"){
                                                            //     return false;
                                                            // } else {
                                                            //     return true;
                                                            // }
                                                            return true;
                                                        } else {
                                                            return false;
                                                        }
                                                    } else {
                                                        return false;
                                                    }
                                                }
                                });
            }
        }
    });

    // addMultiInputNamingRules('#form_contact', 'input[name="nm_contact_name[]"]', { required: function(element) {
    //                                                                                             if($("#submitVal").val()=="0"){
    //                                                                                                 return $("#kyc_yes").is(":checked");
    //                                                                                             } else {
    //                                                                                                 return false;
    //                                                                                             }
    //                                                                                         }
    //                                                                             }, "");
    // addMultiInputNamingRules('#form_contact', 'input[name="nm_relation[]"]', { required: function(element) {
    //                                                                                         if($("#submitVal").val()=="0"){
    //                                                                                             return $("#kyc_yes").is(":checked");
    //                                                                                         } else {
    //                                                                                             return false;
    //                                                                                         }
    //                                                                                     }
    //                                                                             }, "");

    if (!$("#form_contact").valid()) {
        return false;
    } else {
        removeMultiInputNamingRules('#form_contact', '.doc_name');
        // removeMultiInputNamingRules('#form_contact', 'input[alt="ref_no[]"]');
        // removeMultiInputNamingRules('#form_contact', 'input[alt="nm_contact_name[]"]');
        // removeMultiInputNamingRules('#form_contact', 'input[alt="nm_relation[]"]');
        return true;
    }
});




// ----------------- GROUP FORM VALIDATION -------------------------------------
$("#form_group").validate({
    rules: {
        group_name: {
            required: true,
            checkGroupAvailability: true
        }
    },

    ignore: false,
    onkeyup: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("checkGroupAvailability", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/groups/check_group_availablity',
        data: 'g_id='+$("#group_id").val() + '&group_name='+$("#group_name").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Group name already exist');

$('#form_group').submit(function() {
    removeMultiInputNamingRules('#form_group', 'input[alt="groupusername[]"]');
    removeMultiInputNamingRules('#form_group', 'input[alt="groupuserlastname[]"]');
    removeMultiInputNamingRules('#form_group', 'input[alt="groupmobile[]"]');
    removeMultiInputNamingRules('#form_group', 'input[alt="groupemail[]"]');
    removeMultiInputNamingRules('#form_group', 'select[alt="userid[]"]');
    removeMultiInputNamingRules('#form_group', 'select[alt="userroleid[]"]');
    $('.selusername').each(function() {
        $(this).rules("remove");
    });
    $('.seluserrole').each(function() {
        $(this).rules("remove");
    });
    // $('.useremail').each(function() {
    //     $(this).rules("remove", "checkDuplicate");
    // });

    addMultiInputNamingRules('#form_group', 'input[name="groupusername[]"]', { required: true, lettersonly: true }, "");
    addMultiInputNamingRules('#form_group', 'input[name="groupuserlastname[]"]', { required: true, lettersonly: true }, "");
    addMultiInputNamingRules('#form_group', 'input[name="groupmobile[]"]', { required: true, numbersonly: true}, "");
    addMultiInputNamingRules('#form_group', 'input[name="groupemail[]"]', { required: true, checkemail: true }, "");
    addMultiInputNamingRules('#form_group', 'select[name="userid[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_group', 'select[name="userroleid[]"]', { required: true }, "");
    $('.selusername').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        $(this).rules("add", { required: function(element) {
                                            return ($('#userroleid_'+index).val()!="" && $('#userroleid_'+index).val()!=null);
                                        }
                        });
    });
    $('.seluserrole').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        $(this).rules("add", { required: function(element) {
                                            return ($('#userid_'+index).val()!="" && $('#userid_'+index).val()!=null);
                                        }
                        });
    });

    if (!$("#form_group").valid()) {
        return false;
    } else {
        if (checkGroupUserAvailability()==false) {
            return false;
        } else {
            $('.useremail').each(function() {
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var newemail = $(this).val();
                var actualid = "groupemailactual_" + index;
                var oldemail = $('#'+actualid).val();

                if(oldemail!="" && oldemail!=null){
                    if(oldemail != newemail){
                        $('#otp_email_id').val(newemail);
                        $('#otp_check').val('false');

                        var result = 1;

                        $.ajax({
                            url: BASE_URL+'index.php/groups/send_otp',
                            data: 'email_id='+newemail,
                            type: "POST",
                            dataType: 'html',
                            global: false,
                            async: false,
                            success: function (data) {
                                // alert(data);
                                // result = parseInt(data);
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(xhr.status);
                                alert(thrownError);
                            }
                        });

                        var box = $("#message-box-info");
                        if(box.length > 0){
                            box.toggleClass("open");
                            
                            var sound = box.data("sound");
                            
                            if(sound === 'alert')
                                playAudio('alert');
                            
                            if(sound === 'fail')
                                playAudio('fail');
                            
                        }        
                        return false;
                    }
                }

            });
            
            // alert($('#otp_check').val());

            if($('#otp_check').val()=="false") {
                return false;
            }

            // alert("Trueaaa");

            removeMultiInputNamingRules('#form_group', 'input[alt="groupusername[]"]');
            removeMultiInputNamingRules('#form_group', 'input[alt="groupuserlastname[]"]');
            removeMultiInputNamingRules('#form_group', 'input[alt="groupmobile[]"]');
            removeMultiInputNamingRules('#form_group', 'input[alt="groupemail[]"]');
            removeMultiInputNamingRules('#form_group', 'select[alt="userid[]"]');
            removeMultiInputNamingRules('#form_group', 'select[alt="userroleid[]"]');
            $('.selusername').each(function() {
                $(this).rules("remove");
            });
            $('.seluserrole').each(function() {
                $(this).rules("remove");
            });

            return true;
        }
    }
});


$("#otp_popup_form").validate({
    rules: {
        otp: {
            required: true,
            checkOTP: true
        }
    },

    ignore: false,
    onkeyup: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("checkOTP", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/groups/checkOTP',
        data: $("#otp_popup_form").serialize(),
        cache: false,
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });

    if (result) {
        return true;
    } else {
        return false;
    }
}, 'Please enter valid OTP.');

$("#check_otp").click(function(){
    // alert('check_otp');

    if ($("#otp_popup_form").valid()) {
        var result = 1;

        // $.ajax({
        //     url: BASE_URL+'index.php/groups/checkOTP',
        //     data: $("#otp_popup_form").serialize(),
        //     cache: false,
        //     type: "POST",
        //     dataType: 'html',
        //     global: false,
        //     async: false,
        //     success: function (data) {
        //         // alert(data);
        //         result = parseInt(data);
        //     },
        //     error: function (data) {
        //         // alert(data);
        //         result = 0;
        //     }
        // });

        // alert(result);

        if (result) {
            // alert(result);
            $(this).parents(".message-box").removeClass("open");
            $('#otp_check').val('true');
            $('#otp_email_id').val('');
            $('#otp').val('');
            $('#otp').removeClass('valid');
            // return false;

            removeMultiInputNamingRules('#form_group', 'input[alt="groupusername[]"]');
            removeMultiInputNamingRules('#form_group', 'input[alt="groupuserlastname[]"]');
            removeMultiInputNamingRules('#form_group', 'input[alt="groupmobile[]"]');
            removeMultiInputNamingRules('#form_group', 'input[alt="groupemail[]"]');
            removeMultiInputNamingRules('#form_group', 'select[alt="userid[]"]');
            removeMultiInputNamingRules('#form_group', 'select[alt="userroleid[]"]');
            $('.selusername').each(function() {
                $(this).rules("remove");
            });
            $('.seluserrole').each(function() {
                $(this).rules("remove");
            });

            result = 0;
    //            alert("success");
            $.ajax({
                url: BASE_URL+'index.php/groups/editGroup/'+$("#group_id").val(),
                data: $("#form_group").serialize(),
                cache: false,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    // alert(data);
                    result = parseInt(data);
                },
                error: function (data) {
                    // alert(data);
                    result = 0;
                }
            });

            // alert(result);

            // return false;
        } else {
            return false;
        }

        if(result==1){
            window.open(BASE_URL+'index.php/groups','_self');
        } else {
            return false;
        }
    }
});

$("#resend_otp").click(function(){
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/groups/send_otp',
        data: 'email_id='+$('#otp_email_id').val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            // alert(data);
            result = parseInt(data);
            if(result) {
                $('#resend_otp_status').html('OTP sent.');
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            $('#resend_otp_status').html('OTP sending failed.');
            //alert(xhr.status);
            //alert(thrownError);
			//alert(ajaxOptions);
        }
    });
});

function checkGroupUserAvailability() {
    var validator = $("#form_group").validate();
    var groupid = $('#group_id').val();
    var valid = true;
    var makerCnt = 0;
    var checkerCnt = 0;
    var adminCnt = 0;

    if($('.useremail').length>0) {
        $('.useremail').each(function(){
            var id = $(this).attr('id');
            var index = id.substr(id.lastIndexOf('_')+1);
            var groupuserid = $('#groupuserid_'+index).val();
            var groupusername = $('#groupusername_'+index).val();
            var groupuserlastname = $('#groupuserlastname_'+index).val();
            var groupmobile = $('#groupmobile_'+index).val();
            var groupemail = $('#groupemail_'+index).val();

            // alert(index + ' ' + groupuserid + ' ' + groupusername + ' ' + groupuserlastname + ' ' + groupmobile + ' ' + groupemail);
            // alert($('#groupusername_'+i).val() + ' ' + $('#groupuserlastname_'+i).val() + ' ' + $('#groupmobile_'+i).val() + ' ' + $('#groupemail_'+i).val());

            var result = 1;

            $.ajax({
                url: BASE_URL+'index.php/groups/check_contact_availablity',
                data: 'groupid='+groupid+'&groupuserid='+groupuserid+'&groupusername='+groupusername+'&groupuserlastname='+groupuserlastname+'&groupemail='+groupemail+'&groupmobile='+groupmobile,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if (result) {
                var errors = {};
                var name = $('#groupemail_'+index).attr('name');
                errors[name] = "First_name, Last_name, Email ID & Mobile No already in use.";
                validator.showErrors(errors);
                valid = false;
            }

            var result = 1;

            $.ajax({
                url: BASE_URL+'index.php/groups/check_email_availablity',
                data: 'groupid='+groupid+'&groupemail='+groupemail,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if (result) {
                var errors = {};
                var name = $('#groupemail_'+index).attr('name');
                errors[name] = "Entered email_id is already an owner of another group.";
                validator.showErrors(errors);
                valid = false;
            }

            result = 1;

            // alert(groupid + ' ' + groupuserid + ' ' + groupemail);

            $.ajax({
                url: BASE_URL+'index.php/groups/check_group_user_availablity',
                data: 'groupid='+groupid+'&guid='+groupuserid+'&emailid='+groupemail,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if(groupid != ""){
                if (result) {
                    var errors = {};
                    var name = $('#groupemail_'+index).attr('name');
                    // alert(1);
                    errors[name] = "Entered email_id is already an user of this group.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }

            var counter = $('.useremail').length;
            // for(i=index; i<=counter; i++) {
            for(i=counter; i>0; i--) {
                if ($('#groupemail_'+i).val()==groupemail && i!=index) {
                    var errors = {};
                    var name = $('#groupemail_'+i).attr('name');
                    errors[name] = "Email ID already in use.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
        });
    } else {
        var errors = {};
        var name = $('#group_name').attr('name');
        errors[name] = "Please add atleast one Admin.";
        validator.showErrors(errors);
        valid = false;
    }
    
    if($('.useremail').length>0){
        if($('.selusername').length>0) {
            $('.selusername').each(function() {
                var id = $(this).attr('id');
                var index = id.substr(id.lastIndexOf('_')+1);
                var guid = $('#guid_'+index).val();
                var userid = $('#userid_'+index).val();
                var userroleid = $('#userroleid_'+index).val();

                // alert(index + ' ' + userid + ' ' + userroleid);
                
                var result = 1;
                var useremail = "";

                $.ajax({
                    url: BASE_URL+'index.php/groups/check_user_availablity',
                    data: 'groupid='+groupid+'&guid='+guid+'&userid='+userid,
                    type: "POST",
                    dataType: 'json',
                    global: false,
                    async: false,
                    success: function (data) {
                        // alert(groupid.toString() + ' ' + guid.toString() + ' ' + userid.toString());
                        useremail = data.email_id;
                        result = parseInt(data.result);
                        // alert(useremail + ' ' + result);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });

                if(groupid != ""){
                    if (result) {
                        var errors = {};
                        var name = $('#userid_'+index).attr('name');
                        errors[name] = "User already exist in this group.";
                        validator.showErrors(errors);
                        valid = false;
                    }
                }

                var counter = $('.useremail').length;
                // for(i=1; i<=counter; i++) {
                for(i=counter; i>0; i--) {
                    if ($('#groupemail_'+i).val()==useremail) {
                        var errors = {};
                        var name = $('#userid_'+index).attr('name');
                        errors[name] = "User already exist in this group.";
                        validator.showErrors(errors);
                        valid = false;
                    }
                }

                var counter = $('.selusername').length;
                // for(i=index; i<=counter; i++) {
                for(i=counter; i>0; i--) {
                    if ($('#userid_'+i).val()==userid && i!=index) {
                        var errors = {};
                        var name = $('#userid_'+i).attr('name');
                        errors[name] = "User already selected";
                        validator.showErrors(errors);
                        valid = false;
                    }
                }
            });
            
            $('.seluserrole').each(function() {
                if($(this).val()=="3") {
                    makerCnt = makerCnt + 1;
                }
                if($(this).val()=="4") {
                    checkerCnt = checkerCnt + 1;
                }
                if($(this).val()=="1") {
                    adminCnt = adminCnt + 1;
                }
            });

            if (makerCnt==0) {
                var errors = {};
                var name = $('#userroleid_1').attr('name');
                errors[name] = "Please add atleast one Maker.";
                validator.showErrors(errors);
                valid = false;
            }
            if (checkerCnt==0) {
                var errors = {};
                var name = $('#userroleid_1').attr('name');
                errors[name] = "Please add atleast one Checker.";
                validator.showErrors(errors);
                valid = false;
            }
            if (adminCnt==0) {
                var errors = {};
                var name = $('#userroleid_1').attr('name');
                errors[name] = "Please add atleast one Admin.";
                validator.showErrors(errors);
                valid = false;
            }
        } else {
            if (makerCnt==0) {
                var errors = {};
                var name = $('#group_name').attr('name');
                errors[name] = "Please add atleast one Maker.";
                validator.showErrors(errors);
                valid = false;
            }
            if (checkerCnt==0) {
                var errors = {};
                var name = $('#group_name').attr('name');
                errors[name] = "Please add atleast one Checker.";
                validator.showErrors(errors);
                valid = false;
            }
            if (adminCnt==0) {
                var errors = {};
                var name = $('#group_name').attr('name');
                errors[name] = "Please add atleast one Admin.";
                validator.showErrors(errors);
                valid = false;
            }
        }
    }
    
    return valid;
}




// ----------------- ADMIN USER ASSIGN DETAILS FORM VALIDATION -------------------------------------
$("#form_admin_user_assign_details").validate({
    rules: {
        con_first_name: {
            required: true,
            lettersonly: true
        },
        con_middle_name: {
            lettersonly: true
        },
        con_last_name: {
            required: true,
            lettersonly: true
        },
        con_email_id1: {
            required: true,
            checkemail: true,
            checkUserEmailAvailability: true
        },
        con_mobile_no1: {
            required: true,
            numbersonly: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("checkUserEmailAvailability", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Assign/checkUserEmailAvailability',
        data: 'gu_cid='+$("#c_id").val() + '&gu_email='+$("#con_email_id1").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'User email already exist');

$('#form_admin_user_assign_details').submit(function() {
    if (!$("#form_admin_user_assign_details").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- USER ASSIGN DETAILS FORM VALIDATION -------------------------------------
$("#form_user_assign_details").validate({
    rules: {
        contact_name: {
            required: true,
            checkUserContactAvailability: true,
            checkAdminEmailAvailability: true
        },
        role: {
            required: true
        },
        assure: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("checkUserContactAvailability", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Assign/checkUserEmailAvailability',
        data: 'gu_cid='+$("#c_id").val() + '&gu_email='+$("#email").html(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Selected contact already exist in this group.');

$.validator.addMethod("checkAdminEmailAvailability", function (value, element) {
    var result = 1;

    if($('#role').val()=='1'){
        $.ajax({
            url: BASE_URL+'index.php/Assign/checkAdminEmailAvailability',
            data: 'gu_cid='+$("#c_id").val() + '&gu_email='+$("#email").html(),
            type: "POST",
            dataType: 'html',
            global: false,
            async: false,
            success: function (data) {
                result = parseInt(data);
            },
          error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
        });
    } else {
        result = 0;
    }
    
    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Selected contact is already an admin of another group.');

$('#form_user_assign_details').submit(function() {
    if (!$("#form_user_assign_details").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- USER ROLE DETAILS FORM VALIDATION -------------------------------------
$("#form_user_role_details").validate({
    rules: {
        role: {
            required: true,
            checkRoleAvailability: true
            // ,
            // checkAtleastOneCheck: true
        }
    },

    ignore: false,
    onkeyup: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("checkRoleAvailability", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/manage/checkRoleAvailability',
        data: 'rl_id='+$("#rl_id").val() + '&role_name='+$("#role_name").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'User Role already exist.');

// $.validator.addMethod("checkAtleastOneCheck", function (value, element) {
//     var result = 1;

//     $('.cls_chk').each(function(){
//         if ($(this).is(":checked")) result=0;
//     });

//     if (result) {
//         return false;
//     } else {
//         return true;
//     }
// }, 'Please assign atleast one role.');

$('#form_user_role_details').submit(function() {
    if (!$("#form_user_role_details").valid()) {
        return false;
    } else {
        if (checkRole()==false) {
            return false;
        }

        return true;
    }
});

function checkRole() {
    var validator = $("#form_user_role_details").validate();
    var valid = true;

    var result = 1;

    $('.cls_chk').each(function(){
        if ($(this).is(":checked")) result=0;
    });

    if (result) {
        var errors = {};
        var name = "role";
        errors[name] = "Please assign atleast one role.";
        validator.showErrors(errors);
        valid = false;
    }

    return valid;
}



// ----------------- DOCUMENTS FORM VALIDATION -------------------------------------
$("#form_documets").validate({
    rules: {
        doc_name: {
            required: true,
            checkDocumentAvailability: true
        },
        doc_type: {
            required: true
        },
        status: {
            required: true
        },
        purchase: {
            checkTransactionTypeSelected: true
        },
        owner: {
            required: function(element) {
                        if($('#status').val()=="Non Transactional"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        individual: {
            checkCategorySelected: true
        },
        building: {
            checkTypeSelected: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("checkDocumentAvailability", function (value, element) {
    var result = 1;
    $.ajax({
        url: BASE_URL+'index.php/documents/checkDocumentAvailability',
        data: 'doc_id='+$("#doc_id").val() + '&doc_name='+$("#doc_name").val() + '&doc_type='+$("#doc_type").val() + 
              '&status='+$("#status").val() + '&individual='+$("#individual").is(":checked") + 
              '&huf='+$("#huf").is(":checked") + '&privateltd='+$("#privateltd").is(":checked") + 
              '&ltd='+$("#ltd").is(":checked") + '&llp='+$("#llp").is(":checked") + 
              '&partnership='+$("#partnership").is(":checked") + '&aop='+$("#aop").is(":checked") + 
              '&trust='+$("#trust").is(":checked") + '&proprietorship='+$("#proprietorship").is(":checked") + 
              '&building='+$("#building").is(":checked") + 
              '&apartment='+$("#apartment").is(":checked") + '&bunglow='+$("#bunglow").is(":checked") + 
              '&commercial='+$("#commercial").is(":checked") + '&retail='+$("#retail").is(":checked") + 
              '&industry='+$("#industry").is(":checked") + '&landagri='+$("#landagri").is(":checked") + 
              '&landnonagri='+$("#landnonagri").is(":checked"),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Document name already exist');

$.validator.addMethod("checkTransactionTypeSelected", function (value, element) {
    var result = 1;

    if($('#status').val()=="Transactional"){
        if($('#purchase').is(':checked') || $('#sale').is(':checked') || $('#rent').is(':checked') || $('#loan').is(':checked')) {
            result = 0;
        }
    } else {
        result = 0;
    }

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Please select atleast one transaction type');

$.validator.addMethod("checkCategorySelected", function (value, element) {
    var result = 1;

    if($('#status').val()=="Non Transactional"){
        if($('#individual').is(':checked') || $('#huf').is(':checked') || $('#privateltd').is(':checked') || 
            $('#ltd').is(':checked') || $('#llp').is(':checked') || $('#partnership').is(':checked') || 
            $('#aop').is(':checked') || $('#trust').is(':checked') || $('#proprietorship').is(':checked')) {
                result = 0;
        }
    } else {
        result = 0;
    }

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Please select atleast one category');

$.validator.addMethod("checkTypeSelected", function (value, element) {
    var result = 1;

    if($('#status').val()=="Transactional"){
        if($('#building').is(':checked') || $('#apartment').is(':checked') || $('#bunglow').is(':checked') || 
            $('#commercial').is(':checked') || $('#retail').is(':checked') || $('#industry').is(':checked') || 
            $('#landagri').is(':checked') || $('#landnonagri').is(':checked')) {
                result = 0;
        }
    } else {
        result = 0;
    }

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Please select atleast one property type');

$('#form_documets').submit(function() {
    if (!$("#form_documets").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- Indexation FORM VALIDATION -------------------------------------
$("#form_indexation").validate({
    rules: {
        financial_year: {
            required: true,
            checkYearFormat: true,
            checkIndexYearAvailability: true
        },
        cost_inflation_index: {
            required: true,
            numbersandcommaonly: true
        }
    },

    ignore: false,
    onkeyup: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("checkIndexYearAvailability", function (value, element) {
    var result = 1;
    $.ajax({
        url: BASE_URL+'index.php/indexation/checkIndexYearAvailability',
        data: 'i_id='+$("#i_id").val() + '&financial_year='+$("#financial_year").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Indexation year already exist');

$.validator.addMethod("checkYearFormat", function(value, element) {
    return this.optional(element) || /^([0-9]{4}-[0-9]{2})+$/i.test(value);
}, "Please enter year in proper format (e.g. '2010-11')");

$('#form_indexation').submit(function() {
    if (!$("#form_indexation").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- BANK FORM VALIDATION -------------------------------------
$("#form_bank").validate({
    rules: {
        owner_name: {
            required: true
        },
        registered_phone: {
            numbersonly: true
        },
        registered_email: {
            checkemail: true
        },
        bank_name: {
            required: true
        },
        bank_branch: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        bank_address: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        bank_pincode: {
            numbersonly: true
        },
        account_type: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        account_no: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        ifsc: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        phone_no: {
            numbersonly: true
        }
    },

    messages: {
        owner_name: {
            required: "Select correct owner from list"
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    },

    invalidHandler: function(e,validator) {
        var errors="";
        if ($('#panel-bank-details').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in bank details. <br/>";
        }
        if ($('#panel-authorised_signatory').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in Authorised Signatory. <br/>";
        }
        
        $('#form_errors').html(errors);

        if(errors!=""){
            $('#form_errors').show();
        } else {
            $('#form_errors').hide();
        }
    }
});

$('#form_bank').submit(function() {
    var submitVal = $(document.activeElement).val();
    removeMultiInputNamingRules('#form_bank', 'select[alt="auth_name[]"]');
    removeMultiInputNamingRules('#form_bank', 'select[alt="auth_type[]"]');

    if(submitVal!="Save"){
        $("#submitVal").val('0');
    } else {
        $("#submitVal").val('1');
    }

    addMultiInputNamingRules('#form_bank', 'select[name="auth_name[]"]', { required: function(element) {
                                                                                    if($("#submitVal").val()=="0"){
                                                                                        return true;
                                                                                    } else {
                                                                                        return false;
                                                                                    }
                                                                                }, 
                                                                        messages: {required: "Select correct contact from list"} 
                                                                    }, "");
    addMultiInputNamingRules('#form_bank', 'select[name="auth_type[]"]', { required: function(element) {
                                                                                        if($("#submitVal").val()=="0"){
                                                                                            return true;
                                                                                        } else {
                                                                                            return false;
                                                                                        }
                                                                                    } 
                                                                            }, "");

    if (!$("#form_bank").valid()) {
        return false;
    } else {
        if (checkAuthSign()==false) {
            return false;
        }

        removeMultiInputNamingRules('#form_bank', 'select[alt="auth_name[]"]');
        removeMultiInputNamingRules('#form_bank', 'select[alt="auth_type[]"]');

        return true;
    }
});

function checkAuthSign() {
    var validator = $("#form_bank").validate();
    var valid = true;
    var jointCnt = 0;
    var jointIndex = 1;
    var counter = $('.auth_name').length;

    if (counter==0) {
        if($("#submitVal").val()=="0"){
            var errors = {};
            var name = $('#owner_name_id').attr('name');
            errors[name] = "Add atleast one authorised signatory";
            validator.showErrors(errors);
            valid = false;
        }
    }

    $('.auth_name').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        var auth_name_id = $('#auth_name_'+index).val();
        var auth_type = $('#auth_type_'+index).val();

        for(i=counter; i>0; i--) {
            if ($('#auth_name_'+i).val()==auth_name_id && i!=index) {
                    var errors = {};
                    var name = $('#auth_name_'+i).attr('name');
                    errors[name] = "Select different contacts for all records";
                    validator.showErrors(errors);
                    valid = false;
            }
        }

        if(auth_type=="Joint"){
            jointCnt=jointCnt+1;
            jointIndex=index;
        }
    });

    if(jointCnt==1) {
        var errors = {};
        var name = $('#auth_type_'+jointIndex).attr('name');
        errors[name] = "Add atleast two records for joint authorisation";
        validator.showErrors(errors);
        valid = false;
    }
    
    return valid;
}




// ----------------- Owner Individual FORM VALIDATION -------------------------------------
$("#form_individual").validate({
    rules: {
        individual_client: {
            required: true
        }
    },

    messages: {
        individual_client: {
            required: "Select correct contact from list"
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_individual').submit(function() {
    if (!$("#form_individual").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- OWNER FORM VALIDATION -------------------------------------
$("#form_owner").validate({
    rules: {
        company_name: {
            required: true
        },
        incop_date: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        address: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        city: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        state: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        pincode: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        },
        contact_id: {
            required: true
        },
        mob_number: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        },
        // invoice_format: {
        //     required: true
        // },
        // invoice_no: {
        //     required: true,
        //     numbersonly: true
        // }
    },

    messages: {contact_id: {required: "Select correct contact from list"}},

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_owner').submit(function() {
    removeMultiInputNamingRules('#form_owner', '.doc_name');
    removeMultiInputNamingRules('#form_owner', 'select[alt="family[]"]');
    removeMultiInputNamingRules('#form_owner', 'input[alt="relation[]"]');
    removeMultiInputNamingRules('#form_owner', 'select[alt="director[]"]');
    removeMultiInputNamingRules('#form_owner', 'select[alt="shareholder[]"]');
    removeMultiInputNamingRules('#form_owner', 'input[alt="shareholder_percent[]"]');
    removeMultiInputNamingRules('#form_owner', 'input[alt="no_of_shares[]"]');
    removeMultiInputNamingRules('#form_owner', 'select[alt="partnership[]"]');
    removeMultiInputNamingRules('#form_owner', 'input[alt="partnership_percent[]"]');
    removeMultiInputNamingRules('#form_owner', 'select[alt="trustee[]"]');
    removeMultiInputNamingRules('#form_owner', 'select[alt="beneficiary[]"]');
    removeMultiInputNamingRules('#form_owner', 'input[alt="beneficiary_percent[]"]');
    removeMultiInputNamingRules('#form_owner', 'select[alt="owner[]"]');

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


    if (!$("#form_owner").valid()) {
        return false;
    } else {
        if (checkOtherDetails()==false) {
            return false;
        }
        removeMultiInputNamingRules('#form_owner', '.doc_name');
        removeMultiInputNamingRules('#form_owner', 'select[alt="family[]"]');
        removeMultiInputNamingRules('#form_owner', 'input[alt="relation[]"]');
        removeMultiInputNamingRules('#form_owner', '.doc_name');
        removeMultiInputNamingRules('#form_owner', 'select[alt="director[]"]');
        removeMultiInputNamingRules('#form_owner', 'select[alt="shareholder[]"]');
        removeMultiInputNamingRules('#form_owner', 'input[alt="shareholder_percent[]"]');
        removeMultiInputNamingRules('#form_owner', 'input[alt="no_of_shares[]"]');
        removeMultiInputNamingRules('#form_owner', 'select[alt="partnership[]"]');
        removeMultiInputNamingRules('#form_owner', 'input[alt="partnership_percent[]"]');
        removeMultiInputNamingRules('#form_owner', 'select[alt="trustee[]"]');
        removeMultiInputNamingRules('#form_owner', 'select[alt="beneficiary[]"]');
        removeMultiInputNamingRules('#form_owner', 'input[alt="beneficiary_percent[]"]');
        removeMultiInputNamingRules('#form_owner', 'select[alt="owner[]"]');
        return true;
    }
});

function checkOtherDetails() {
    var validator = $("#form_owner").validate();
    var valid = true;

    if($('#family-section').is(":visible")){
        var counter = $('.family_details').length;
        $('.family_details').each(function() {
            var family_member_id = $(this).val();
            // var contact_id = $('#contact_id').val();
            // if(family_member_id==contact_id) {
            //     var errors = {};
            //     var name = $(this).attr('name');
            //     errors[name] = "Select different contact than Karta Name";
            //     validator.showErrors(errors);
            //     valid = false;
            // }

            var c_id = $('#c_id').val();
            if(family_member_id==c_id) {
                var errors = {};
                var name = $(this).attr('name');
                errors[name] = "Select different contact than current owner";
                validator.showErrors(errors);
                valid = false;
            }
        });
    }
    
    if($('#shareholder-section').is(":visible")){
        var shareholder_percent = 0;
        var counter = $('.shareholder_details').length;
        $('.shareholder_details').each(function() {
            var id = $(this).attr('id');
            var index = id.substr(id.lastIndexOf('_')+1);

            var shareholder_details_id = $('#shareholder_details_'+index).val();
            
            for(i=counter; i>0; i--) {
                if ($('#shareholder_details_'+i).val()==shareholder_details_id && i!=index) {
                        var errors = {};
                        var name = $('#shareholder_details_'+i).attr('name');
                        errors[name] = "Select different owners for all records";
                        validator.showErrors(errors);
                        valid = false;
                }
            }

            shareholder_percent = shareholder_percent + parseInt($('#shareholder_percent_'+index).val());
        });

        if($("#submitVal").val()=="0"){
            if (counter<2) {
                    var errors = {};
                    var name = $('#shareholder_details_1').attr('name');
                    errors[name] = "Add atleast two shareholders";
                    validator.showErrors(errors);
                    valid = false;
            } else {
                if(shareholder_percent!=100) {
                    var errors = {};
                    var name = $('#shareholder_details_1').attr('name');
                    errors[name] = "Shareholding total should be 100%";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
        }
    }

    if($('#partnership-section').is(":visible")){
        var partnership_percent = 0;
        var counter = $('.partnership_details').length;
        $('.partnership_details').each(function() {
            var id = $(this).attr('id');
            var index = id.substr(id.lastIndexOf('_')+1);

            var partnership_details_id = $('#partnership_details_'+index).val();
            
            for(i=counter; i>0; i--) {
                if ($('#partnership_details_'+i).val()==partnership_details_id && i!=index) {
                        var errors = {};
                        var name = $('#partnership_details_'+i).attr('name');
                        errors[name] = "Select different owners for all records";
                        validator.showErrors(errors);
                        valid = false;
                }
            }

            partnership_percent = partnership_percent + parseInt($('#partnership_percent_'+index).val());
        });

        if($("#submitVal").val()=="0"){
            if (counter<2) {
                    var errors = {};
                    var name = $('#partnership_details_1').attr('name');
                    errors[name] = "Add atleast two partners";
                    validator.showErrors(errors);
                    valid = false;
            } else {
                if(partnership_percent!=100) {
                    var errors = {};
                    var name = $('#partnership_details_1').attr('name');
                    errors[name] = "Partnership total should be 100%";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
        }
    }

    if($('#beneficiary-section').is(":visible")){
        var beneficiary_percent = 0;
        var counter = $('.beneficiary_details').length;

        $('.beneficiary_details').each(function() {
            var id = $(this).attr('id');
            var index = id.substr(id.lastIndexOf('_')+1);

            var beneficiary_details_id = $('#beneficiary_details_'+index).val();
            
            for(i=counter; i>0; i--) {
                if ($('#beneficiary_details_'+i).val()==beneficiary_details_id && i!=index) {
                        var errors = {};
                        var name = $('#beneficiary_details_'+i).attr('name');
                        errors[name] = "Select different owners for all records";
                        validator.showErrors(errors);
                        valid = false;
                }
            }
            
            beneficiary_percent = beneficiary_percent + parseInt($('#beneficiary_percent_'+index).val());
        });

        if($("#submitVal").val()=="0"){
            if (counter<2) {
                    var errors = {};
                    var name = $('#beneficiary_details_1').attr('name');
                    errors[name] = "Add atleast two beneficiary";
                    validator.showErrors(errors);
                    valid = false;
            } else {
                if(beneficiary_percent!=100) {
                    var errors = {};
                    var name = $('#beneficiary_details_1').attr('name');
                    errors[name] = "Beneficiary total should be 100%";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
        }
    }

    return valid;
}




// ----------------- OWNER HUF FORM VALIDATION -------------------------------------
$("#form_huf").validate({
    rules: {
        huf_name: {
            required: true
        },
        huf_doi: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        huf_address: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        huf_addr_city: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        huf_addr_state: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        huf_addr_pincode: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        },
        huf_karta_name: {
            required: true
        }
    },

    messages: {huf_karta_name: {required: "Select correct owner from list"}},

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_huf').submit(function() {
    removeMultiInputNamingRules('#form_huf', '.doc_name');
    // removeMultiInputNamingRules('#form_huf', 'input[alt="family_details[]"]');
    removeMultiInputNamingRules('#form_huf', 'select[alt="family_details[]"]');
    removeMultiInputNamingRules('#form_huf', 'input[alt="relation[]"]');

    addMultiInputNamingRules('#form_huf', '.doc_name', { required:function(element) {
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

    // addMultiInputNamingRules('#form_huf', 'input[name="family_details[]"]', { required: function(element) {
    //                                                     if($("#submitVal").val()=="0"){
    //                                                         return true;
    //                                                     } else {
    //                                                         return false;
    //                                                     }
    //                                                 }, 
    //                                                 messages: {required: "Select correct owner from list"}
    //                                 }, "");
    addMultiInputNamingRules('#form_huf', 'select[name="family_details[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
    addMultiInputNamingRules('#form_huf', 'input[name="relation[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }
                                }, "");

    if (!$("#form_huf").valid()) {
        return false;
    } else {
        if (checkFamilyDetails()==false) {
            return false;
        }
        removeMultiInputNamingRules('#form_huf', '.doc_name');
        // removeMultiInputNamingRules('#form_huf', 'input[alt="family_details[]"]');
        removeMultiInputNamingRules('#form_huf', 'select[alt="family_details[]"]');
        removeMultiInputNamingRules('#form_huf', 'input[alt="relation[]"]');
        return true;
    }
});

function checkFamilyDetails() {
    var validator = $("#form_huf").validate();
    var valid = true;
    var counter = $('.family_details').length;

    $('.family_details').each(function() {
        var family_member_id = $(this).val();
        var huf_karta_id = $('#huf_karta_id').val();
        if(family_member_id==huf_karta_id) {
            var errors = {};
            var name = $(this).attr('name');
            errors[name] = "Select different owner than Karta Name";
            validator.showErrors(errors);
            valid = false;
        }


        var o_id = $('#o_id').val();
        if(family_member_id==o_id) {
            var errors = {};
            var name = $(this).attr('name');
            errors[name] = "Select different owner than current owner";
            validator.showErrors(errors);
            valid = false;
        }

        // var id = $(this).attr('id');
        // var index = id.substr(id.lastIndexOf('_')+1);
        // var shareholder_details_id = $('#shareholder_details_'+index+'_id').val();
        
        // for(i=counter; i>0; i--) {
        //     if ($('#shareholder_details_'+i+'_id').val()==shareholder_details_id && i!=index) {
        //             var errors = {};
        //             var name = $('#shareholder_details_'+i).attr('name');
        //             errors[name] = "Select different owners for all records";
        //             validator.showErrors(errors);
        //             valid = false;
        //     }
        // }

        // shareholder_percent = shareholder_percent + parseInt($('#shareholder_percent_'+index).val());
    });

    return valid;
}




// ----------------- OWNER PVT LTD FORM VALIDATION -------------------------------------
$("#form_private_limited").validate({
    rules: {
        company_name: {
            required: true
        },
        date_of_incorporation: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        pvtltd_address: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        pvtltd_addr_city: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        pvtltd_addr_state: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        pvtltd_addr_pincode: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        },
        contact_person_name: {
            required: true
        },
        telephone_number: {
            numbersonly: true
        },
        mob_number: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_private_limited').submit(function() {
    removeMultiInputNamingRules('#form_private_limited', '.doc_name');
    removeMultiInputNamingRules('#form_private_limited', 'input[alt="director_details[]"]');
    removeMultiInputNamingRules('#form_private_limited', 'input[alt="shareholder_details[]"]');
    removeMultiInputNamingRules('#form_private_limited', 'input[alt="shareholder_percent[]"]');
    removeMultiInputNamingRules('#form_private_limited', 'input[alt="no_of_shares[]"]');

    addMultiInputNamingRules('#form_private_limited', '.doc_name', { required:function(element) {
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

    addMultiInputNamingRules('#form_private_limited', 'input[name="director_details[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
    addMultiInputNamingRules('#form_private_limited', 'input[name="shareholder_details[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
    addMultiInputNamingRules('#form_private_limited', 'input[name="shareholder_percent[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                },
                                                numbersonly: true
                                }, "");
    addMultiInputNamingRules('#form_private_limited', 'input[name="no_of_shares[]"]', {numbersonly: true}, "");

    if (!$("#form_private_limited").valid()) {
        return false;
    } else {
        if (checkShareHolderDetails()==false) {
            return false;
        }
        removeMultiInputNamingRules('#form_private_limited', '.doc_name');
        removeMultiInputNamingRules('#form_private_limited', 'input[alt="director_details[]"]');
        removeMultiInputNamingRules('#form_private_limited', 'input[alt="shareholder_details[]"]');
        removeMultiInputNamingRules('#form_private_limited', 'input[alt="shareholder_percent[]"]');
        removeMultiInputNamingRules('#form_private_limited', 'input[alt="no_of_shares[]"]');
        return true;
    }
});

function checkShareHolderDetails() {
    var validator = $("#form_private_limited").validate();
    var valid = true;
    var shareholder_percent = 0;
    var counter = $('.shareholder').length;

    $('.shareholder').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        // var shareholder_details_id = $('#shareholder_details_'+index+'_id').val();
        
        // for(i=counter; i>0; i--) {
        //     if ($('#shareholder_details_'+i+'_id').val()==shareholder_details_id && i!=index) {
        //             var errors = {};
        //             var name = $('#shareholder_details_'+i).attr('name');
        //             errors[name] = "Select different owners for all records";
        //             validator.showErrors(errors);
        //             valid = false;
        //     }
        // }

        shareholder_percent = shareholder_percent + parseInt($('#shareholder_percent_'+index).val());
    });

    if($("#submitVal").val()=="0"){
        if (counter<2) {
                var errors = {};
                var name = $('#shareholder_details_1').attr('name');
                errors[name] = "Add atleast two shareholders";
                validator.showErrors(errors);
                valid = false;
        } else {
            if(shareholder_percent!=100) {
                var errors = {};
                var name = $('#shareholder_details_1').attr('name');
                errors[name] = "Shareholding total should be 100%";
                validator.showErrors(errors);
                valid = false;
            }
        }
    }
    
    return valid;
}




// ----------------- OWNER LTD FORM VALIDATION -------------------------------------
$("#form_limited").validate({
    rules: {
        company_name: {
            required: true
        },
        date_of_incorporation: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        registered_address: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        ltd_addr_city: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        ltd_addr_pincode: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        },
        ltd_addr_state: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        contact_person_name: {
            required: true
        },
        telephone_number: {
            numbersonly: true
        },
        mob_number: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_limited').submit(function() {
    removeMultiInputNamingRules('#form_limited', '.doc_name');
    removeMultiInputNamingRules('#form_limited', 'input[alt="director_details[]"]');
    removeMultiInputNamingRules('#form_limited', 'input[alt="shareholder_details[]"]');
    removeMultiInputNamingRules('#form_limited', 'input[alt="shareholder_percent[]"]');
    removeMultiInputNamingRules('#form_limited', 'input[alt="no_of_shares[]"]');

    addMultiInputNamingRules('#form_limited', '.doc_name', { required:function(element) {
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

    addMultiInputNamingRules('#form_limited', 'input[name="director_details[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
    addMultiInputNamingRules('#form_limited', 'input[name="shareholder_details[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
    addMultiInputNamingRules('#form_limited', 'input[name="shareholder_percent[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                },
                                                numbersonly: true
                                }, "");
    addMultiInputNamingRules('#form_limited', 'input[name="no_of_shares[]"]', {numbersonly: true}, "");

    if (!$("#form_limited").valid()) {
        return false;
    } else {
        if (checkLimitedShareHolderDetails()==false) {
            return false;
        }
        removeMultiInputNamingRules('#form_limited', '.doc_name');
        removeMultiInputNamingRules('#form_limited', 'input[alt="director_details[]"]');
        removeMultiInputNamingRules('#form_limited', 'input[alt="shareholder_details[]"]');
        removeMultiInputNamingRules('#form_limited', 'input[alt="shareholder_percent[]"]');
        removeMultiInputNamingRules('#form_limited', 'input[alt="no_of_shares[]"]');
        return true;
    }
});

function checkLimitedShareHolderDetails() {
    var validator = $("#form_limited").validate();
    var valid = true;
    var shareholder_percent = 0;
    var counter = $('.shareholder').length;

    $('.shareholder').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        // var shareholder_details_id = $('#shareholder_details_'+index+'_id').val();
        
        // for(i=counter; i>0; i--) {
        //     if ($('#shareholder_details_'+i+'_id').val()==shareholder_details_id && i!=index) {
        //             var errors = {};
        //             var name = $('#shareholder_details_'+i).attr('name');
        //             errors[name] = "Select different owners for all records";
        //             validator.showErrors(errors);
        //             valid = false;
        //     }
        // }

        shareholder_percent = shareholder_percent + parseInt($('#shareholder_percent_'+index).val());
    });

    if($("#submitVal").val()=="0"){
        if (counter<2) {
                var errors = {};
                var name = $('#shareholder_details_1').attr('name');
                errors[name] = "Add atleast two shareholders";
                validator.showErrors(errors);
                valid = false;
        } else {
            if(shareholder_percent!=100) {
                var errors = {};
                var name = $('#shareholder_details_1').attr('name');
                errors[name] = "Shareholding total should be 100%";
                validator.showErrors(errors);
                valid = false;
            }
        }
    }
    
    return valid;
}




// ----------------- OWNER LLP FORM VALIDATION -------------------------------------
$("#form_llp").validate({
    rules: {
        organisation_name: {
            required: true
        },
        date_of_incorporation: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        registered_address: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        llp_addr_city: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        llp_addr_pincode: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        },
        llp_addr_state: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        prt_addr_city: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        prt_addr_pincode: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        },
        prt_addr_state: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        aop_addr_city: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        aop_addr_pincode: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        },
        aop_addr_state: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        contact_person_name: {
            required: true
        },
        telephone_number: {
            numbersonly: true
        },
        mob_number: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_llp').submit(function() {
    removeMultiInputNamingRules('#form_llp', '.doc_name');
    removeMultiInputNamingRules('#form_llp', 'input[alt="partner_details[]"]');
    removeMultiInputNamingRules('#form_llp', 'input[alt="partner_percent[]"]');

    addMultiInputNamingRules('#form_llp', '.doc_name', { required:function(element) {
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

    addMultiInputNamingRules('#form_llp', 'input[name="partner_details[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
    addMultiInputNamingRules('#form_llp', 'input[name="partner_percent[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                },
                                                numbersonly: true
                                }, "");

    if (!$("#form_llp").valid()) {
        return false;
    } else {
        if (checkPartnerDetailsLLP()==false) {
            return false;
        }
        removeMultiInputNamingRules('#form_llp', '.doc_name');
        removeMultiInputNamingRules('#form_llp', 'input[alt="partner_details[]"]');
        removeMultiInputNamingRules('#form_llp', 'input[alt="partner_percent[]"]');
        return true;
    }
});

function checkPartnerDetailsLLP() {
    var validator = $("#form_llp").validate();
    var valid = true;
    var partnership_percent = 0;
    var counter = $('.partnership').length;

    $('.partnership').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        // var partner_details_id = $('#partner_details_'+index+'_id').val();
        
        // for(i=counter; i>0; i--) {
        //     if ($('#partner_details_'+i+'_id').val()==partner_details_id && i!=index) {
        //             var errors = {};
        //             var name = $('#partner_details_'+i).attr('name');
        //             errors[name] = "Select different owners for all records";
        //             validator.showErrors(errors);
        //             valid = false;
        //     }
        // }

        partnership_percent = partnership_percent + parseInt($('#partner_percent_'+index).val());
    });

    if($("#submitVal").val()=="0"){
        if (counter<2) {
                var errors = {};
                var name = $('#partner_details_1').attr('name');
                errors[name] = "Add atleast two partners";
                validator.showErrors(errors);
                valid = false;
        } else {
            if(partnership_percent!=100) {
                var errors = {};
                var name = $('#partner_details_1').attr('name');
                errors[name] = "Partnership total should be 100%";
                validator.showErrors(errors);
                valid = false;
            }
        }
    }
    
    return valid;
}




// ----------------- OWNER AOP FORM VALIDATION -------------------------------------
$("#form_aop").validate({
    rules: {
        organisation_name: {
            required: true
        },
        date_of_incorporation: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        registered_address: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        aop_addr_city: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        aop_addr_pincode: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        },
        aop_addr_state: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        contact_person_name: {
            required: true
        },
        telephone_number: {
            numbersonly: true
        },
        mob_number: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_aop').submit(function() {
    // removeMultiInputNamingRules('#form_aop', '.doc_name');
    removeMultiInputNamingRules('#form_aop', 'input[alt="partner_details[]"]');
    removeMultiInputNamingRules('#form_aop', 'input[alt="partner_percent[]"]');

    // addMultiInputNamingRules('#form_aop', '.doc_name', { required:function(element) {
    //                                                                                 if($("#submitVal").val()=="0"){
    //                                                                                     return true;
    //                                                                                 } else {
    //                                                                                     return false;
    //                                                                                 }
    //                                                                             }
    //                                                         }, "Document");
    // $('input.doc_file').each(function() {
    //     $(this).rules("remove");
    // });
    // $('input.doc_file').each(function() {
    //     var id = $(this).attr('id');
    //     var index = id.substr(id.lastIndexOf('_')+1);
    //     if($('#d_m_status_'+index).val()=="Yes") {
    //         if($('#doc_file_download_'+index).length==0) {
    //             $(this).rules("add", { required: function(element) {
    //                                                 if($("#submitVal").val()=="0"){
    //                                                     return true;
    //                                                 } else {
    //                                                     return false;
    //                                                 }
    //                                             }
    //                             });
    //         }
    //     }
    // });

    addMultiInputNamingRules('#form_aop', 'input[name="partner_details[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
    addMultiInputNamingRules('#form_aop', 'input[name="partner_percent[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                },
                                                numbersonly: true
                                }, "");

    if (!$("#form_aop").valid()) {
        return false;
    } else {
        if (checkPartnerDetailsAOP()==false) {
            return false;
        }
        // removeMultiInputNamingRules('#form_aop', '.doc_name');
        removeMultiInputNamingRules('#form_aop', 'input[alt="partner_details[]"]');
        removeMultiInputNamingRules('#form_aop', 'input[alt="partner_percent[]"]');
        return true;
    }
});

function checkPartnerDetailsAOP() {
    var validator = $("#form_aop").validate();
    var valid = true;
    var partnership_percent = 0;
    var counter = $('.partnership').length;

    $('.partnership').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        // var partner_details_id = $('#partner_details_'+index+'_id').val();
        
        // for(i=counter; i>0; i--) {
        //     if ($('#partner_details_'+i+'_id').val()==partner_details_id && i!=index) {
        //             var errors = {};
        //             var name = $('#partner_details_'+i).attr('name');
        //             errors[name] = "Select different owners for all records";
        //             validator.showErrors(errors);
        //             valid = false;
        //     }
        // }

        partnership_percent = partnership_percent + parseInt($('#partner_percent_'+index).val());
    });

    if($("#submitVal").val()=="0"){
        if (counter<2) {
                var errors = {};
                var name = $('#partner_details_1').attr('name');
                errors[name] = "Add atleast two partners";
                validator.showErrors(errors);
                valid = false;
        } else {
            if(partnership_percent!=100) {
                var errors = {};
                var name = $('#partner_details_1').attr('name');
                errors[name] = "Partnership total should be 100%";
                validator.showErrors(errors);
                valid = false;
            }
        }
    }
    
    return valid;
}




// ----------------- OWNER TRUST FORM VALIDATION -------------------------------------
$("#form_trust").validate({
    rules: {
        trust_name: {
            required: true
        },
        date_of_incorporation: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        registered_address: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        trs_addr_city: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        trs_addr_pincode: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        },
        trs_addr_state: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        contact_person_name: {
            required: true
        },
        telephone_number: {
            numbersonly: true
        },
        mob_number: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_trust').submit(function() {
    removeMultiInputNamingRules('#form_trust', '.doc_name');
    removeMultiInputNamingRules('#form_trust', 'input[alt="trustee_details[]"]');
    removeMultiInputNamingRules('#form_trust', 'input[alt="beneficiary_details[]"]');
    removeMultiInputNamingRules('#form_trust', 'input[alt="beneficiary_percent[]"]');

    addMultiInputNamingRules('#form_trust', '.doc_name', { required:function(element) {
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

    addMultiInputNamingRules('#form_trust', 'input[name="trustee_details[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
    addMultiInputNamingRules('#form_trust', 'input[name="beneficiary_details[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
    addMultiInputNamingRules('#form_trust', 'input[name="beneficiary_percent[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                },
                                            numbersonly: true
                                }, "");

    if (!$("#form_trust").valid()) {
        return false;
    } else {
        if (checkBeneficiaryDetailsTrust()==false) {
            return false;
        }
        removeMultiInputNamingRules('#form_trust', '.doc_name');
        removeMultiInputNamingRules('#form_trust', 'input[alt="trustee_details[]"]');
        removeMultiInputNamingRules('#form_trust', 'input[alt="beneficiary_details[]"]');
        removeMultiInputNamingRules('#form_trust', 'input[alt="beneficiary_percent[]"]');
        return true;
    }
});

function checkBeneficiaryDetailsTrust() {
    var validator = $("#form_trust").validate();
    var valid = true;
    var beneficiary_percent = 0;
    var counter = $('.beneficiary').length;

    $('.beneficiary').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        // var trust_beneficiary_id = $('#trust_beneficiary_'+index+'_id').val();
        
        // for(i=counter; i>0; i--) {
        //     if ($('#trust_beneficiary_'+i+'_id').val()==trust_beneficiary_id && i!=index) {
        //             var errors = {};
        //             var name = $('#trust_beneficiary_'+i).attr('name');
        //             errors[name] = "Select different beneficiary for all records";
        //             validator.showErrors(errors);
        //             valid = false;
        //     }
        // }

        beneficiary_percent = beneficiary_percent + parseInt($('#beneficiary_percent_'+index).val());
    });

    if($("#submitVal").val()=="0"){
        if (counter<2) {
                var errors = {};
                var name = $('#trust_beneficiary_1').attr('name');
                errors[name] = "Add atleast two beneficiary";
                validator.showErrors(errors);
                valid = false;
        } else {
            if(beneficiary_percent!=100) {
                var errors = {};
                var name = $('#trust_beneficiary_1').attr('name');
                errors[name] = "Beneficiary total should be 100%";
                validator.showErrors(errors);
                valid = false;
            }
        }
    }
    
    return valid;
}





// ----------------- OWNER Proprietorship FORM VALIDATION -------------------------------------
$("#form_proprietorship").validate({
    rules: {
        organisation_name: {
            required: true
        },
        date_of_incorporation: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        registered_address: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        proprietorship_addr_city: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        proprietorship_addr_pincode: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        },
        proprietorship_addr_state: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        prt_addr_city: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        prt_addr_pincode: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        },
        prt_addr_state: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        aop_addr_city: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        aop_addr_pincode: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        },
        aop_addr_state: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        contact_person_name: {
            required: true
        },
        telephone_number: {
            numbersonly: true
        },
        mob_number: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            numbersonly: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_proprietorship').submit(function() {
    removeMultiInputNamingRules('#form_proprietorship', '.doc_name');
    removeMultiInputNamingRules('#form_proprietorship', 'input[alt="owner_details[]"]');
    // removeMultiInputNamingRules('#form_proprietorship', 'input[alt="owner_percent[]"]');

    addMultiInputNamingRules('#form_proprietorship', '.doc_name', { required:function(element) {
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

    addMultiInputNamingRules('#form_proprietorship', 'input[name="owner_details[]"]', { required: function(element) {
                                                    if($("#submitVal").val()=="0"){
                                                        return true;
                                                    } else {
                                                        return false;
                                                    }
                                                }, 
                                            messages: {required: "Select correct owner from list"}
                                }, "");
    // addMultiInputNamingRules('#form_proprietorship', 'input[name="owner_percent[]"]', { required: function(element) {
    //                                                 if($("#submitVal").val()=="0"){
    //                                                     return true;
    //                                                 } else {
    //                                                     return false;
    //                                                 }
    //                                             },
    //                                             numbersonly: true
    //                             }, "");

    if (!$("#form_proprietorship").valid()) {
        return false;
    } else {
        // if (checkPartnerDetailsProprietorship()==false) {
        //     return false;
        // }
        removeMultiInputNamingRules('#form_proprietorship', '.doc_name');
        removeMultiInputNamingRules('#form_proprietorship', 'input[alt="owner_details[]"]');
        // removeMultiInputNamingRules('#form_proprietorship', 'input[alt="owner_percent[]"]');
        return true;
    }
});

// function checkPartnerDetailsProprietorship() {
//     var validator = $("#form_proprietorship").validate();
//     var valid = true;
//     var ownership_percent = 0;
//     var counter = $('.ownership').length;

//     $('.ownership').each(function() {
//         var id = $(this).attr('id');
//         var index = id.substr(id.lastIndexOf('_')+1);
//         // var owner_details_id = $('#owner_details_'+index+'_id').val();
        
//         // for(i=counter; i>0; i--) {
//         //     if ($('#owner_details_'+i+'_id').val()==owner_details_id && i!=index) {
//         //             var errors = {};
//         //             var name = $('#owner_details_'+i).attr('name');
//         //             errors[name] = "Select different owners for all records";
//         //             validator.showErrors(errors);
//         //             valid = false;
//         //     }
//         // }

//         ownership_percent = ownership_percent + parseInt($('#owner_percent_'+index).val());
//     });

//     if($("#submitVal").val()=="0"){
//         if (counter<2) {
//                 var errors = {};
//                 var name = $('#owner_details_1').attr('name');
//                 errors[name] = "Add atleast two owners";
//                 validator.showErrors(errors);
//                 valid = false;
//         } else {
//             if(ownership_percent!=100) {
//                 var errors = {};
//                 var name = $('#owner_details_1').attr('name');
//                 errors[name] = "Partnership total should be 100%";
//                 validator.showErrors(errors);
//                 valid = false;
//             }
//         }
//     }
    
//     return valid;
// }




// ----------------- TASK FORM VALIDATION -------------------------------------
$("#task_detail").validate({
    rules: {
        subject_detail: {
            required: true
        },
        description: {
            required: true
        },
		property: {
            required: true
        },
        // assigned: {
        //     required: true
        // },
        priority: {
            required: true
        },
        self_assigned: {
            required: true
        },
        contact: {
            required: function(element) {
                        if($("#self_assigned_no").is(':checked')){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        owner_name: {
            required: true
        },
        // from_date: {
        //     required: true
        // },
        // to_date: {
        //     required: function(element) {
        //                 if($("#repeat").val()=="Never"){
        //                     return false;
        //                 } else {
        //                     return true;
        //                 }
        //             }
        // },
        // repeat: {
        //     required: true
        // },
        // periodic_interval: {
        //     required: function(element) {
        //                 if($("#repeat").val()=="Periodically"){
        //                     return true;
        //                 } else {
        //                     return false;
        //                 }
        //             }
        // },
        // weekday: {
        //     required: function(element) {
        //                 if($("#repeat").val()=="Weekly"){
        //                     return ($('input[name*="weekly_interval"]:checked').length <= 0);
        //                 } else {
        //                     return false;
        //                 }
        //             }
        // },
        // monthly_interval: {
        //     required: function(element) {
        //                 if($("#repeat").val()=="Monthly"){
        //                     return true;
        //                 } else {
        //                     return false;
        //                 }
        //             }
        // },
        // monthly_interval2: {
        //     required: function(element) {
        //                 if($("#repeat").val()=="Monthly"){
        //                     return true;
        //                 } else {
        //                     return false;
        //                 }
        //             }
        // }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

// $.validator.addMethod("dategreaterthantoday", function(value, element) {
//     var cur_date = new Date(new Date().setHours(0, 0, 0, 0));
//     var from_date = $('#from_date').val();
//     if(from_date.indexOf("/")!=-1){
//         var date = from_date.split("/");
//         from_date = date[2] + "-" + date[1] + "-" + date[0];
//         from_date = new Date(from_date);
//         from_date = new Date(from_date.setHours(0, 0, 0, 0));
//     }

//     // cur_date.setHours(0, 0, 0, 0, 0);
//     // from_date.setHours(0, 0, 0, 0, 0);
//     return (cur_date<=from_date);

//     // return moment(from_date).isAfter(cur_date, 'day');
    
// }, "Please enter date greater than or equal to today.");

// $.validator.addMethod("dategreaterthanfromdate", function(value, element) {
//     var from_date = $('#from_date').val();
//     var to_date = $('#to_date').val();
//     if(from_date.indexOf("/")!=-1){
//         var date = from_date.split("/");
//         from_date = date[2] + "-" + date[1] + "-" + date[0];
//         from_date = new Date(from_date);
//         from_date = new Date(from_date.setHours(0, 0, 0, 0));
//     }
//     if(to_date.indexOf("/")!=-1){
//         var date = to_date.split("/");
//         to_date = date[2] + "-" + date[1] + "-" + date[0];
//         to_date = new Date(to_date);
//         to_date = new Date(to_date.setHours(0, 0, 0, 0));
//     }

//     // from_date.setHours(0, 0, 0, 0, 0);
//     // to_date.setHours(0, 0, 0, 0, 0);
//     return (from_date<=to_date);
// }, "Please enter to_date greater than or equal to from_date.");

$('#task_detail').submit(function() {
    if (!$("#task_detail").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- Tax FORM VALIDATION -------------------------------------
$("#form_tax").validate({
    rules: {
        txn_type_1: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_tax').submit(function() {
    removeMultiInputNamingRules('#form_tax', 'input[alt="tax_name[]"]');
    removeMultiInputNamingRules('#form_tax', 'input[alt="tax_perecnt[]"]');

    addMultiInputNamingRules('#form_tax', 'input[name="tax_name[]"]', { required: function(element) {
                                                    return true;
                                                }
                                }, "");

    addMultiInputNamingRules('#form_tax', 'input[name="tax_perecnt[]"]', { required: function(element) {
                                                    return true;
                                                }
                                }, "");

    $('.txn_type').each(function() {
        $(this).rules("remove");
    });
    removeMultiInputNamingRules('#form_tax', '.txn_type');

    $('.txn_type').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        if($('#txn_purchase_'+index).is(":checked")==false && $('#txn_sale_'+index).is(":checked")==false && $('#txn_rent_'+index).is(":checked")==false && $('#txn_loan_'+index).is(":checked")==false && $('#txn_maintenance_'+index).is(":checked")==false && $('#txn_valuation_'+index).is(":checked")==false) {
            addMultiInputNamingRules('#form_tax', '#txn_purchase_'+index, { required: function(element) {
                                                            if($('#txn_purchase_'+index).is(":checked")==false && $('#txn_sale_'+index).is(":checked")==false && $('#txn_rent_'+index).is(":checked")==false && $('#txn_loan_'+index).is(":checked")==false && $('#txn_maintenance_'+index).is(":checked")==false && $('#txn_valuation_'+index).is(":checked")==false) {
                                                                return true;
                                                            } else {
                                                                return false;
                                                            }
                                                        }, 
                                                        messages: {required: "Select atleast one transaction type"}
                                }, "");

            // $(this).rules("add", { required: function(element) {
            //                         return true;
            //                     }, 
            //                     messages: {required: "Select atleast one transaction type"}
            //                 });
        }
    });
    $('.txn_action').each(function() {
        $(this).rules("remove");
    });
    $('.txn_action').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        $(this).rules("add", { required: function(element) {
                                                return true;
                                            }
                            });
    });

    if (!$("#form_tax").valid()) {
        return false;
    } else {
        if(checkTaxNameAvailability()==false){
            return false;
        }
        // removeMultiInputNamingRules('#form_tax', '.doc_name');
        // removeMultiInputNamingRules('#form_tax', 'input[alt="ref_no[]"]');
        removeMultiInputNamingRules('#form_tax', 'input[alt="tax_name[]"]');
        removeMultiInputNamingRules('#form_tax', 'input[alt="tax_perecnt[]"]');
        removeMultiInputNamingRules('#form_tax', '.txn_type');
        return true;
    }
});

function checkTaxNameAvailability() {
    var validator = $("#form_tax").validate();
    var tax_id = $('#tax_id_1').val();
    var valid = true;
    var makerCnt = 0;
    var checkerCnt = 0;

    $('.tax_name').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        var tax_id = $('#tax_id_'+index).val();
        var tax_name = $(this).val();

        var result = 1;

        $.ajax({
            url: BASE_URL+'index.php/Tax_master/checkTaxNameAvailability',
            data: 'tax_id='+tax_id+'&tax_name='+tax_name,
            type: "POST",
            dataType: 'html',
            global: false,
            async: false,
            success: function (data) {
                result = parseInt(data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });

        if (result) {
            var errors = {};
            var name = $('#tax_name_'+index).attr('name');
            errors[name] = "Tax_name already in use.";
            validator.showErrors(errors);
            valid = false;
        }

        var counter = $('.tax_name').length;
        // for(i=index; i<=counter; i++) {
        for(i=counter; i>0; i--) {
            if ($('#tax_name_'+i).val()==tax_name && i!=index) {
                var errors = {};
                var name = $('#tax_name_'+i).attr('name');
                errors[name] = "Tax_name already in use.";
                validator.showErrors(errors);
                valid = false;
            }
        }
    });
    
    return valid;
}




// ----------------- REAL ESTATE PROPERTY FORM VALIDATION -------------------------------------
$("#form_real_estate_property").validate({
    rules: {
        unit: {
            required: true,
            //checkPropertyNameAvailability: true
        },
        // date_of_purchase: {
            // required: function(element) {
                        // if($("#submitVal").val()=="0"){
                            // return true;
                        // } else {
                            // return false;
                        // }
                    // }
        // },
        // purchase_mode: {
            // required: function(element) {
                        // if($("#submitVal").val()=="0"){
                            // return true;
                        // } else {
                            // return false;
                        // }
                    // }
        // },
        unit_type: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        // property_status: {
            // required: function(element) {
                        // if($("#submitVal").val()=="0"){
                            // return ($("#ptype").val()=="Building" || $("#ptype").val()=="Apartment" || $("#ptype").val()=="Bunglow" || $("#ptype").val()=="Commercial" || $("#ptype").val()=="Retail" || $("#ptype").val()=="Industrial");
                        // } else {
                            // return false;
                        // }
                    // }
        // },
        // builder_name_name: {
            // required: function(element) {
                        // if($("#submitVal").val()=="0"){
                            // return true;
                        // } else {
                            // return false;
                        // }
                    // }
        // },
        // property_usage: {
            // required: function(element) {
                        // if($("#submitVal").val()=="0"){
                            // return true;
                        // } else {
                            // return false;
                        // }
                    // }
        // },
        // property_description: {
            // required: function(element) {
                        // if($("#submitVal").val()=="0"){
                            // return true;
                        // } else {
                            // return false;
                        // }
                    // }
        // },
        // apartment_name: {
            // required: function(element) {
                        // if($("#submitVal").val()=="0"){
                            // return ($("#ptype").val()=="Apartment" || $("#ptype").val()=="Commercial" || $("#ptype").val()=="Retail" || $("#ptype").val()=="Industrial");
                        // } else {
                            // return false;
                        // }
                    // }
        // },
        unit_no: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                           return true;
                        } else {
                            return false;
                        }
                    }
        },
        floor: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        area: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        area_unit: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
           // numbersonly: true
        },
        
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    },

    invalidHandler: function(e,validator) {
        var errors="";
        if ($('#panel-ownership').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in ownership. <br/>";
        }
        if ($('#panel-property-details').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in property details. <br/>";
        }
        if ($('#panel-property-description').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in property description. <br/>";
        }
        if ($('#panel-purchase-consideration').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in purchase consideration. <br/>";
        }
        if ($('#panel-rp-details').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in related party details. <br/>";
        }
        if ($('#panel-documents').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in documents. <br/>";
        }
        if ($('#panel-pending-activity').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in pending activity. <br/>";
        }

        $('#form_errors').html(errors);

        if(errors!=""){
            $('#form_errors').show();
        } else {
            $('#form_errors').hide();
        }
    }
});

$.validator.addMethod("checkPropertyNameAvailability", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/purchase/check_availablity',
        data: 'p_id='+$("#p_id").val()+'&p_name='+$("#property_name").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Property Name already in use.');

$('#form_real_estate_property').submit(function() {
    removeMultiInputNamingRules('#form_real_estate_property', 'select[alt="clientname[]"]');
    // removeMultiInputNamingRules('#form_purchase', 'input[alt="ownership[]"]');
    // removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_type[]"]');
    // removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_event[]"]');
    // removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_date[]"]');
    // removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_basiccost[]"]');
    // removeMultiInputNamingRules('#form_purchase', '.doc_name');

    addMultiInputNamingRules('#form_real_estate_property', 'select[name="clientname[]"]', { required: function(element) {
                                                                                                if($("#submitVal").val()=="0"){
                                                                                                    return true;
                                                                                                } else {
                                                                                                    return false;
                                                                                                }
                                                                                            }
                                                                                }, "");
    // addMultiInputNamingRules('#form_purchase', 'input[name="ownership[]"]', { required: function(element) {
                                                                                            // if($("#submitVal").val()=="0"){
                                                                                                // return true;
                                                                                            // } else {
                                                                                                // return false;
                                                                                            // }
                                                                                        // }
                                                                                // }, "");
    // addMultiInputNamingRules('#form_purchase', 'input[name="sch_type[]"]', { required: true }, "");
    // addMultiInputNamingRules('#form_purchase', 'input[name="sch_event[]"]', { required: true }, "");
    // addMultiInputNamingRules('#form_purchase', 'input[name="sch_date[]"]', { required: true }, "");
    // addMultiInputNamingRules('#form_purchase', 'input[name="sch_basiccost[]"]', { required: true }, "");
    // addMultiInputNamingRules('#form_purchase', '.doc_name', { required:function(element) {
                                                                        // if($("#submitVal").val()=="0"){
                                                                            // return true;
                                                                        // } else {
                                                                            // return false;
                                                                        // }
                                                                    // }
                                                                // }, "Document");

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


    if (!$("#form_real_estate_property").valid()) {
        return false;
    } else {
        if (checkOwnership()==false){
            return false;
        }
        removeMultiInputNamingRules('#form_real_estate_property', 'select[alt="clientname[]"]');
        // removeMultiInputNamingRules('#form_purchase', 'input[alt="ownership[]"]');
        // removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_type[]"]');
        // removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_event[]"]');
        // removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_date[]"]');
        // removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_basiccost[]"]');
        // removeMultiInputNamingRules('#form_purchase', '.doc_name');
        return true;
    }
});

function checkOwnership() {
    var validator = $("#form_purchase").validate();
    var valid = true;
    var ownership_percent = 0;
    var counter = $('.ownership').length;

    $('.ownership').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        // var owner_name_id = $('#owner_name_'+index+'_id').val();
        var owner_name_id = $(this).val();
        
        for(i=parseInt(index)+1; i<=counter; i++) {
            if ($('#owner_name_'+i).val()==owner_name_id) {
                var errors = {};
                var name = $('#owner_name_'+i).attr('name');
                errors[name] = "Select different owners for all records";
                validator.showErrors(errors);
                $('#form_errors').html("Please Clear errors in ownership. <br/>");
                $('#form_errors').show();
                valid = false;
            }
        }

        ownership_percent = ownership_percent + parseInt($('#owner_percent_'+index).val());
    });

    if($("#submitVal").val()=="0"){
        if (counter==0) {
            var errors = {};
            var name = $('#owner_name_1').attr('name');
            errors[name] = "Please add atleast one buyer.";
            validator.showErrors(errors);
            valid = false;
        } else {
            if(ownership_percent!=100) {
                var errors = {};
                var name = $('#owner_name_1').attr('name');
                errors[name] = "Ownership percent total should be 100%";
                validator.showErrors(errors);
                $('#form_errors').html("Please Clear errors in ownership. <br/>");
                $('#form_errors').show();
                valid = false;
            }
        }
    }
    
    if($("#submitVal").val()=="0"){
        if($("#schedule_table tr").length==0){
            var errors = {};
            var name = $('#schedule_id').attr('name');
            errors[name] = "Please add atleast one event.";
            validator.showErrors(errors);
            $('#form_errors').html("Please Clear errors in purchase consideration. <br/>");
            $('#form_errors').show();
            valid = false;
        }
    }

    return valid;
}


$('#form_real_estate_property').submit(function() {
    if (!$("#form_real_estate_property").valid()) {
        return false;
    } else {
        return true;
    }
});

// ----------------- NON REAL ESTATE PROPERTY FORM VALIDATION -------------------------------------

$("#form_non_real_estate_property").validate({
    rules: {
        unit: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
            //checkPropertyNameAvailability: true
        },
      
        unit_type_id: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
     

        area: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        area_unit: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
           // numbersonly: true
        },
		
		 location: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
           // numbersonly: true
        },
        
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    },

    invalidHandler: function(e,validator) {
        var errors="";
        if ($('#panel-ownership').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in ownership. <br/>";
        }
        if ($('#panel-property-details').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in property details. <br/>";
        }
        if ($('#panel-property-description').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in property description. <br/>";
        }
        if ($('#panel-purchase-consideration').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in purchase consideration. <br/>";
        }
        if ($('#panel-rp-details').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in related party details. <br/>";
        }
        if ($('#panel-documents').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in documents. <br/>";
        }
        if ($('#panel-pending-activity').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in pending activity. <br/>";
        }

        $('#form_errors').html(errors);

        if(errors!=""){
            $('#form_errors').show();
        } else {
            $('#form_errors').hide();
        }
    }
});



$('#form_non_real_estate_property').submit(function() {
    if (!$("#form_non_real_estate_property").valid()) {
        return false;
    } else {
        return true;
    }
});





// ----------------- SALE FORM VALIDATION -------------------------------------
$("#form_sale").validate({
    rules: {
        property: {
              required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        sub_property: {
            required: function(element) {
                        if($("#sub_property option").length>1){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        sale_date: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        }
        // ,
        // brokername_name: {
        //     required: function(element) {
        //                 if($("#submitVal").val()=="0"){
        //                     return true;
        //                 } else {
        //                     return false;
        //                 }
        //             }
        // }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    },

    invalidHandler: function(e,validator) {
        var errors="";
        if ($('#panel-property-details').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in property details. <br/>";
        }
        if ($('#panel-sales-consideration').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in sales consideration. <br/>";
        }
        if ($('#panel-rp-details').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in related party details. <br/>";
        }
        if ($('#panel-documents').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in documents. <br/>";
        }
        if ($('#panel-profit-or-loss').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in profit or loss. <br/>";
        }
        if ($('#panel-pending-activity').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in pending activity. <br/>";
        }

        $('#form_errors').html(errors);

        if(errors!=""){
            $('#form_errors').show();
        } else {
            $('#form_errors').hide();
        }
    }
});

$('#form_sale').submit(function() {
    removeMultiInputNamingRules('#form_sale', 'input[alt="buyername[]"]');
    removeMultiInputNamingRules('#form_sale', 'input[alt="sharepercent[]"]');
    removeMultiInputNamingRules('#form_sale', 'input[alt="sch_type[]"]');
    removeMultiInputNamingRules('#form_sale', 'input[alt="sch_event[]"]');
    removeMultiInputNamingRules('#form_sale', 'input[alt="sch_date[]"]');
    removeMultiInputNamingRules('#form_sale', 'input[alt="sch_basiccost[]"]');
    removeMultiInputNamingRules('#form_sale', '.doc_name');

    addMultiInputNamingRules('#form_sale', 'input[name="buyername[]"]', { required: function(element) {
                                                                                                if($("#submitVal").val()=="0"){
                                                                                                    return true;
                                                                                                } else {
                                                                                                    return false;
                                                                                                }
                                                                                            }
                                                                                }, "");
    addMultiInputNamingRules('#form_sale', 'input[name="sharepercent[]"]', { required: function(element) {
                                                                                            if($("#submitVal").val()=="0"){
                                                                                                return true;
                                                                                            } else {
                                                                                                return false;
                                                                                            }
                                                                                        }
                                                                                }, "");
    addMultiInputNamingRules('#form_sale', 'input[name="sch_type[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_sale', 'input[name="sch_event[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_sale', 'input[name="sch_date[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_sale', 'input[name="sch_basiccost[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_sale', '.doc_name', { required:function(element) {
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


    if (!$("#form_sale").valid()) {
        return false;
    } else {
        if (checkSharePercent()==false){
            return false;
        }
        removeMultiInputNamingRules('#form_sale', 'input[alt="buyername[]"]');
        removeMultiInputNamingRules('#form_sale', 'input[alt="sharepercent[]"]');
        removeMultiInputNamingRules('#form_sale', 'input[alt="sch_type[]"]');
        removeMultiInputNamingRules('#form_sale', 'input[alt="sch_event[]"]');
        removeMultiInputNamingRules('#form_sale', 'input[alt="sch_date[]"]');
        removeMultiInputNamingRules('#form_sale', 'input[alt="sch_basiccost[]"]');
        removeMultiInputNamingRules('#form_sale', '.doc_name');
        return true;
    }
});

function checkSharePercent() {
    var validator = $("#form_sale").validate();
    var valid = true;
    var ownership_percent = 0;
    var counter = $('.buyer').length;

    $('.buyer').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        // var buyer_name_id = $('#buyer_name_'+index+'_id').val();
        var buyer_name_id = $(this).val();
        
        for(i=parseInt(index)+1; i<=counter; i++) {
            if ($('#buyer_name_'+i).val()==buyer_name_id) {
                var errors = {};
                var name = $('#buyer_name_'+i).attr('name');
                errors[name] = "Select different owners for all records";
                validator.showErrors(errors);
                $('#form_errors').html("Please Clear errors in property details. <br/>");
                $('#form_errors').show();
                valid = false;
            }
        }

        ownership_percent = ownership_percent + parseInt($('#sharepercent_'+index).val());
    });

    if($("#submitVal").val()=="0"){
        if (counter==0) {
            var errors = {};
            var name = $('#property').attr('name');
            errors[name] = "Please add atleast one buyer.";
            validator.showErrors(errors);
            $('#form_errors').html("Please Clear errors in property details. <br/>");
            $('#form_errors').show();
            valid = false;
        } else {
            if(ownership_percent!=100) {
                var errors = {};
                var name = $('#buyer_name_1').attr('name');
                errors[name] = "Share percent total should be 100%";
                validator.showErrors(errors);
                $('#form_errors').html("Please Clear errors in property details. <br/>");
                $('#form_errors').show();
                valid = false;
            }
        }
    }
    
    if($("#submitVal").val()=="0"){
        if($("#schedule_table tr").length==0){
            var errors = {};
            var name = $('#schedule_id').attr('name');
            errors[name] = "Please add atleast one event.";
            validator.showErrors(errors);
            $('#form_errors').html("Please Clear errors in sales consideration. <br/>");
            $('#form_errors').show();
            valid = false;
        }
    }

    return valid;
}




// ----------------- RENT FORM VALIDATION -------------------------------------
$("#form_rent").validate({
    rules: {
        property: {
            required: true
        },
        sub_property: {
            required: function(element) {
                        if($("#sub_property option").length>1){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        // owner_name: {
        //     required: function(element) {
        //                 if($("#submitVal").val()=="0"){
        //                     return true;
        //                 } else {
        //                     return false;
        //                 }
        //             }
        // },
        rent_amount: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        deposit_amount: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        possession_date: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        termination_date: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        rent_due_day: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        lease_period: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        notice_period: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        free_rent_period: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        schedule: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        invoice_issuer: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        invoice_date: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        gst_rate: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return $("#gst").is(":checked");
                        } else {
                            return false;
                        }
                    }
        },
        tds_rate: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return $("#tds").is(":checked");
                        } else {
                            return false;
                        }
                    }
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    },

    invalidHandler: function(e,validator) {
        var errors="";
        if ($('#panel-rent-details').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in property and tenant details. <br/>";
        }
        // if ($('#panel-rent-consideration').find("input.error, select.error").length>0) {
        //     errors=errors+"Please Clear errors in rent consideration. <br/>";
        // }
        // if ($('#panel-rp-details').find("input.error, select.error").length>0) {
        //     errors=errors+"Please Clear errors in related party details. <br/>";
        // }
        if ($('#panel-documents').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in documents. <br/>";
        }
        // if ($('#panel-pending-activity').find("input.error, select.error").length>0) {
        //     errors=errors+"Please Clear errors in pending activity. <br/>";
        // }

        $('#form_errors').html(errors);

        if(errors!=""){
            $('#form_errors').show();
        } else {
            $('#form_errors').hide();
        }
    }
});

$('#form_rent').submit(function() {
    removeMultiInputNamingRules('#form_rent', 'select[alt="tenant[]"]');
   // removeMultiInputNamingRules('#form_rent', 'select[alt="other_amount[]"]');
     removeMultiInputNamingRules('#form_rent', 'input[alt="other_amount[]"]');

    removeMultiInputNamingRules('#form_rent', 'select[alt="other_schedule[]"]');
    removeMultiInputNamingRules('#form_rent', 'select[alt="other_invoice_issuer[]"]');
    removeMultiInputNamingRules('#form_rent', 'select[alt="other_due_day[]"]');
    removeMultiInputNamingRules('#form_rent', 'select[alt="other_gst[]"]');
    removeMultiInputNamingRules('#form_rent', 'input[alt="other_tds[]"]');
    removeMultiInputNamingRules('#form_rent', 'input[alt="other_invoice_date[]"]');

    // removeMultiInputNamingRules('#form_rent', 'input[alt="sch_type[]"]');
    removeMultiInputNamingRules('#form_rent', 'input[alt="sch_event[]"]');
    removeMultiInputNamingRules('#form_rent', 'input[alt="sch_date[]"]');
    removeMultiInputNamingRules('#form_rent', 'input[alt="sch_basiccost[]"]');
    removeMultiInputNamingRules('#form_rent', '.doc_name');
	
	addMultiInputNamingRules('#form_rent', 'select[name="tenant[]"]', { required: function(element) {
                                                                                        if($("#submitVal").val()=="0"){
                                                                                            return true;
                                                                                        } else {
                                                                                            return false;
                                                                                        }
                                                                                    } }, "");
	

    
    addMultiInputNamingRules('#form_rent', 'input[name="other_amount[]"]', { required: function(element) {
                                                                                        if($("#submitVal").val()=="0"){
                                                                                            return true;
                                                                                        } else {
                                                                                            return false;
                                                                                        }
                                                                                    } }, "");
    addMultiInputNamingRules('#form_rent', 'select[name="other_schedule[]"]', { required: function(element) {
                                                                                        if($("#submitVal").val()=="0"){
                                                                                            return true;
                                                                                        } else {
                                                                                            return false;
                                                                                        }
                                                                                    } }, "");
    addMultiInputNamingRules('#form_rent', 'select[name="other_invoice_issuer[]"]', { required: function(element) {
                                                                                        if($("#submitVal").val()=="0"){
                                                                                            return true;
                                                                                        } else {
                                                                                            return false;
                                                                                        }
                                                                                    } }, "");
    addMultiInputNamingRules('#form_rent', 'select[name="other_due_day[]"]', { required: function(element) {
                                                                                        if($("#submitVal").val()=="0"){
                                                                                            return true;
                                                                                        } else {
                                                                                            return false;
                                                                                        }
                                                                                    } }, "");
																					
																					
  addMultiInputNamingRules('#form_rent', 'select[name="other_gst[]"]', { required: function(element) {
                                                                                        if($("#submitVal").val()=="0"){
                                                                                            return true;
                                                                                        } else {
                                                                                            return false;
                                                                                        }
                                                                                    } }, "");

  addMultiInputNamingRules('#form_rent', 'input[name="other_tds[]"]', { required: function(element) {
                                                                                        if($("#submitVal").val()=="0"){
                                                                                            return true;
                                                                                        } else {
                                                                                            return false;
                                                                                        }
                                                                                    } }, "");																					
																					
																					
																					
    addMultiInputNamingRules('#form_rent', 'input[name="other_invoice_date[]"]', { required: function(element) {
                                                                                        if($("#submitVal").val()=="0"){
                                                                                            return true;
                                                                                        } else {
                                                                                            return false;
                                                                                        }
                                                                                    } }, "");

    // addMultiInputNamingRules('#form_rent', 'input[name="sch_type[]"]', { required: function(element) {
                                                                                        //     if($("#submitVal").val()=="0"){
                                                                                        //         return true;
                                                                                        //     } else {
                                                                                        //         return false;
                                                                                        //     }
                                                                                        // } }, "");
    addMultiInputNamingRules('#form_rent', 'input[name="sch_event[]"]', { required: function(element) {
                                                                                        if($("#submitVal").val()=="0"){
                                                                                            return true;
                                                                                        } else {
                                                                                            return false;
                                                                                        }
                                                                                    } }, "");
    addMultiInputNamingRules('#form_rent', 'input[name="sch_date[]"]', { required: function(element) {
                                                                                        if($("#submitVal").val()=="0"){
                                                                                            return true;
                                                                                        } else {
                                                                                            return false;
                                                                                        }
                                                                                    } }, "");
    addMultiInputNamingRules('#form_rent', 'input[name="sch_basiccost[]"]', { required: function(element) {
                                                                                            if($("#submitVal").val()=="0"){
                                                                                                return true;
                                                                                            } else {
                                                                                                return false;
                                                                                            }
                                                                                        } }, "");
    addMultiInputNamingRules('#form_rent', '.doc_name', { required: function(element) {
                                                                        if($("#submitVal").val()=="0"){
                                                                            return true;
                                                                        } else {
                                                                            return false;
                                                                        }
                                                                    } }, "Document");

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


    if (!$("#form_rent").valid()) {
        return false;
    } else {
        // if (checkRentDetails()==false){
        //     return false;
        // }

        removeMultiInputNamingRules('#form_rent', 'select[alt="tenant[]"]');
        removeMultiInputNamingRules('#form_rent', 'select[alt="other_amount[]"]');
        removeMultiInputNamingRules('#form_rent', 'select[alt="other_schedule[]"]');
        removeMultiInputNamingRules('#form_rent', 'select[alt="other_invoice_issuer[]"]');
        removeMultiInputNamingRules('#form_rent', 'select[alt="other_due_day[]"]');
        removeMultiInputNamingRules('#form_rent', 'select[alt="other_invoice_date[]"]');
        
        // removeMultiInputNamingRules('#form_rent', 'input[alt="sch_type[]"]');
        removeMultiInputNamingRules('#form_rent', 'input[alt="sch_event[]"]');
        removeMultiInputNamingRules('#form_rent', 'input[alt="sch_date[]"]');
        removeMultiInputNamingRules('#form_rent', 'input[alt="sch_basiccost[]"]');
        removeMultiInputNamingRules('#form_rent', '.doc_name');
        return true;
    }
});

function checkRentDetails() {
    var validator = $("#form_rent").validate();
    var valid = true;
    
    if($("#submitVal").val()=="0"){
        if($("#schedule_table tr").length==0){
            var errors = {};
            var name = $('#schedule_id').attr('name');
            errors[name] = "Please add atleast one event.";
            validator.showErrors(errors);
            $('#form_errors').html("Please Clear errors in rent consideration. <br/>");
            $('#form_errors').show();
            valid = false;
        }
    }

    return valid;
}




// ----------------- SUB-PROPERTY FORM VALIDATION -------------------------------------
$("#form_sub_property").validate({
    rules: {
        property: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    },

    invalidHandler: function(e,validator) {
        var errors="";
        if ($('#panel-sub-property-details').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in sub property details. <br/>";
        }

        $('#form_errors').html(errors);

        if(errors!=""){
            $('#form_errors').show();
        } else {
            $('#form_errors').hide();
        }
    }
});

$('#form_sub_property').submit(function() {
    removeMultiInputNamingRules('#form_sub_property', 'input[alt="sub_property[]"]');
    removeMultiInputNamingRules('#form_sub_property', 'select[alt="sub_type[]"]');

    addMultiInputNamingRules('#form_sub_property', 'input[name="sub_property[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_sub_property', 'select[name="sub_type[]"]', { required: true }, "");

    if (!$("#form_sub_property").valid()) {
        return false;
    } else {
        if (checkSubPropertyDetails()==false){
            return false;
        }
        removeMultiInputNamingRules('#form_sub_property', 'input[alt="sub_property[]"]');
        removeMultiInputNamingRules('#form_sub_property', 'select[alt="sub_type[]"]');
        return true;
    }
});

function checkSubPropertyDetails() {
    var validator = $("#form_sub_property").validate();
    var valid = true;
    
    if($("#submitVal").val()=="0"){
        if($("#sub_property_table tr").length==0){
            var errors = {};
            var name = $('#property').attr('name');
            errors[name] = "Please add atleast one sub property.";
            validator.showErrors(errors);
            $('#form_errors').html("Please Clear errors in sub property details. <br/>");
            $('#form_errors').show();
            valid = false;
        }
    }

    return valid;
}




// ----------------- Indexation FORM VALIDATION -------------------------------------
$("#form_download_report").validate({
    rules: {
        // owner: {
        //     required: function(element) {
        //                 if($('#owner').is(':visible')) {
        //                     return true;
        //                 } else {
        //                     return false;
        //                 }
        //             }
        // },
        owner: {
            required: true
        },
        from_date: {
            required: true
        },
        to_date: {
            required: true
        },
        property: {
            required: true
        }
    },

    ignore:":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});




// ----------------- Contact Type FORM VALIDATION -------------------------------------
$("#form_contact_type").validate({
    rules: {
        contact_type: {
            required: true,
            checkContactTypeAvailability: true
        }
    },

    ignore: false,
    onkeyup: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("checkContactTypeAvailability", function (value, element) {
    var result = 1;
    $.ajax({
        url: BASE_URL+'index.php/contact_type/checkContactTypeAvailability',
        data: 'contact_type_id='+$("#contact_type_id").val() + '&contact_type='+$("#contact_type").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Contact type already exist');

$('#form_contact_type').submit(function() {
    if (!$("#form_contact_type").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- Expense Category FORM VALIDATION -------------------------------------
$("#form_expense_category").validate({
    rules: {
        expense_category: {
            required: true,
            checkExpenseCategoryAvailability: true
        }
    },

    ignore: false,
    onkeyup: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("checkExpenseCategoryAvailability", function (value, element) {
    var result = 1;
    $.ajax({
        url: BASE_URL+'index.php/expense_category/checkExpenseCategoryAvailability',
        data: 'expense_category_id='+$("#expense_category_id").val() + '&expense_category='+$("#expense_category").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Expense Category already exist');

$('#form_expense_category').submit(function() {
    if (!$("#form_expense_category").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- LOAN FORM VALIDATION -------------------------------------
$("#form_loan").validate({
    rules: {
        ref_id: {
            required: true,
            checkRefIdAvailability: true
        },
        loan_type: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        amount: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        loan_start_date: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        loan_due_day: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        term: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        interest_type: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        interest_rate: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    },
            number: true
        },
        financial_institution: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    },

    invalidHandler: function(e,validator) {
        var errors="";
        if ($('#panel-ownership').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in ownership. <br/>";
        }
        if ($('#panel-loan-details').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in loan details. <br/>";
        }
        if ($('#panel-security').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in security details. <br/>";
        }
        if ($('#panel-documents').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in documents. <br/>";
        }
        if ($('#panel-pending-activity').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in pending activity. <br/>";
        }

        $('#form_errors').html(errors);

        if(errors!=""){
            $('#form_errors').show();
        } else {
            $('#form_errors').hide();
        }
    }
});

$.validator.addMethod("checkRefIdAvailability", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/loan/check_availablity',
        data: 'l_id='+$("#l_id").val()+'&l_ref_id='+$("#ref_id").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Ref Id already in use.');

$('#form_loan').submit(function() {
    removeMultiInputNamingRules('#form_loan', 'input[alt="borrower[]"]');
    removeMultiInputNamingRules('#form_loan', '.doc_name');

    addMultiInputNamingRules('#form_loan', 'input[name="borrower[]"]', { required: function(element) {
                                                                                                if($("#submitVal").val()=="0"){
                                                                                                    return true;
                                                                                                } else {
                                                                                                    return false;
                                                                                                }
                                                                                            }
                                                                                }, "");
    addMultiInputNamingRules('#form_loan', '.doc_name', { required:function(element) {
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


    if (!$("#form_loan").valid()) {
        return false;
    } else {
        if (checkBorrower()==false){
            return false;
        }
        removeMultiInputNamingRules('#form_loan', 'input[alt="borrower[]"]');
        removeMultiInputNamingRules('#form_loan', '.doc_name');
        return true;
    }
});

function checkBorrower() {
    var validator = $("#form_loan").validate();
    var valid = true;
    var counter = $('.borrower').length;

    $('.borrower').each(function() {
        var id = $(this).attr('id');
        var index = id.substr(id.lastIndexOf('_')+1);
        // var borrower_name_id = $('#borrower_'+index+'_id').val();
        var borrower_name_id = $(this).val();
        
        for(i=parseInt(index)+1; i<=counter; i++) {
            if ($('#borrower_'+i).val()==borrower_name_id) {
                var errors = {};
                var name = $('#borrower_'+i).attr('name');
                errors[name] = "Select different owners for all records";
                validator.showErrors(errors);
                $('#form_errors').html("Please Clear errors in owner details. <br/>");
                $('#form_errors').show();
                valid = false;
            }
        }
    });

    if($("#submitVal").val()=="0"){
        if (counter==0) {
            var errors = {};
            var name = $('#borrower_1').attr('name');
            errors[name] = "Please add atleast one buyer.";
            validator.showErrors(errors);
            valid = false;
        }
    }
    
    return valid;
}




// ----------------- LOAN DISBURSEMENT FORM VALIDATION -------------------------------------
$("#form_loan_disbursement").validate({
    rules: {
        loan_id: {
            required: true
        },
        ref_id: {
            required: true,
            checkRefIdAvailability: true
        },
        disbursement_amount: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        disbursement_date: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        emi: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        issuer_bank_id: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        receiver_bank_id: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        payment_mode: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
		
		   cheq_no: {
            required: function(element) {
				  if($("#payment_mode").val()!="Cash"){
                            return true;
                        
                        } else {
                            return false;
                        }
                    }
       
	   }
		
		 
		
		
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    },

    invalidHandler: function(e,validator) {
        var errors="";
        if ($('#panel-loan-details').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in loan details. <br/>";
        }
        if ($('#panel-loan-disbursement-details').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in loan disbursement details. <br/>";
        }
        if ($('#panel-loan-consideration').find("input.error, select.error").length>0) {
            errors=errors+"Please Clear errors in loan consideration. <br/>";
        }

        $('#form_errors').html(errors);

        if(errors!=""){
            $('#form_errors').show();
        } else {
            $('#form_errors').hide();
        }
    }
});

$.validator.addMethod("checkRefIdAvailability", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/loan/check_availablity',
        data: 'l_id='+$("#l_id").val()+'&l_ref_id='+$("#ref_id").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Ref Id already in use.');

$('#form_loan_disbursement').submit(function() {
    removeMultiInputNamingRules('#form_loan_disbursement', 'input[alt="sch_type[]"]');
    removeMultiInputNamingRules('#form_loan_disbursement', 'input[alt="sch_event[]"]');
    removeMultiInputNamingRules('#form_loan_disbursement', 'input[alt="sch_date[]"]');
    removeMultiInputNamingRules('#form_loan_disbursement', 'input[alt="sch_basiccost[]"]');

    addMultiInputNamingRules('#form_loan_disbursement', 'input[name="sch_type[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_loan_disbursement', 'input[name="sch_event[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_loan_disbursement', 'input[name="sch_date[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_loan_disbursement', 'input[name="sch_basiccost[]"]', { required: true }, "");

    if (!$("#form_loan_disbursement").valid()) {
        return false;
    } else {
        if (checkDisbursement()==false){
            return false;
        }
        removeMultiInputNamingRules('#form_loan_disbursement', 'input[alt="sch_type[]"]');
        removeMultiInputNamingRules('#form_loan_disbursement', 'input[alt="sch_event[]"]');
        removeMultiInputNamingRules('#form_loan_disbursement', 'input[alt="sch_date[]"]');
        removeMultiInputNamingRules('#form_loan_disbursement', 'input[alt="sch_basiccost[]"]');
        return true;
    }
});


function checkDisbursement() {
    var validator = $("#form_loan_disbursement").validate();
    var valid = true;

    if($("#submitVal").val()=="0"){
        if($("#schedule_table tr").length==0){
            var errors = {};
            var name = $('#schedule_id').attr('name');
            errors[name] = "Please add atleast one event.";
            validator.showErrors(errors);
            $('#form_errors').html("Please Clear errors in loan consideration. <br/>");
            $('#form_errors').show();
            valid = false;
        }
    }

    return valid;
}



// ----------------- Expense FORM VALIDATION -------------------------------------
$("#form_expense").validate({
    rules: {
        category: {
            required: true
        },
        vendor_name: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        expense_date: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        expense_amount: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        payment_time: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        payment_mode: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return $("#payment_time_now").is(":checked");
                        } else {
                            return false;
                        }
                    }
        },
        cheque_no: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return ($("#payment_mode").val()=="Cheque");
                        } else {
                            return false;
                        }
                    }
        },
        cheque_date: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return ($("#payment_mode").val()=="Cheque");
                        } else {
                            return false;
                        }
                    }
        },
        bank_name_name: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return ($("#payment_mode").val()=="Cheque");
                        } else {
                            return false;
                        }
                    }
        },
        cheque_amount: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return ($("#payment_mode").val()=="Cheque");
                        } else {
                            return false;
                        }
                    }
        },
        ref_no: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return ($("#payment_mode").val()=="NEFT");
                        } else {
                            return false;
                        }
                    }
        },
        from_date: {
            required: function(element) {
                        if($("#submitVal").val()=="0"){
                            return $("#payment_time_later").is(":checked");
                        } else {
                            return false;
                        }
                    }
        },
        to_date: {
            required: function(element) {
                        if($("#submitVal").val()=="0" && $("#payment_time_later").is(":checked")){
                            if($("#repeat").val()=="Never"){
                                return false;
                            } else {
                                return true;
                            }
                        } else {
                            return false;
                        }
                    }
        },
        repeat: {
            required: function(element) {
                        if($("#submitVal").val()=="0" && $("#payment_time_later").is(":checked")){
                            return true;
                        } else {
                            return false;
                        }
                    }
        },
        periodic_interval: {
            required: function(element) {
                        if($("#submitVal").val()=="0" && $("#payment_time_later").is(":checked")){
                            if($("#repeat").val()=="Periodically"){
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    }
        },
        weekday: {
            required: function(element) {
                        if($("#submitVal").val()=="0" && $("#payment_time_later").is(":checked")){
                            if($("#repeat").val()=="Weekly"){
                                return ($('input[name*="weekly_interval"]:checked').length <= 0);
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    }
        },
        monthly_interval: {
            required: function(element) {
                        if($("#submitVal").val()=="0" && $("#payment_time_later").is(":checked")){
                            if($("#repeat").val()=="Monthly"){
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    }
        },
        monthly_interval2: {
            required: function(element) {
                        if($("#submitVal").val()=="0" && $("#payment_time_later").is(":checked")){
                            if($("#repeat").val()=="Monthly"){
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    }
        }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_expense').submit(function() {
    if (!$("#form_expense").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- Maintenance FORM VALIDATION -------------------------------------
$("#maintenance_details").validate({
    rules: {
        property: {
            required: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#maintenance_details').submit(function() {
    removeMultiInputNamingRules('#maintenance_details', 'input[alt="due_date[]"]');
    removeMultiInputNamingRules('#maintenance_details', 'select[alt="frequency[]"]');
    removeMultiInputNamingRules('#maintenance_details', 'input[alt="cost[]"]');

    addMultiInputNamingRules('#maintenance_details', 'input[name="due_date[]"]', { required: true }, "");
    addMultiInputNamingRules('#maintenance_details', 'select[name="frequency[]"]', { required: true }, "");
    addMultiInputNamingRules('#maintenance_details', 'input[name="cost[]"]', { required: true }, "");

    if (!$("#maintenance_details").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- Bank Entry Details FORM VALIDATION -------------------------------------
$("#accounting_details").validate({
    rules: {
        payer_id: {
            required: true
        },
        account_number: {
            required: true
        },
        payment_mode: {
            required: true
        },
        payment_date: {
            required: true
        },
        loan_ref_name: {
            required: true
        },
        contact_id: {
            required: true
        },
        // prop_name: {
        //     required: true
        // },
        cheq_no: {
            required: function(element) {
                        if($("#payment_mode").val()=="Cheque"){
                                return true;
                        } else {
                            return false;
                        }
                    }
        },
        type: {
            required: true
        },
        // status: {
        //     required: true
        // },
        expense_category: {
            required: true
        },
        expense_description: {
            required: true
        },
        expense_date: {
            required: true
        },
        expense_amount: {
            required: true
        }
    },

    ignore:":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#accounting_details').submit(function() {
    removeMultiInputNamingRules('#accounting_details', 'input[alt="event_date[]"]');
    removeMultiInputNamingRules('#accounting_details', 'select[alt="category[]"]');

    addMultiInputNamingRules('#accounting_details', 'input[name="event_date[]"]', { required: true }, "");
    addMultiInputNamingRules('#accounting_details', 'select[name="category[]"]', { required: true }, "");

    if (!$("#accounting_details").valid()) {
        return false;
    } else {

        removeMultiInputNamingRules('#accounting_details', 'input[alt="event_date[]"]');
        removeMultiInputNamingRules('#accounting_details', 'select[alt="category[]"]');

        return true;
    }
});




// ----------------- Bank Entry Details FORM VALIDATION -------------------------------------
$("#bank_entry_details").validate({
    rules: {
        bank_name: {
            required: true
        },
        payment_mode: {
            required: true
        },
        payment_date: {
            required: true
        },
        cheq_no: {
            required: function(element) {
                        if($("#payment_mode").val()=="Cheque"){
                                return true;
                        } else {
                            return false;
                        }
                    }
        },
        type: {
            required: true
        },
        status: {
            required: true
        },
        expense_category: {
            required: true
        },
        expense_description: {
            required: true
        },
        expense_date: {
            required: true
        },
        expense_amount: {
            required: true
        }
    },

    ignore:":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#bank_entry_details').submit(function() {
    if (!$("#bank_entry_details").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- Property Projection Details FORM VALIDATION -------------------------------------
$("#property_projection").validate({
    rules: {
        property: {
            required: true
        },
        req_rate_return: {
            required: true
        },
        rrv_value: {
            required: true
        },
        index_cost_value: {
            required: true
        },
        projection_date: {
            required: true
        },
        market_rate: {
            required: true
        },
        market_value: {
            required: true
        },
        profit_loss: {
            required: true
        }
    },

    ignore:":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#property_projection').submit(function() {
    if (!$("#property_projection").valid()) {
        return false;
    } else {
        return true;
    }
});




// ----------------- MAKER CHECKER FORM VALIDATION -------------------------------------
$("#form_maker_checker").validate({
    rules: {
        'maker_first_name[]': {
            required: true
        }
    },

    ignore: false,
    onkeyup: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_maker_checker').submit(function() {
    removeMultiInputNamingRules('#form_maker_checker', 'input[alt="maker_first_name[]"]');
    removeMultiInputNamingRules('#form_maker_checker', 'input[alt="maker_last_name[]"]');
    removeMultiInputNamingRules('#form_maker_checker', 'input[alt="maker_email_id[]"]');
    removeMultiInputNamingRules('#form_maker_checker', 'input[alt="maker_contact_number[]"]');
    removeMultiInputNamingRules('#form_maker_checker', 'select[alt="checker_first_name[]"]');
    removeMultiInputNamingRules('#form_maker_checker', 'select[alt="checker_last_name[]"]');
    removeMultiInputNamingRules('#form_maker_checker', 'select[alt="checker_email_id[]"]');
    removeMultiInputNamingRules('#form_maker_checker', 'select[alt="checker_contact_number[]"]');

    addMultiInputNamingRules('#form_maker_checker', 'input[name="maker_first_name[]"]', { required: true, lettersonly: true }, "");
    addMultiInputNamingRules('#form_maker_checker', 'input[name="maker_last_name[]"]', { required: true, lettersonly: true }, "");
    addMultiInputNamingRules('#form_maker_checker', 'input[name="maker_email_id[]"]', { required: true, checkemail: true}, "");
    addMultiInputNamingRules('#form_maker_checker', 'input[name="maker_contact_number[]"]', { required: true, numbersonly: true }, "");
    addMultiInputNamingRules('#form_maker_checker', 'input[name="checker_first_name[]"]', { required: true, lettersonly: true }, "");
    addMultiInputNamingRules('#form_maker_checker', 'input[name="checker_last_name[]"]', { required: true, lettersonly: true }, "");
    addMultiInputNamingRules('#form_maker_checker', 'input[name="checker_email_id[]"]', { required: true, checkemail: true}, "");
    addMultiInputNamingRules('#form_maker_checker', 'input[name="checker_contact_number[]"]', { required: true, numbersonly: true }, "");

    if (!$("#form_maker_checker").valid()) {
        return false;
    } else {
        if (checkUserAvailability()==false) {
            return false;
        } else {
            removeMultiInputNamingRules('#form_maker_checker', 'input[alt="maker_first_name[]"]');
            removeMultiInputNamingRules('#form_maker_checker', 'input[alt="maker_last_name[]"]');
            removeMultiInputNamingRules('#form_maker_checker', 'input[alt="maker_email_id[]"]');
            removeMultiInputNamingRules('#form_maker_checker', 'input[alt="maker_contact_number[]"]');
            removeMultiInputNamingRules('#form_maker_checker', 'select[alt="checker_first_name[]"]');
            removeMultiInputNamingRules('#form_maker_checker', 'select[alt="checker_last_name[]"]');
            removeMultiInputNamingRules('#form_maker_checker', 'select[alt="checker_email_id[]"]');
            removeMultiInputNamingRules('#form_maker_checker', 'select[alt="checker_contact_number[]"]');

            return true;
        }
    }
});

function checkUserAvailability() {
    var validator = $("#form_maker_checker").validate();
    var groupid = $('#group_id').val();
    var valid = true;
    var makerCnt = 0;
    var checkerCnt = 0;
    var adminCnt = 0;

    if($('.maker_row').length>0) {
        $('.maker_row').each(function(){
            var id = $(this).attr('id');
            var index = id.substr(id.lastIndexOf('_')+1);
            var user_id = '0';
            var first_name = $('#maker_first_name_'+index).val();
            var last_name = $('#maker_last_name_'+index).val();
            var email_id = $('#maker_email_id_'+index).val();
            var contact_number = $('#maker_contact_number_'+index).val();

            var result = 1;

            $.ajax({
                url: BASE_URL+'index.php/groups/check_contact_availablity',
                data: 'groupid='+groupid+'&groupuserid='+user_id+'&groupusername='+first_name+'&groupuserlastname='+last_name+'&groupemail='+email_id+'&groupmobile='+contact_number,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if (result) {
                var errors = {};
                var name = $('#maker_first_name_'+index).attr('name');
                errors[name] = "First_name, Last_name, Email ID & Mobile No already in use.";
                validator.showErrors(errors);
                valid = false;
            }

            var result = 1;

            $.ajax({
                url: BASE_URL+'index.php/groups/check_email_availablity',
                data: 'groupid='+groupid+'&groupemail='+email_id,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if (result) {
                var errors = {};
                var name = $('#maker_email_id_'+index).attr('name');
                errors[name] = "Entered email_id is already an owner of another group.";
                validator.showErrors(errors);
                valid = false;
            }

            result = 1;

            $.ajax({
                url: BASE_URL+'index.php/groups/check_group_user_availablity',
                data: 'groupid='+groupid+'&guid='+user_id+'&emailid='+email_id,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if(groupid != ""){
                if (result) {
                    var errors = {};
                    var name = $('#maker_email_id_'+index).attr('name');
                    errors[name] = "Entered email_id is already an user of this group.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }

            var counter = $('.maker_row').length;
            for(i=counter; i>0; i--) {
                if ($('#maker_email_id_'+i).val()==email_id && i!=index) {
                    var errors = {};
                    var name = $('#maker_email_id_'+i).attr('name');
                    errors[name] = "Email ID already in use in Maker.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
            var counter = $('.checker_row').length;
            for(i=counter; i>0; i--) {
                if ($('#checker_email_id_'+i).val()==email_id) {
                    var errors = {};
                    var name = $('#checker_email_id_'+i).attr('name');
                    errors[name] = "Email ID already in use in Maker.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
            var counter = $('.admin_row').length;
            for(i=counter; i>0; i--) {
                if ($('#admin_email_id_'+i).val()==email_id) {
                    var errors = {};
                    var name = $('#admin_email_id_'+i).attr('name');
                    errors[name] = "Email ID already in use in Maker.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
        });
    } else {
        var errors = {};
        var name = $('#maker_email_id_1').attr('name');
        errors[name] = "Please add atleast one Maker.";
        validator.showErrors(errors);
        valid = false;
    }
    
    if($('.checker_row').length>0) {
        $('.checker_row').each(function(){
            var id = $(this).attr('id');
            var index = id.substr(id.lastIndexOf('_')+1);
            var user_id = '0';
            var first_name = $('#checker_first_name_'+index).val();
            var last_name = $('#checker_last_name_'+index).val();
            var email_id = $('#checker_email_id_'+index).val();
            var contact_number = $('#checker_contact_number_'+index).val();

            var result = 1;

            $.ajax({
                url: BASE_URL+'index.php/groups/check_contact_availablity',
                data: 'groupid='+groupid+'&groupuserid='+user_id+'&groupusername='+first_name+'&groupuserlastname='+last_name+'&groupemail='+email_id+'&groupmobile='+contact_number,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if (result) {
                var errors = {};
                var name = $('#checker_first_name_'+index).attr('name');
                errors[name] = "First_name, Last_name, Email ID & Mobile No already in use.";
                validator.showErrors(errors);
                valid = false;
            }

            var result = 1;

            $.ajax({
                url: BASE_URL+'index.php/groups/check_email_availablity',
                data: 'groupid='+groupid+'&groupemail='+email_id,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if (result) {
                var errors = {};
                var name = $('#checker_email_id_'+index).attr('name');
                errors[name] = "Entered email_id is already an owner of another group.";
                validator.showErrors(errors);
                valid = false;
            }

            result = 1;

            $.ajax({
                url: BASE_URL+'index.php/groups/check_group_user_availablity',
                data: 'groupid='+groupid+'&guid='+user_id+'&emailid='+email_id,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if(groupid != ""){
                if (result) {
                    var errors = {};
                    var name = $('#checker_email_id_'+index).attr('name');
                    errors[name] = "Entered email_id is already an user of this group.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }

            var counter = $('.maker_row').length;
            for(i=counter; i>0; i--) {
                if ($('#maker_email_id_'+i).val()==email_id) {
                    var errors = {};
                    var name = $('#maker_email_id_'+i).attr('name');
                    errors[name] = "Email ID already in use in Checker.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
            var counter = $('.checker_row').length;
            for(i=counter; i>0; i--) {
                if ($('#checker_email_id_'+i).val()==email_id && i!=index) {
                    var errors = {};
                    var name = $('#checker_email_id_'+i).attr('name');
                    errors[name] = "Email ID already in use in Checker.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
            var counter = $('.admin_row').length;
            for(i=counter; i>0; i--) {
                if ($('#admin_email_id_'+i).val()==email_id) {
                    var errors = {};
                    var name = $('#admin_email_id_'+i).attr('name');
                    errors[name] = "Email ID already in use in Checker.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
        });
    } else {
        var errors = {};
        var name = $('#checker_email_id_1').attr('name');
        errors[name] = "Please add atleast one Checker.";
        validator.showErrors(errors);
        valid = false;
    }
    
    if($('.admin_row').length>0) {
        $('.admin_row').each(function(){
            var id = $(this).attr('id');
            var index = id.substr(id.lastIndexOf('_')+1);
            var user_id = '0';
            var first_name = $('#admin_first_name_'+index).val();
            var last_name = $('#admin_last_name_'+index).val();
            var email_id = $('#admin_email_id_'+index).val();
            var contact_number = $('#admin_contact_number_'+index).val();

            if(first_name!='' || last_name!='' || email_id!='' || contact_number!=''){
                if(first_name==''){
                    var errors = {};
                    var name = $('#admin_first_name_'+index).attr('name');
                    errors[name] = "This field is required.";
                    validator.showErrors(errors);
                    valid = false;
                }
                if(last_name==''){
                    var errors = {};
                    var name = $('#admin_last_name_'+index).attr('name');
                    errors[name] = "This field is required.";
                    validator.showErrors(errors);
                    valid = false;
                }
                if(email_id==''){
                    var errors = {};
                    var name = $('#admin_email_id_'+index).attr('name');
                    errors[name] = "This field is required.";
                    validator.showErrors(errors);
                    valid = false;
                }
                if(contact_number==''){
                    var errors = {};
                    var name = $('#admin_contact_number_'+index).attr('name');
                    errors[name] = "This field is required.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }

            var result = 1;

            $.ajax({
                url: BASE_URL+'index.php/groups/check_contact_availablity',
                data: 'groupid='+groupid+'&groupuserid='+user_id+'&groupusername='+first_name+'&groupuserlastname='+last_name+'&groupemail='+email_id+'&groupmobile='+contact_number,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if (result) {
                var errors = {};
                var name = $('#admin_first_name_'+index).attr('name');
                errors[name] = "First_name, Last_name, Email ID & Mobile No already in use.";
                validator.showErrors(errors);
                valid = false;
            }

            var result = 1;

            $.ajax({
                url: BASE_URL+'index.php/groups/check_email_availablity',
                data: 'groupid='+groupid+'&groupemail='+email_id,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if (result) {
                var errors = {};
                var name = $('#admin_email_id_'+index).attr('name');
                errors[name] = "Entered email_id is already an owner of another group.";
                validator.showErrors(errors);
                valid = false;
            }

            result = 1;

            $.ajax({
                url: BASE_URL+'index.php/groups/check_group_user_availablity',
                data: 'groupid='+groupid+'&guid='+user_id+'&emailid='+email_id,
                type: "POST",
                dataType: 'html',
                global: false,
                async: false,
                success: function (data) {
                    result = parseInt(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });

            if(groupid != ""){
                if (result) {
                    var errors = {};
                    var name = $('#admin_email_id_'+index).attr('name');
                    errors[name] = "Entered email_id is already an user of this group.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }

            var counter = $('.maker_row').length;
            for(i=counter; i>0; i--) {
                if ($('#maker_email_id_'+i).val()==email_id) {
                    var errors = {};
                    var name = $('#maker_email_id_'+i).attr('name');
                    errors[name] = "Email ID already in use in Admin.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
            var counter = $('.checker_row').length;
            for(i=counter; i>0; i--) {
                if ($('#checker_email_id_'+i).val()==email_id) {
                    var errors = {};
                    var name = $('#checker_email_id_'+i).attr('name');
                    errors[name] = "Email ID already in use in Admin.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
            var counter = $('.admin_row').length;
            for(i=counter; i>0; i--) {
                if ($('#admin_email_id_'+i).val()==email_id && i!=index) {
                    var errors = {};
                    var name = $('#admin_email_id_'+i).attr('name');
                    errors[name] = "Email ID already in use in Admin.";
                    validator.showErrors(errors);
                    valid = false;
                }
            }
        });
    } else {
        // var errors = {};
        // var name = $('#admin_email_id_1').attr('name');
        // errors[name] = "Please add atleast one Admin.";
        // validator.showErrors(errors);
        // valid = false;
    }
    
    return valid;
}





// ----------------- PROFILE FORM VALIDATION -------------------------------------
$("#form_profile").validate({
    rules: {
        c_name: {
            required: true,
            lettersonly: true
        },
        c_last_name: {
            required: true,
            lettersonly: true
        },
        // c_dob: {
        //     required: true
        // },
        mobile_no1: {
            required: true,
            numbersonly: true
        },
        email_id1: {
            required: true,
            checkemail: true,
            checkAvailability: true
        },
        // c_pan_card: {
        //     required: true
        // },
        // c_address: {
        //     required: true
        // },
        
        // group_name: {
        //     checkGroupAvailability: true
        // }
    },

    ignore: ":not(:visible)",

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$('#form_profile').submit(function() {
    if (!$("#form_profile").valid()) {
        return false;
    } else {
        return true;
    }
});





// ----------------- ADMIN USER ASSIGN DETAILS FORM VALIDATION -------------------------------------
$("#form_login_email").validate({
    rules: {
        email: {
            required: true,
            checkemail: true,
            checkValidEmail: true
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("checkValidEmail", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Login/check_valid_email',
        data: 'email='+$("#email").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'Email Id does not exist.');

$('#form_login_email').submit(function() {
    if (!$("#form_login_email").valid()) {
        return false;
    } else {
        return true;
    }
});


$("#form_reset_password").validate({
    rules: {
        email: {
            required: true,
            checkemail: true,
            checkValidEmail: true,
            checkValidToken: true
        },
        password: {
            required: true,
            minlength: 6
        },
        confirm_password: {
            required: true,
            minlength: 6,
            equalTo: "#password"
        }
    },

    ignore: false,

    errorPlacement: function (error, element) {
        var placement = $(element).data('error');
        if (placement) {
            $(placement).append(error);
        } else {
            error.insertAfter(element);
        }
    }
});

$.validator.addMethod("checkValidToken", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Login/check_valid_token',
        data: 'email='+$("#email").val() + '&token=' + $("#token").val(),
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            result = parseInt(data);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });

    if (result) {
        return false;
    } else {
        return true;
    }
}, 'This email id and password reset token does not match.');

$('#form_reset_password').submit(function() {
    if (!$("#form_reset_password").valid()) {
        return false;
    } else {
        return true;
    }
});