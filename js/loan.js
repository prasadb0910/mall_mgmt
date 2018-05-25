function loadsubproperty(elem){
    // var property_id = elem.value;
    // var prop_elem_id = elem.id;
    var prop_elem_id = elem.attr('id');
    var index = prop_elem_id.substr(prop_elem_id.lastIndexOf('_')+1);
    var sub_prop_elem_id = "sub_property_" + index;
    var sub_prop_div_elem_id = "sub_property_div_" + index;
    var loan_prope_id_elem_id = "loan_property_id_" + index;
    var loan_property_id = document.getElementById(loan_prope_id_elem_id).value;
    var property_id = document.getElementById("property_" + index).value;

    loan_property_id = (loan_property_id==null || loan_property_id=="")?0:loan_property_id;

    // console.log('Hii2');

    if(property_id>0) {
        index=parseInt(index)-1;
        var xmlhttp=new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
                var data = xmlhttp.responseText;
                document.getElementById(sub_prop_elem_id).innerHTML = data;

                if(data==""){
                    document.getElementById(sub_prop_div_elem_id).style.display='none';
                } else {
                    document.getElementById(sub_prop_div_elem_id).style.display='block';
                }
            }
        };

        // console.log($('#l_id').val());

        xmlhttp.open("POST", BASE_URL+"index.php/Loan/get_sub_property/" + ($('#l_id').val()!=''?$('#l_id').val():'0')  + "/" + loan_property_id + "/" + property_id, true);
        xmlhttp.send();
    } else {
        document.getElementById(sub_prop_elem_id).innerHTML = "";
    }
}

function loadsubproperties(){
    $('select[name="property_id[]"]').each(function(index){
        // console.log('Hii1');
        loadsubproperty($(this));
    });
}

jQuery(function(){
    var counter = $('select.property').length+1;
    $('#repeat-property').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<div id="repeat_property_'+counter+'" class="row clearfix">'+
                                '<div class="col-md-5">'+
                                    '<div class="form-group form-group-default form-group-default-select2">'+
                                        '<label class="">Select Property</label>'+
                                        '<input type="hidden" id="loan_property_id_'+counter+'" name="loan_property_id[]" value="" />'+
                                        '<select id="property_'+counter+'" name="property_id[]" class="form-control property full-width select2" data-error="#err_property_'+counter+'" data-placeholder="Select Property" data-init-plugin="select2">'+property_details+'</select>'+
                                        '<div id="err_property_'+counter+'"></div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-5" id="sub_property_div_'+counter+'" style="display: none;">'+
                                    '<div class="form-group form-group-default form-group-default-select2">'+
                                        '<label class="">Select Sub Property</label>'+
                                        '<select id="sub_property_'+counter+'" name="sub_property[]" class="form-control full-width select2" data-error="#err_sub_property_'+counter+'" data-placeholder="Select Sub Property" data-init-plugin="select2">'+
                                            '<option value="">Select Sub Property</option>'+
                                        '</select>'+
                                        '<div id="err_sub_property_'+counter+'"></div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="delete delete_row" id="repeat_property_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>'+
                            '</div>');
        
        $('#repeatproperty').append(newRow);
        $('.select2', newRow).select2();
        $('.property').change(function(event){
            // console.log('Hii3');
            loadsubproperty($(this));
        });
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
    var counter = $('select.borrower').length+1;
    $('#repeat-borrower').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<div id="repeat_borrower_'+counter+'" class="row clearfix">'+
                                '<div class="col-md-5">'+
                                    '<div class="form-group form-group-default form-group-default-select2">'+
                                        '<label class="">Select Owner</label>'+
                                        '<select id="borrower_'+counter+'" name="borrower[]" class="form-control borrower full-width select2" data-error="#err_borrower_'+counter+'" data-placeholder="Select Owner" data-init-plugin="select2">'+contact_details+'</select>'+
                                        '<div id="err_borrower_'+counter+'"></div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="delete delete_row" id="repeat_borrower_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>'+
                            '</div>');
        
        $('#repeatborrower').append(newRow);
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

loadsubproperties();

$('.property').change(function(event){
    // console.log('Hii3');
    loadsubproperty($(this));
});

function opentable(){
    if(flag==false) {
        document.getElementById('myModal').style.display = "block";
        flag=true;
        $('.datepicker').datepicker({changeMonth: true,changeYear: true});
    } else {
        document.getElementById('myModal').style.display = "block";
    }
}

function calculatetaxes(arg){
    var bsid = arg.getAttribute('id');
    var tyu=bsid.charAt(2);
    
    for (var i = 0; i < tax.length; i++) {
        tax[i]
    };
    var basic=document.getElementById()
}

function savetemp() {
    var formdata = {};
    var formdata={
        sch_type:$('input[name="sch_type[]"]').map(function(){return $(this).val();}).get(),
        sch_event:$('input[name="sch_event[]"]').map(function(){return $(this).val();}).get(),
        sch_date:$('input[name="sch_date[]"]').map(function(){return $(this).val();}).get(),
        sch_basiccost:$('input[name="sch_basiccost[]"]').map(function(){return $(this).val();}).get()
        //sch_event:$('input[name="sch_event[]"]').map(function(){return $(this).val();}).get()
    }

    var sch_type=$('input[name="sch_type[]"]').map(function(){return $(this).val();}).get();
    //console.log(sch_type.length);
    var j=1;
    for(var i=0;i<sch_type.length;++i){
        //console.log("step1");
        formdata['sch_tax_'+j] = $('select[name="sch_tax_'+j+'[]"]').map(function(){return $(this).val();}).get();
        j++;
    }
    console.log(formdata);
    $.ajax({
        url:BASE_URL+"index.php/sale/insertTempSchedule",
        data:formdata,
        dataType:"json",
        type:"POST",
        success:function(responsemydata){
            if(responsemydata.status==1){
                $("#temp_schedule_div").html(responsemydata.data);
                $("#actual_schedule_div").hide();

            }
        },
        error:function(responsemydata,status,error) {
            var err=eval("("+responsemydata.responseText+")");
            alert(err.Message);
        
            //alert(responsemydata.data);
        },
    });

    //var bl=parseInt(document.getElementById('sch_bal').value);
    /*if(bl!=0) {
        alert("Balance should be 0. Kindly check the same.")
    } else {*/

        // document.getElementById('message-box-info').style.display = "none";

        $('#myModal').modal('toggle');
        $("#actual_schedule_div").removeClass('show').addClass('hide');

        //$("#actual_schedule_div").removeClass('show').addClass('hide');
    //}
}

function closetemp() {
    // document.getElementById('message-box-info').style.display = "none";
    flag=false;
}

function instchange(){
    flag=false;
}

function saveTempBulkUpload(){
    var input = ($("#schedule_upload"))[0];
    var upload_txn_type = 'loan';
    file = input.files[0];
    if(file != undefined){
        formData= new FormData();            
        formData.append("data_file", file);
        formData.append("upload_txn_type",upload_txn_type);
        $.ajax({
            url: BASE_URL + "index.php/purchase/saveTempBulkUpload",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(data){
                if(data.status==0){
                    alert(data.errormsg);
                }
                else{
                    var counter=data.rowcounter;
                    var tst=data.rowcounter;
                    $("#rowdisplaycount").val(parseInt(data.rowcounter)-1);

                    window.cntrinst=tst-1;
                    $("#schedule_id").val(tst-1);
                    $("#import_schedule").html(data.data);

                    $('.select3').select2();

                    $('.datepicker').datepicker({changeMonth: true,changeYear: true});

                    // $("#message-box-info").html(data.data);
                    // $('.select').selectpicker();
                    // $('.datepicker').datepicker({changeMonth: true,changeYear: true});
                    // $('#schedule_upload').bootstrapFileInput();
                    // //$('.repeat-schedule').trigger('click');
                    // $('.repeat-schedule').click(function(event){
                    //     event.preventDefault();
                    //     //alert(window.cntrinst);
                    //     scheduleRepeat();
                    // });
                    // $('.reverse-schedule').click(function(event){
                    //     event.preventDefault();
                    //     //alert(window.cntrinst);
                    //     scheduleReverse();
                        
                    // });

                    $('.sch_basiccost').each(function(){
                        format_number(this);
                    });
                    $('.format_number').keyup(function(){
                        format_number(this);
                    });
                    $("form :input").change(function() {
                        $(".save-form").prop("disabled",false);
                    });
                }
                 }
        });
//                
    }else{
        $("#file_photo_error").html('Input something!');
//                alert('Input something!');
    }
}

jQuery(function(){
                
    $('.sch').click(function(event){
        event.preventDefault();
        // alert('hi');
    });
});

jQuery(function(){

$('.repeat-schedule').click(function(event){
        event.preventDefault();
        scheduleRepeat();
    });
    $('.reverse-schedule').click(function(event){
        scheduleReverse();
    });
});

function scheduleRepeat(){
    var counter = $("#rowdisplaycount").val();
    //alert(counter);
    counter++;
    var rows='';
    //collen=tax.length;
    //alert(collen);
    // if(counter%2==0)
    // {
    //  var newRow = jQuery('<tr> <td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" id="txttype" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtevent" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtdtp" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtprojdate" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtrevdate" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtprojamount" class="form-control" style="border:none;"/></td> <td><input type="text" id="txttds" class="form-control" style="border:none;"/></td> </tr>');
    //  $('.addschedule').append(newRow);
    // }
    // else
    // {
    //  var newRow = jQuery('<tr> <td style="color:#000; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" id="txttype" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtevent" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtdtp" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtprojdate" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtrevdate" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtprojamount" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txttds" class="form-control" style="border:none;background:none;"/></td> </tr>');
    // }
    rows= jQuery("<tr id='repeat_schedule_"+counter+"'> <td style='color:#000;background:#F9F9F9; vertical-align: middle;' align='middle'>"+ counter +"</td> <td><input type='text'  name='sch_type[]' class='form-control' value='' style='border:none;'/></td><td><input type='text'  name='sch_event[]' class='form-control' value='' style='border:none;'/></td> <td><input type='text'  name='sch_date[]' value=''  class='form-control datepicker' style='border:none;'/></td> <td><input type='text' name='sch_basiccost[]' value='' class='form-control format_number' style='border:none; '/></td><td><select name='sch_tax_"+counter+"[]' multiple class='full-width select2' data-placeholder='Select Tax' data-init-plugin='select2'>"+tax_list_details+"</select></td></tr>");
    // counter++;
    $('.addschedule').append(rows); 
    $("#rowdisplaycount").val(counter);
    $('.datepicker').datepicker({changeMonth: true,changeYear: true,yearRange:'-100:+100'});
    // $('.select').selectpicker();
    $('.select2', rows).select2();
    $('.format_number').keyup(function(){
        format_number(this);
    });
    $("form :input").change(function() {
        $(".save-form").prop("disabled",false);
    });
}

function scheduleReverse(){
    var counter = $("#rowdisplaycount").val();
//    var ctr=window.cntrinst;
    // var counter = tst;
    // if(ctr == 0){
    // var tst=$("#schedule_id").val();                     
    // }
    // else{
    //  //alert(ctr);
    //  tst=parseInt(ctr);
    // }
    var id="#repeat_schedule_"+(counter).toString();
    if($(id).length>0){
        $(id).remove();
        counter--;
        // window.cntrinst=counter;
        $("#rowdisplaycount").val(counter);
        $("#schedule_id").val(counter);
    }
}

// jQuery(function(){
// var counter = 1;
// $('.repeat-schedule').click(function(event){
//      event.preventDefault();
//      counter++;
//      if(counter%2==0)
//      {
//          var newRow = jQuery('<tr> <td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" id="txttype" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtevent" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtdtp" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtprojdate" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtrevdate" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtprojamount" class="form-control" style="border:none;"/></td> <td><input type="text" id="txttds" class="form-control" style="border:none;"/></td> </tr>');
//          $('.addschedule').append(newRow);
//      }
//      else
//      {
//          var newRow = jQuery('<tr> <td style="color:#000; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" id="txttype" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtevent" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtdtp" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtprojdate" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtrevdate" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtprojamount" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txttds" class="form-control" style="border:none;background:none;"/></td> </tr>');
//          $('.addschedule').append(newRow);
//      }
//  });
// });

$(document).ready(function(){
    $('#loan_type').change(function(){
        if(this.value=="LAP") {
            $('#security').show();
            $('#next_panel').attr("href", "#accOneColFour");
        } else {
            $('#security').hide();
            $('#next_panel').attr("href", "#accOneColFive");
        }
    });
});

$( "#loan_ref_name" ).change(function() {
    var loan_txn_id = $("#loan_ref_name").val();
    $.ajax({
        url: BASE_URL + "index.php/loan_disbursement/get_loan_details/" + loan_txn_id,
        data: $("#form_loan_disbursement").serialize(),
        cache: false,
        type: "POST",
        dataType: 'json',
        global: false,
        async: false,
        success: function (data) {
            if(data!=null) {
                $("#loan_ref_id").val(data.loan_ref_id);
                $("#loan_type").val(data.loan_type);
                $("#loan_amount").val(data.loan_amount);
                $("#loan_start_date_text").val(data.loan_startdate);
                $("#loan_due_day_text").val(data.loan_due_day);
                $("#loan_term_text").val(data.loan_term);
                $("#loan_start_date").val(data.loan_startdate);
                $("#loan_due_day").val(data.loan_due_day);
                $("#loan_term").val(data.loan_term);
                $("#loan_interest_rate").val(data.loan_interest_rate + '%');
                $("#loan_interest_type").val(data.loan_interest_type);
                $("#repayment").val(data.repayment);
                $("#purpose").val(data.purpose);
                $("#financial_institution").val(data.financial_institution);
            } else {
                $("#loan_ref_id").val('');
                $("#loan_type").val('');
                $("#loan_amount").val('');
                $("#loan_start_date_text").val('');
                $("#loan_due_day_text").val('');
                $("#loan_term_text").val('');
                $("#loan_start_date").val('');
                $("#loan_due_day").val('');
                $("#loan_term").val('');
                $("#loan_interest_rate").val('');
                $("#loan_interest_type").val('');
                $("#repayment").val('');
                $("#purpose").val('');
                $("#financial_institution").val('');
            }
        },
        error: function (xhr, status, error) {
                //alert(xhr.responseText);
        }
    });
});

$( "#payment_mode" ).change(function() {
    checkMode();
});

function checkMode(){
    if($( "#payment_mode" ).val()=="Cheque"){
        $("#payment_id_details").show();
        $("#payment_id_type").html("Cheque No");
        $("#cheq_no").val("");
    } else if($( "#payment_mode" ).val()=="NEFT"){
        $("#payment_id_details").show();
        $("#payment_id_type").html("Ref No");
        $("#cheq_no").val("");
    } else {
        $("#payment_id_details").hide();
    }
}

function getdocuments() {
    if($('#l_id').val()){
        var counter = 0;
        var propid = document.getElementById("property").value;
        $('#adddoc').empty();

        $.ajax({
            url: BASE_URL + "index.php/Rent/loaddocuments/" + propid,
            data: $("#form_loan_disbursement").serialize(),
            cache: false,
            type: "POST",
            dataType: 'json',
            global: false,
            async: false,
            success: function (data) {
                if(data.status==1){
                    $('#adddoc').html("");
                    $('#adddoc').html(data.data);
                    $(".datepicker1").datepicker({ maxDate: 0,changeMonth: true,yearRange:'-100:+0',changeYear: true });
                    $('.datepicker').datepicker();
                    $('.delete_row').click(function(event){
                        delete_row($(this));
                    });
                    $("form :input").change(function() {
                        $(".save-form").prop("disabled",false);
                    });
                }
            },
            error: function (xhr, status, error) {
                    //alert(xhr.responseText);
            }
        });
    }
}