function loadinittable(){
    var area=document.getElementById("agreement_area").value;
    document.getElementById("area_1").value = area;
    document.getElementById("area_2").value = area;
    document.getElementById("area_3").value = area;
}

function totcost(arg) {
    var bsid = arg.getAttribute('id');
    var rate=parseInt(document.getElementById(bsid).value);
    
    var tyu='';
    for (var i = 5; i < bsid.length; i++) {
        tyu=tyu+bsid.charAt(i);
    };
    var obtid='area_'+tyu;
    var area = parseInt(document.getElementById(obtid).value);
    var cost = rate * area;
    document.getElementById('total_' + tyu).value = cost;
}

function opentable(){
    if(flag==false) {
        document.getElementById('myModal').style.display = "block";
        flag=true;
        $('.datepicker').datepicker({changeMonth: true,changeYear: true});
    } else {
        document.getElementById('myModal').style.display = "block";
    }

    // $('#myModal').parent().css('z-index',3000);
}

function calculatetaxes(arg){
    var bsid = arg.getAttribute('id');
    var bsicamt=document.getElementById(bsid).value;
    
    var tyu='';
    for (var i = 3
        ; i < bsid.length; i++) {
        tyu=tyu+bsid.charAt(i);
    };
    
    var nwamt=0;
    var netamt=0;
    for (var i = 0; i < tax.length; i++) {
        var tx=tax[i];
        var oper=taxpurpose[i];
        if(oper=="Add") {
            nwamt=Math.round(bsicamt*tx/100);
            netamt=netamt + nwamt;
        } else if (oper=="Subtract") {
            nwamt=Math.round(bsicamt*tx/100);
            netamt = netamt - nwamt;
        }
        var tempid = 'tx_'+i+'_'+tyu;
        document.getElementById(tempid).value=nwamt;
    };
    //document.getElementById('bs_'+tyu).value=bsicamt;
    document.getElementById('ntat_'+tyu).value=netamt;
    if(document.getElementById('purchase').value!=''){
        var cstprc=parseInt(document.getElementById('purchase').value); 
    } else {
        var cstprc=0;
    }
    
    var newcst=0;
    if(document.getElementById('downpymnt').value!=''){
        var dwnpymt=parseInt(document.getElementById('downpymnt').value);   
    } else {
        var dwnpymt=0;  
    }
    
    var inst=document.getElementById('installments').value;


    for (var i = 0; i <= window.cntrinst; i++) {
        var bsc = parseInt(document.getElementById('bs_'+i).value);
        newcst=newcst + bsc;
    };
    var bal = newcst + dwnpymt;
    bal = cstprc - bal;
    document.getElementById('sch_bal').value=bal;
}

function savetemp() {
    removeMultiInputNamingRules('#form_sale', 'input[alt="sch_type[]"]');
    removeMultiInputNamingRules('#form_sale', 'input[alt="sch_event[]"]');
    removeMultiInputNamingRules('#form_sale', 'input[alt="sch_date[]"]');
    removeMultiInputNamingRules('#form_sale', 'input[alt="sch_basiccost[]"]');

    addMultiInputNamingRules('#form_sale', 'input[name="sch_type[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_sale', 'input[name="sch_event[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_sale', 'input[name="sch_date[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_sale', 'input[name="sch_basiccost[]"]', { required: true }, "");

    var valid = true;

    if (!$("#form_sale").valid()) {
        $("#schedule_table").find('.error').each(function(index) {
            if($(this).is(":visible")){
                valid = false;
            }
        });
    }

    if (valid==true) {
        removeMultiInputNamingRules('#form_sale', 'input[alt="sch_type[]"]');
        removeMultiInputNamingRules('#form_sale', 'input[alt="sch_event[]"]');
        removeMultiInputNamingRules('#form_sale', 'input[alt="sch_date[]"]');
        removeMultiInputNamingRules('#form_sale', 'input[alt="sch_basiccost[]"]');
        
        var formdata = {};
        var formdata={
            sch_type:$('input[name="sch_type[]"]').map(function(){return $(this).val();}).get(),
            sch_event:$('input[name="sch_event[]"]').map(function(){return $(this).val();}).get(),
            sch_date:$('input[name="sch_date[]"]').map(function(){return $(this).val();}).get(),
            sch_basiccost:$('input[name="sch_basiccost[]"]').map(function(){return $(this).val();}).get(),
            // sch_pay_type:$('input[name="sch_pay_type[]"]').map(function(){return $(this).val();}).get(),
            // sch_agree_value:$('input[name="sch_agree_value[]"]').map(function(){return $(this).val();}).get()
        }

        var sch_type=$('input[name="sch_type[]"]').map(function(){return $(this).val();}).get();
        console.log(sch_type.length);
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
            async:false,
            success:function(responsemydata){
                if(responsemydata.status==1){
                    $("#temp_schedule_div").html(responsemydata.data);
                    // alert(responsemydata.total_net_amount);
                    $("#sales_consideration").val(responsemydata.total_net_amount);
                }
            //  alert("step 1 clear");
            },
        });
    
        //var bl=parseInt(document.getElementById('sch_bal').value);
        /*if(bl!=0) {
            alert("Balance should be 0. Kindly check the same.")
        } else {*/

            // document.getElementById('myModal').style.display = "none";
            $('#myModal').modal('toggle');
            $("#actual_schedule_div").removeClass('show').addClass('hide');
        //}

        calculateprofit();
    }
}


function closetemp() {
    // document.getElementById('myModal').style.display = "none";
    flag=false;
}

function instchange(){
    flag=false;
}
$( "#property" ).change(function() {
    var property=$("#property").val();
    var dataString = 'property_id=' + property + '&txn_id=' + ($('#s_id').val()==''?0:$('#s_id').val());

    $.ajax({
       type: "POST",
       url: BASE_URL + "index.php/sale/get_sub_property",
       data: dataString,
       cache: false,
       success: function(data){

          if(data!=0)
          {
              var html = '<option value="" Selected>Select Sub Property</option>';
              var obj = $.parseJSON(data);
              var subproperty = obj['sub_property'];
              var sub_property_id = obj['sub_property_id'];
              $.each(subproperty, function()
              { 
                if (sub_property_id == this['sp_id']) 
                {
                    html += '<option value="'+this['sp_id']+ '" selected>'+ this['sp_name']+'</option>';
                }
                else
                {
                    html += '<option value="'+this['sp_id']+ '" >'+ this['sp_name']+'</option>';   
                }
                
              });
              $("#sub_property").html(html);
              $("#subproperty").show();
          }
          else
          {    
             $("#sub_property").empty();
             $("#subproperty").hide();   
          } 
          
       } 
    });
});

jQuery(function(){
    $('#repeat-buyer').click(function(event){
        event.preventDefault();
        var counter = $('select.buyer').length+1;

        var newRow = jQuery('<div id="repeat_buyer_'+counter+'" class="row clearfix">'+
                                    '<div class="col-md-5">'+
                                        '<div class="form-group form-group-default form-group-default-select2">'+
                                            '<label class="">Select buyer</label>'+
                                            '<select id="buyer_name_'+counter+'" name="buyername[]" class="form-control buyer full-width select2" data-error="#err_buyer_name_'+counter+'" data-placeholder="Select Buyer" data-init-plugin="select2">'+contact_details+'</select>'+
                                            '<div id="err_buyer_name_'+counter+'"></div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-md-5">'+
                                        '<div class="form-group form-group-default">'+
                                            '<label>% of buyer</label>'+
                                            '<input type="text" id="sharepercent_'+counter+'" name="sharepercent[]" class="form-control" placeholder="% of buyer" value=""/>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="delete delete_row" id="repeat_buyer_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>'+
                                '</div>');
        
        $('#repeatbuyer').append(newRow);
        $('.select2', newRow).select2();
        $('.delete_row').click(function(event){
            delete_row($(this));
        });
        $('form :input').change(function() {
            $('.save-form').prop("disabled",false);
        });
    });
});

jQuery(function(){
    $("#sale_date").change(function() {
        //alert("hii");
        calculateprofit();
    });
});

jQuery(function(){
    var counter = 1;
    var tst=1;
    $('.repeat-schedule').click(function(event){
        event.preventDefault();

        scheduleRepeat(counter,tst);
    });
    $('.reverse-schedule').click(function(event){
        scheduleReverse(counter,tst);
    });
});
    
function scheduleRepeat(counter,tst){
    var ctr=window.cntrinst;
    var counter = tst;
    if(ctr == 0){
    var tst=parseInt($("#schedule_id").val())+1;                        
    }
    else{
        //alert(ctr);
        tst=parseInt(ctr)+parseInt(1);
    }
    var newRow= jQuery('<tr id="repeat_schedule_'+tst+'"><td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle">'+tst+'</td><td><input type="text"  name="sch_type[]" class="form-control" value="" style="border:none;"/></td>  <td><input type="text"  name="sch_event[]" class="form-control" value="" style="border:none;"/></td> <td><input type="text"  name="sch_date[]" value="" class="form-control datepicker" style="border:none;"/></td><td><input type="text"  name="sch_basiccost[]" value="" class="form-control format_number" style="border:none; text-align: right;"/></td><td><select name="sch_tax_'+tst+'[]" multiple class=" select3">'+tax_list_details+'<select></td></tr>');
    $('.addschedule').append(newRow);
    $('.select3').select2();
    //counter++;
    //tst++;
    window.cntrinst=tst;

    $('.datepicker').datepicker({changeMonth: true,changeYear: true,yearRange:'-100:+100'});
    $('.format_number').keyup(function(){
        format_number(this);
    });
    $("form :input").change(function() {
        $(".save-form").prop("disabled",false);
    });
}

function scheduleReverse(counter,tst){
    var ctr=window.cntrinst;
    var counter = tst;
    if(ctr == 0){
    var tst=$("#schedule_id").val();                        
    }
    else{
        //alert(ctr);
        tst=parseInt(ctr);
    }
    var id="#repeat_schedule_"+(tst).toString();
    if($(id).length>0){
        $(id).remove();
        tst--;
        window.cntrinst=tst;
        $("#schedule_id").val(tst);
    }
}

function loadclientdetail(){
    var propid = document.getElementById("property").value;
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if(xmlhttp.readyState == 4 && xmlhttp.status == 200 ){
            document.getElementById("costpurchase").value = xmlhttp.responseText;
        } 
    };

    xmlhttp.open("POST", BASE_URL + "index.php/Sale/loadpropertydet/" + propid, true);
    xmlhttp.send();

    calculateprofit();
}

$("#sale_date","#property").change(function(){
     getcostofacquisition();
})

function getcostofacquisition(){
    var propid = document.getElementById("property").value;
    var saledate = document.getElementById("sale_date").value;
    // var parameters="property="+propid;

    // alert(propid + ' ' + saledate);

    $.ajax({
        url: BASE_URL + "index.php/Sale/getcostofacquisition",
        data: 'property=' + propid + '&sale_date=' + saledate,
        cache: false,
        type: "POST",
        dataType: 'html',
        global: false,
        async: false,
        success: function (data) {
            if (isNaN(data)){
                data=0;
            }
            document.getElementById('cost_of_acquisition').value = data;
        },
        error: function (xhr, status, error) {
                //alert(xhr.responseText);
        }
    });

    var cost_of_acquisition = parseFloat(get_number(document.getElementById("cost_of_acquisition").value,2));
    var sales_consideration = parseFloat(get_number(document.getElementById("sales_consideration").value,2));

    var profit_or_loss = sales_consideration - cost_of_acquisition;
    document.getElementById('profit_loss').value = profit_or_loss;
}

function calculateprofit(){
//          var sell_price=0;
//          var cost_price=0;
//          var registeration=0;
//          var stampduty=0;
//          var brokeramt=0;

//          if(document.getElementById("saleamount").value!='') {
//              sell_price=parseFloat(document.getElementById("saleamount").value);
//          }
//          if(document.getElementById("costpurchase").value!='') {
    //  cost_price=parseFloat(document.getElementById("costpurchase").value);
//          }
//          if(document.getElementById("registeration").value!='') {
//              registeration=parseFloat(document.getElementById("registeration").value);
//          }
//          if(document.getElementById("stampduty").value!=''){
//              stampduty=parseFloat(document.getElementById("stampduty").value);
//          }
    // if(document.getElementById("brokerage_amount").value!=''){
//              broker=parseFloat(document.getElementById("brokerage_amount").value);
//          }

//          // alert(sell_price + ' ' + cost_price + ' ' + registeration + ' ' + stampduty + ' ' + broker);


//          //var profitloss=sell_price-cost_price-registeration-stampduty-broker;
    // //document.getElementById("profit_loss").value=parseFloat(profitloss);

    // var sales_consideration=sell_price-registeration-stampduty-broker;
    // document.getElementById("sales_consideration").value=parseFloat(sales_consideration);

    // alert("calculateprofit");
    getcostofacquisition();

}

function getdocuments() {
    var propid = document.getElementById("property").value;

    if($('#s_id').val()!=''){
        var counter = 0;
        $('#adddoc').empty();

        $.ajax({
            url: BASE_URL + "index.php/Sale/loadsaledocuments/" + propid,
            data: $("#form_sale").serialize(),
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
                    $('.datepicker').datepicker({changeMonth: true,changeYear: true});
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

$(document).ready(function(){
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
});


function saveTempBulkUpload(){
    var input = ($("#schedule_upload"))[0];
    var upload_txn_type = 'sale';
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
                            window.cntrinst=tst-1;
                            $("#schedule_id").val(tst-1);
                            $("#import_schedule").html(data.data);
                            $('.select3').select2();
                            $('.datepicker').datepicker({changeMonth: true,changeYear: true});

                            // $('#schedule_upload').bootstrapFileInput();
                            // //$('.repeat-schedule').trigger('click');
                            // $('.repeat-schedule').click(function(event){
                            //     event.preventDefault();
                            //     //alert(window.cntrinst);
                            //     scheduleRepeat(counter,tst);
                            // });
                            // $('.reverse-schedule').click(function(event){
                            //     event.preventDefault();
                            //     //alert(window.cntrinst);
                            //     scheduleReverse(counter,tst);
                                
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
    }else{
        $("#file_photo_error").html('Input something!');
    }
}