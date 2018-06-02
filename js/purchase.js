// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
var placeSearch, autocomplete;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
};

function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
    /** @type {!HTMLInputElement} */(document.getElementById('googlemaplink')),
    {types: ['geocode']});
    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    //autocomplete.addListener('place_changed', fillInAddress);
}

// Get each component of the address from the place details
// and fill the corresponding field on the form.

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var geolocation = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        var circle = new google.maps.Circle({
          center: geolocation,
          radius: position.coords.accuracy
        });
        autocomplete.setBounds(circle.getBounds());
      });
    }
}

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
    var bsicamt = parseInt(document.getElementById(bsid).value.replace(',',''));
    
    var tyu='';
    for (var i = 3; i < bsid.length; i++) {
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
    removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_type[]"]');
    removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_event[]"]');
    removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_date[]"]');
    removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_basiccost[]"]');

    addMultiInputNamingRules('#form_purchase', 'input[name="sch_type[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_purchase', 'input[name="sch_event[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_purchase', 'input[name="sch_date[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_purchase', 'input[name="sch_basiccost[]"]', { required: true }, "");

    var valid = true;

    if (!$("#form_purchase").valid()) {
        $("#schedule_table").find('.error').each(function(index) {
            if($(this).is(":visible")){
                valid = false;
            }
        });
    }

    if (valid==true) {
        removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_type[]"]');
        removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_event[]"]');
        removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_date[]"]');
        removeMultiInputNamingRules('#form_purchase', 'input[alt="sch_basiccost[]"]');

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
        //console.log(formdata);
        $.ajax({
            url:BASE_URL + "index.php/sale/insertTempSchedule",
            data:formdata,
            dataType:"json",
            type:"POST",
            success:function(responsemydata){
                if(responsemydata.status==1){
                    $("#temp_schedule_div").html(responsemydata.data);
                }
                //alert(responsemydata.data);
            },
        });
    
        //var bl=parseInt(document.getElementById('sch_bal').value);
        /*if(bl!=0) {
            alert("Balance should be 0. Kindly check the same.")
        } else {*/

            $('#myModal').modal('toggle');
            $("#actual_schedule_div").removeClass('show').addClass('hide');

            // document.getElementById('myModal').style.display = "none";
            // $("#myModal").removeClass('show');

            // $("#myModal").removeClass('show')
        //}
    }
}

function closetemp() {
    // document.getElementById('myModal').style.display = "none";
    flag=false;
}

function instchange(){
    flag=false;
}

jQuery(function(){
    $('.sch').click(function(event){
        event.preventDefault();
        //alert('hi');
    });
});

jQuery(function(){
    var counter = $('select.ownership').length+1;
    $('#repeat-owner').click(function(event){
        event.preventDefault();

        // var newRow = jQuery('<div class="form-group" id="repeat_owner_'+counter+'"> <div class="col-md-6"> <div class=""> <label class="col-md-3 control-label">Owner Name <span class="asterisk_sign">*</span></label> <div class="col-md-9"> <input type="hidden" id="owner_name_'+counter+'_id" name="clientname[]" class="form-control" /> <input type="text" id="owner_name_'+counter+'" name="owner_contact_name[]" class="form-control auto_owner ownership" placeholder="Type to choose owner from database..." /> </div> </div> </div> <div class="col-md-6" style=""> <div class=""> <label class="col-md-3 control-label" >% of Ownership <span class="asterisk_sign">*</span></label> <div class="col-md-9">     <label  style="padding:10px 5px;"  > % </label> <input type="text" class="form-control format_number" id="owner_percent_'+counter+'" name="ownership[]" placeholder="% of Ownership" style="width:90%; float:left;"/> </div> </div> </div> <div class="col-md-4" style="display: none;"> <div class=""> <label class="col-md-5 control-label">Allocated Cost</label> <div class="col-md-7">  <input type="text" class="form-control format_number" name="allocatedcost[]" placeholder="Allocated Cost of Property" /> </div> </div> </div> </div>');
        var newRow = jQuery('<div id="repeat_owner_'+counter+'" class="row clearfix">'+
                                    '<div class="col-md-5">'+
                                        '<div class="form-group form-group-default form-group-default-select2">'+
                                            '<label class="">Select Owner</label>'+
                                            '<select id="owner_name_'+counter+'" name="clientname[]" class="form-control ownership full-width select2" data-error="#err_owner_name_'+counter+'" data-placeholder="Select Owner" data-init-plugin="select2">'+contact_details+'</select>'+
                                            '<div id="err_owner_name_'+counter+'"></div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="delete delete_row" id="repeat_owner_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>'+
                                '</div>');
        
        $('#repeatowner').append(newRow);
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
    var counter = $('input.prop_description').length;

    /*if(counter>=2)
    {
       counter = counter-1;   
    }*/
    console.log('counter'+counter);
    $('#repeat-img').click(function(event){
        event.preventDefault();

        // var newRow = jQuery('<div class="form-group"><div class="col-md-6"><div class="" style=""><label class="col-md-3 control-label">Upload Image</label><div class="col-md-9"> <a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse</span><input type="file" class="fileinput btn-primary" name="propertydoc_' + counter + '" style="left: -157.313px; top: -3px;"></a> </div> </div> </div> <div class="col-md-6"> <div class=""> <label class="col-md-3 control-label" style="padding-left: 0px;padding-right: 0px;">Captured Date</label> <div class="col-md-9"> <input type="text" class="form-control datepicker" name="capture_date[]" placeholder="Captured Date"/> </div> </div> </div> <div class="col-md-4" style="display:none;"> <div class=""> <label class="col-md-3 control-label" style="padding-left: 0px;padding-right: 0px;">Description</label> <div class="col-md-9"> <input type="text" class="form-control" name="capture_description[]" placeholder="Description"/> </div> </div> </div></div>');
        // var newRow = jQuery('<div class="form-group" id="repeat_img_'+counter+'"><div class="col-md-4"><div class="abs" style="margin-left: 28px;"><label class="col-md-4 control-label" style="padding-left: 0px;padding-right: 0px;">Upload Image</label><div class="col-md-8"><a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>Browse</span><input type="file" class="fileinput btn-primary" name="propertydoc_' + (counter-1) + '" style="left: -157.313px; top: -3px;"/></a></div></div></div><div class="col-md-4"><div class=""><label class="col-md-4 control-label" style="padding-left: 0px;padding-right: 0px;">Captured Date</label><div class="col-md-8"><input type="text" class="form-control datepicker" name="capture_date[]" placeholder="Captured Date"/></div></div></div><div class="col-md-4"><div class=""><label class="col-md-3 control-label" style="padding-left: 0px;padding-right: 0px;">Description</label><div class="col-md-9"><input  type="text" class="form-control" name="capture_description[]" placeholder="Description"/></div></div></div></div>');
        var newRow = jQuery('<div id="repeat_img_'+counter+'" class="row clearfix">'+
                                '<div class="col-md-3">'+
                                    '<div class="form-group form-group-default ">'+
                                        '<label>Captured Date</label>'+
                                        '<input type="text" class="form-control datepicker prop_description" name="capture_date[]" placeholder="Captured Date" value="" />'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-3">'+
                                    '<div class="form-group form-group-default ">'+
                                        '<label>Description</label>'+
                                        '<input type="text" class="form-control" name="capture_description[]" placeholder="Description" value="" />'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-5">'+
                                    '<div class="fileUpload blue-btn btn width100">'+
                                        '<span><i class="fa fa-cloud-upload"></i> Upload Image</span>'+
                                        '<input type="file" class="uploadlogo" name="propertydoc_'+counter+'" />'+
                                    '</div>'+
                                '</div>'+
                                '<div class="delete delete_row" id="repeat_img_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>'+
                            '</div>');
        $('#repeatimg').append(newRow);
        $('.datepicker', newRow).datepicker({changeMonth: true,changeYear: true});
        $('.delete_row').click(function(event){
            delete_row($(this));
        });
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
        $(".uploadlogo").change(function() {
            readURL(this);
        });
        counter++;
    });
});

jQuery(function(){
    var counter = 7;
    var tst=1;
    $('.repeat-summary').click(function(event){
        event.preventDefault();
        //alert(window.cntrinst);
        var ctr=window.cntrinst;
        //alert(ctr);
        //counter = counter+ctr;
        window.cntrinst=counter;
        tst=counter+1;
        var newRow = jQuery('<tr id="repeat_summary_'+counter+'"><td style="color:#000; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" name="cost_head[]" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" name="txtarea[]" id="area_' + counter + '" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" name="txtrate[]" id="rate_' + counter + '" onkeyup="totcost(this);" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" name="txttotalcost[]" id="total_' + counter + '" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="inst_'+ counter + '" name="txtnoofinstallment[]" class="form-control" style="border:none;background:none;"/></td> </tr>');
        $('.addsummary').append(newRow);
        $('.datepicker').datepicker({changeMonth: true,changeYear: true});
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
        counter++;
    });
    $('.reverse-summary').click(function(event){
        if((counter-1)!=1){
            var id="#repeat_summary_"+(counter-1).toString();
            if($(id).length>0){
                $(id).remove();
                counter--;
            }
        }
    });
});

jQuery(function(){
    var counter = 5;
    var tst=1;
    $('.repeat-tax').click(function(event){
        event.preventDefault();
        //alert(window.cntrinst);
        var ctr=window.cntrinst;
        //alert(ctr);
        //counter = counter+ctr;
        window.cntrinst=counter;
        tst=counter+1;
        var newRow = jQuery('<tr> <td style="color:#000; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" name="txttaxcosthead[]" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" name="txttaxrateinpercent[]" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" name="txttaxtotalcost[]" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" name="txttaxnoofinstallment[]" class="form-control" style="border:none;background:none;"/></td> </tr>');
        $('.addtax').append(newRow);
        $("form :input").change(function() {
            $(".save-form").prop("disabled",false);
        });
        counter++;
        
    });
});

jQuery(function(){
    var counter = 1;
    var tst=1;
    $('.repeat-schedule').click(function(event){
        event.preventDefault();
        //alert(window.cntrinst);
        scheduleRepeat(counter,tst);
    });
    $('.reverse-schedule').click(function(event){
        scheduleReverse(counter,tst);
    });
});

function scheduleRepeat(counter,tst){
    var ctr=window.cntrinst;
    //alert(ctr);
    var counter = tst;
    if(ctr == 0){
    var tst=parseInt($("#schedule_id").val())+1;                        
    }
    else{
        //alert(ctr);
        tst=parseInt(ctr)+parseInt(1);
    }
    // var newRow = jQuery('<tr><td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle">'+tst+'</td><td><input type="text" id="txttype" name="sch_event[]" class="form-control" value="" style="border:none;"/></td><td><input type="text" id="txtevent" name="sch_date[]" value="" class="form-control datepicker" style="border:none;"/></td><td><input type="text" id="bs_'+counter+'"  onkeyup="calculatetaxes(this);""  name="sch_basiccost[]" value="" class="form-control format_number" style="border:none;"/></td><?php //for ($j=0; $j < count($tax) ; $j++) { $txa="tx_".$j; echo "<td><input type=\"text\" id=\"tx_".$j."_'+counter+'\" name=\"sch_tax".$j."[]\"  value=\"\" class=\"form-control\" style=\"border:none;\"/></td>";} ?><td><input type="text" id="ntat_'+counter+'" name="sch_netamount[]"  value="" class="form-control" style="border:none;"/></td> </tr>');
    // var newRow= jQuery('<tr><td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle">'+tst+'</td><td><input type="text"  name="sch_type[]" class="form-control sch_type" value="" style="border:none;"/></td>   <td><input type="text"  name="sch_event[]" class="form-control" value="" style="border:none;"/></td><td><input type="text" id="txtpaytype" name="sch_pay_type[]" class="form-control" value="" style="border:none;"/></td><td><input type="radio"name="sch_agree_value['+tst+']"id="sch_agree_yes_'+tst+'" value="yes" /><font style="color:#000;">Yes</font> &nbsp;&nbsp;<input type="radio" name="sch_agree_value['+tst+']" id="sch_agree_no_'+tst+'" value="no" /><font style="color:#000;">No</font></td><td><input type="text"  name="sch_date[]" value="" class="form-control datepicker" style="border:none;"/></td><td><input type="text"  name="sch_basiccost[]" value="" class="form-control format_number" style="border:none; text-align:right;"/></td><td><select name="sch_tax_'+tst+'[]" multiple class="form-control select" style="display: none;"><?php //if(isset($tax_details)){foreach($tax_details as $row){echo "<option value=".$row->tax_id.">".$row->tax_name."-".$row->tax_percent."</option>";}}?><select></td></tr>');
    var newRow= jQuery('<tr id="repeat_schedule_'+tst+'"><td style="vertical-align: middle;" align="middle">'+tst+'</td><td><input type="text"  name="sch_type[]" class="form-control sch_type" value="" style="border:none;"/></td> <td><input type="text"  name="sch_event[]" class="form-control" value="" style="border:none;"/></td><td><input type="text"  name="sch_date[]" value="" class="form-control datepicker" style="border:none; text-align:left; background:#ffffff; color:rgb(44, 44, 44)!important;" readonly /></td><td><input type="text"  name="sch_basiccost[]" value="" class="form-control format_number" style="border:none; text-align:right;"/></td><td class="form-group-default-select2"><select name="sch_tax_'+tst+'[]" multiple class="form-control full-width select2" data-placeholder="Select Tax" data-init-plugin="select2">'+tax_list_details+'<select></td></tr>');
    $('.addschedule').append(newRow);
    // $('.select').selectpicker();
    $('.select2', newRow).select2();
    //counter++;
    //tst++;
    window.cntrinst=tst;

    // $('.date').datepicker({changeMonth: true,changeYear: true,yearRange:'-100:+100'});
    $('.datepicker', newRow).datepicker();
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

$(document).ready(function(){
    $('.p_status').show();

    if($('#ptype option:selected').val()=="Land - Agriculture" || $('#ptype option:selected').val()=="Land - Non Agriculture" || $('#ptype option:selected').val()=="Bunglow") {
        $('.aptname').hide();
    } else {
        $('.aptname').show();
    }

    if($('#ptype option:selected').val()=="Building") {
        $('.buldname').show();
        $('.aptdesc').hide();
    }

    if($('#ptype option:selected').val()=="Apartment" || $('#ptype option:selected').val()=="Commercial" || $('#ptype option:selected').val()=="Retail" || $('#ptype option:selected').val()=="Industrial") {
        $('.land_area').hide();
        $('.bunglow_building_area').hide();
        $('.bunglow_area').hide();
        $('.building_area').hide();
        $('.carpet_area').show();
        $('.built_up_saleable_area').show();
        $('.built_up_area').show();
        $('.saleable_area').show();
        $('.parking_div').show();
    } else if($('#ptype option:selected').val()=="Building") {
        $('.land_area').hide();
        $('.bunglow_building_area').show();
        $('.bunglow_area').hide();
        $('.building_area').show();
        $('.carpet_area').show();
        $('.built_up_saleable_area').show();
        $('.built_up_area').show();
        $('.saleable_area').show();
        $('.parking_div').show();
    } else if($('#ptype option:selected').val()=="Bunglow") {
        $('.land_area').hide();
        $('.bunglow_building_area').show();
        $('.bunglow_area').show();
        $('.building_area').hide();
        $('.carpet_area').show();
        $('.built_up_saleable_area').show();
        $('.built_up_area').show();
        $('.saleable_area').show();
        $('.parking_div').show();
    } else if($('#ptype option:selected').val()=="Land-Agriculture" || $('#ptype option:selected').val()=="Land-NonAgriculture") {
        $('.land_area').show();
        $('.bunglow_building_area').hide();
        $('.bunglow_area').hide();
        $('.building_area').hide();
        $('.carpet_area').hide();
        $('.built_up_saleable_area').hide();
        $('.built_up_area').hide();
        $('.saleable_area').hide();
        $('.parking_div').hide();
        $('.p_status').hide();
        $('#property_status').val('');
    }
    
    if($('#ptype option:selected').val()=="Select") {
        $('.propaddr').hide();
        $('.propdesc').hide();
    } else {
        $('.propaddr').show();
        $('.propdesc').show();
    }

    $('#ddlagreementarea').change(function(){
        //alert(this.value);
        $('#a_unit_1').text(this.value);
        $('#a_unit_2').text(this.value);
        $('#a_unit_3').text(this.value);
    });
});

var set_type = function(elem) {
    $('.p_status').show();

    if(elem.value=="Land-Agriculture" || elem.value=="Land-NonAgriculture" || elem.value=="Bunglow") {
        $('.aptname').hide();
    } else {
        $('.aptname').show();
        $('.aptdesc').show();
    }

    if(elem.value=="Building") {
        $('.buldname').show();
        $('.aptdesc').hide();
    }

    if(elem.value=="Apartment" || elem.value=="Commercial" || elem.value=="Retail" || elem.value=="Industrial") {
        $('.land_area').hide();
        $('.bunglow_building_area').hide();
        $('.bunglow_area').hide();
        $('.building_area').hide();
        $('.carpet_area').show();
        $('.built_up_saleable_area').show();
        $('.built_up_area').show();
        $('.saleable_area').show();
        $('.parking_div').show();
    } else if(elem.value=="Building") {
        $('.land_area').hide();
        $('.bunglow_building_area').show();
        $('.bunglow_area').hide();
        $('.building_area').show();
        $('.carpet_area').show();
        $('.built_up_saleable_area').show();
        $('.built_up_area').show();
        $('.saleable_area').show();
        $('.parking_div').show();
    } else if(elem.value=="Bunglow") {
        $('.land_area').hide();
        $('.bunglow_building_area').show();
        $('.bunglow_area').show();
        $('.building_area').hide();
        $('.carpet_area').show();
        $('.built_up_saleable_area').show();
        $('.built_up_area').show();
        $('.saleable_area').show();
        $('.parking_div').show();
    } else if(elem.value=="Land-Agriculture" || elem.value=="Land-NonAgriculture") {
        $('.land_area').show();
        $('.bunglow_building_area').hide();
        $('.bunglow_area').hide();
        $('.building_area').hide();
        $('.carpet_area').hide();
        $('.built_up_saleable_area').hide();
        $('.built_up_area').hide();
        $('.saleable_area').hide();
        $('.parking_div').hide();
        $('.p_status').hide();
        $('#property_status').val('');
    }
    
    if(elem.value=="Select") {
        $('.propaddr').hide();
        $('.propdesc').hide();
    } else {
        $('.propaddr').show();
        $('.propdesc').show();
    }

    if($('#p_id').val()==''){
        var counter = 0;
        $.ajax({
            url: BASE_URL + "index.php/Purchase/loadpurchasedocuments/" + elem.value,
            data: $("#form_purchase").serialize(),
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

    addMultiInputNamingRules('#form_real_estate_property', 'input[name="owner_contact_name[]"]', { required: function(element) {
                                                                                                if($("#submitVal").val()=="0"){
                                                                                                    return true;
                                                                                                } else {
                                                                                                    return false;
                                                                                                }
                                                                                            }
                                                                                }, "");
    addMultiInputNamingRules('#form_purchase', 'input[name="ownership[]"]', { required: function(element) {
                                                                                            if($("#submitVal").val()=="0"){
                                                                                                return true;
                                                                                            } else {
                                                                                                return false;
                                                                                            }
                                                                                        }
                                                                                }, "");
    addMultiInputNamingRules('#form_purchase', 'input[name="sch_type[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_purchase', 'input[name="sch_event[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_purchase', 'input[name="sch_date[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_purchase', 'input[name="sch_basiccost[]"]', { required: true }, "");
    addMultiInputNamingRules('#form_purchase', '.doc_name', { required:function(element) {
                                                                        if($("#submitVal").val()=="0"){
                                                                            return true;
                                                                        } else {
                                                                            return false;
                                                                        }
                                                                    }
                                                                }, "Document");
}

function saveTempBulkUpload() {
    var input = ($("#schedule_upload"))[0];
    var upload_txn_type = 'purchase';
    file = input.files[0];
    if(file != undefined){
        formData= new FormData();            
        formData.append("data_file", file);
        formData.append("upload_txn_type",upload_txn_type);

        $.ajax({
            url: BASE_URL+"index.php/Purchase/saveTempBulkUpload",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(data){
                if(data.status==0){
                    alert(data.errormsg);
                } else {
                    var counter=data.rowcounter;
                    var tst=data.rowcounter;
                    window.cntrinst=tst-1;
                    $("#schedule_id").val(tst-1);
                    $("#import_schedule").html(data.data);

                    $('.select3').select2();

                    $('.datepicker').datepicker({changeMonth: true,changeYear: true});

                    // $("#myModal").html(data.data);
                    // $('.select').selectpicker();
                    // $('.datepicker').datepicker({changeMonth: true,changeYear: true});
                    // $('#schedule_upload').bootstrapFileInput();
                    //$('.repeat-schedule').trigger('click');

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
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    } else {
        $("#file_photo_error").html('Input something!');
    }
}