var current_fs, next_fs, previous_fs;
var left, opacity, scale;
var animating;

$(".next").click(function(){
    var bool = 0;
    var bool1 = 0;
     var notice_period = parseInt($.trim($('#notice_period').val()));
    var lease_period = parseInt($.trim($('#locking_period').val()));
    var free_rent_period = parseInt($.trim($('#free_rent_period').val()));

    $('#rent_error').empty();
    
    if($('#notice_period').val()!="" && $('#locking_period').val()!="")
    {   
        if(notice_period>lease_period)
        {   
            $('#rent_error').append(" <label class='error temperror'>Notice Period Should Be less Then Lease Period</label>").show();
             bool = 1;
        }
    }

    if($('#free_rent_period').val() && $('#locking_period').val()!="")
    {  
        if(free_rent_period>lease_period)
        {
            $('#rent_error').append(" <label class='error temperror'>Rent Free Period Should Be less Then Lease Period</label>").show();
            bool1 = 1;
        }
    }
    if(bool==0 && bool1==0){
        animating = true;
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        
        next_fs.show();
        current_fs.animate({opacity: 0}, {
            step: function(now, mx) {
                scale = 1 - (1 - now) * 0.2;
                left = (now * 50)+"%";
                opacity = 1 - now;
                current_fs.css({
                    'transform': 'scale('+scale+')',
                    'position': 'absolute'
                });
                next_fs.css({'left': left, 'opacity': opacity});
            }, 
            duration: 800, 
            complete: function(){
                current_fs.hide();
                animating = false;
            },
            easing: 'easeInOutBack'
        }); 
    }
    
    
	
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	previous_fs.show();
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			scale = 0.8 + (1 - now) * 0.2;
			left = ((1-now) * 50)+"%";
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		},
		easing: 'easeInOutBack'
	});
});

$(".submit").click(function(){
	return false;
});

var set_pdc = function() {
	$('#add_pdc').toggle('show');
}

var set_gst = function() {
	// if($('#gst').is(":checked")){
	// 	$('#gst_rate').attr('readonly', false);
	// } else {
	// 	$('#gst_rate').val('');
	// 	$('#gst_rate').attr('readonly', true);
	// }
	if($('#gst').is(":checked")){
		$('#gst_rate').attr('disabled', false);
	} else {
		$('#gst_rate').val('');
		$('#gst_rate').attr('disabled', true);
	}

	set_tax();
}

var set_tds = function() {
	if($('#tds').is(":checked")){
		$('#tds_rate').attr('disabled', false);
        // alert("g");
        $('#tds_rate').focus();
	} else {
		$('#tds_rate').val('');
		$('#tds_rate').attr('disabled', true);
	}
}

var set_tax = function() {
	var slides = document.getElementsByClassName("select");
    for(var i = 0; i < slides.length; i++) {
        var elem = slides.item(i);
        var elem_name = elem.name;

        if(elem_name.indexOf('sch_tax')!==-1){
        	if($('#gst').is(":checked")){
        		elem.value=$('#gst_rate').val();
        	} else {
        		elem.value='';
        	}
        }
    }
}

var set_gst2 = function(elem) {
	var id = elem.id;
	var index = id.substr(id.lastIndexOf('_')+1);

	if($('#gst_'+index).is(":checked")){
		$('#gst_val_'+index).val('1');
		$('#gst_rate_'+index).attr('disabled', false);
	} else {
		$('#gst_val_'+index).val('0');
		$('#gst_rate_'+index).val('');
		$('#gst_rate_'+index).attr('disabled', true);
	}

	// set_tax();
}

var set_tds2 = function(elem) {
	var id = elem.id;
	var index = id.substr(id.lastIndexOf('_')+1);

	if($('#tds_'+index).is(":checked")){
		$('#tds_val_'+index).val('1');
		$('#tds_rate_'+index).attr('readonly', false);
        $('#tds_rate_'+index).focus();
	} else {
		$('#tds_val_'+index).val('0');
		$('#tds_rate_'+index).val('');
		$('#tds_rate_'+index).attr('readonly', true);
	}
}

var set_gst_rate_val = function(elem) {
	var id = elem.id;
	var index = id.substr(id.lastIndexOf('_')+1);
	$('#gst_rate_val_'+index).val(elem.value);
}

jQuery(function(){
    var counter = $('select.tenant').length+1;

    $('#repeat-tenant').click(function(event){
        event.preventDefault();

        var newRow = jQuery('<div id="repeat_tenant_'+counter+'" class="row clearfix">'+
                                '<div class="col-md-5">'+
                                    '<div class="form-group form-group-default form-group-default-select2">'+
                                        '<label class="">Tenant</label>'+
                                        '<select id="tenant_name_'+counter+'" name="tenant[]" class="form-control tenant full-width select2" data-error="#err_tenant_name_'+counter+'" data-placeholder="Select" data-init-plugin="select2">'+
                                            '<option value="">Select</option>'+contact_details+'</select>'+
                                        '<div id="err_tenant_name_'+counter+'"></div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="delete delete_row" id="repeat_tenant_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>'+
                            '</div>');
        
        $('#repeattenant').append(newRow);
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
    var counter = $('input.pdc').length+1;

    $('#repeat-pdc').click(function(event){
        event.preventDefault();

        var newRow = jQuery('<tr id="repeat_pdc_'+counter+'" style="background-color: #ffffff;">'+
                                '<td>'+counter+'</td>'+
                                '<td><div class="form-group form-group-default pdc"><input type="text" class="form-control datepicker pdc" name="pdc_date[]" ></div></td>'+
                                '<td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_particular[]"></div></td>'+
                                '<td><div class="form-group form-group-default"><input type="text" class="form-control format_number" name="pdc_amt[]"></div></td>'+
                                '<td><div class="form-group form-group-default"><input type="text" class="form-control format_number" name="pdc_gst[]"></div></td>'+
                                '<td><div class="form-group form-group-default"><input type="text" class="form-control format_number" name="pdc_tds[]"></div></td>'+
                                '<td><div class="form-group form-group-default"><input type="text" class="form-control format_number" name="pdc_net_amt[]"></div></td>'+
                                '<td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_chq_no[]"></div></td>'+
                                '<td><div class="form-group form-group-default"><input type="text" class="form-control " name="pdc_bank[]"></div></td>'+
                                '<td><div class="delete delete_row" id="repeat_pdc_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div></td>'+
                            '</tr>');
        
        $('#repeatpdc').append(newRow);
        $('.datepicker', newRow).datepicker({changeMonth: true,changeYear: true});
	    $('.format_number').keyup(function(){
	        format_number(this);
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
    var counter = $('input.escalation').length+1;

    $('#repeat-escalation').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<div id="repeat_escalation_'+counter+'" class="row clearfix">'+
                                '<div class="col-md-5">'+
                                    '<div class="form-group form-group-default">'+
                                        '<label class="">Escalate Date</label>'+
                                        '<input type="text" class="form-control escalation datepicker" name="esc_date[]" id="esc_date_'+counter+'" placeholder="Enter Here" value="" readonly />'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-md-5">'+
                                    '<div class="form-group form-group-default ">'+
                                        '<label>Escalation % </label>'+
                                        '<input type="text" class="form-control format_number" name="escalation[]" id="escalation_'+counter+'" placeholder="Enter Here" value=""/>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="delete delete_row" id="repeat_escalation_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>'+
                            '</div>');
        
        $('#repeatescalation').append(newRow);
        $('.datepicker', newRow).datepicker({changeMonth: true,changeYear: true});
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
    var counter = $('input.amount').length+1;

    $('#repeat-transaction').click(function(event){
        event.preventDefault();
        var newRow = jQuery('<div id="transaction_'+counter+'">'+
                                '<div class="row clearfix">'+
                                    '<div class="col-md-3">'+
                                        '<div class="form-group form-group-default ">'+
                                            '<label>Amount Per Month In &#x20B9;</label>'+
                                            '<input type="text" class="form-control format_number amount" name="other_amount[]" id="amount_'+counter+'" placeholder="Enter Here" value="" />'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-md-3">'+
                                        '<div class="form-group form-group-default form-group-default-select2 required">'+
                                            '<label class="">Invoice Schedule</label>'+
                                            '<select class="full-width select2" name="other_schedule[]" id="schedule_'+counter+'" data-error="#err_schedule_'+counter+'" data-placeholder="Select" data-init-plugin="select2">'+
                                                '<option value="">Select</option>'+
                                                '<option value="Monthly">Monthly</option>'+
                                                '<option value="Quarterly">Quarterly</option>'+
                                                '<option value="Yearly">Yearly</option>'+
                                            '</select>'+
                                            '<div id="err_schedule_'+counter+'"></div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-md-3">'+
                                        '<div class="form-group form-group-default form-group-default-select2 required">'+
                                            '<label class="">Invoice In The Name Of</label>'+
                                            '<select class="full-width select2" name="other_invoice_issuer[]" id="invoice_issuer_'+counter+'" data-error="#err_invoice_issuer_'+counter+'" data-placeholder="Select" data-init-plugin="select2">'+invoice_issuer+
                                            '</select>'+
                                            '<div id="err_invoice_issuer_'+counter+'"></div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-md-3">'+
                                        '<div class="form-group form-group-default form-group-default-select2 required">'+
                                            '<label>Due Day</label>'+
                                            '<select class="full-width select2" name="other_rent_due_day[]" id="rent_due_day_'+counter+'" data-error="#err_rent_due_day_'+counter+'" data-placeholder="Select" data-init-plugin="select2">'+due_day+'</select>'+
                                            '<div id="err_rent_due_day_'+counter+'"></div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-md-3" style="display: none;">'+
                                        '<div class="form-group form-group-default required">'+
                                            '<label class="">Category</label>'+
                                            '<input type="text" class="form-control" name="other_category[]" id="category_'+counter+'" placeholder="Enter Here" value="Other" readonly />'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="row clearfix recurring">'+
                                    '<div class="col-md-3">'+
                                        '<div class="form-group form-group-default ">'+
                                            '<label>First Invoice Date</label>'+
                                            '<input type="text" class="form-control datepicker" name="other_invoice_date[]" id="invoice_date_'+counter+'" placeholder="Enter Here" value=""/>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-md-5" style="padding-left: 7px;">'+
                                        '<div class="form-group form-group-default form-group-default-select2 input-group gst data-error="#err_gst_rate_'+counter+'">'+
                                            '<div class="form-input-group">'+
                                                '<label class="">GST Rate</label>'+
                                                '<input type="hidden" class="form-control format_number " name="other_gst_rate[]" id="gst_rate_val_'+counter+'" placeholder="Enter Here" value="" />'+
                                                '<select class="full-width select2" id="gst_rate_'+counter+'" onChange="set_gst_rate_val(this);" data-placeholder="Select" data-init-plugin="select2" disabled >'+tax_list_details+'</select>'+
                                            '<div id="err_gst_rate_'+counter+'"></div>'+
										   '</div>'+
                                            '<div class="input-group-addon bg-transparent h-c-50">'+
                                            	'<input type="hidden" name="other_gst[]" id="gst_val_'+counter+'" value="0" />'+
                                                '<input type="checkbox" class="toggle" id="gst_'+counter+'" value="yes" onchange="set_gst2(this);" class="toggle"  />'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-md-3">'+
                                        '<div class="form-group form-group-default input-group">'+
                                            '<div class="form-input-group">'+
                                                '<label class="">TDS Rate In %</label>'+
                                                '<input type="text" class="form-control format_number" name="other_tds_rate[]" id="tds_rate_'+counter+'" placeholder="Enter Here" value="" readonly />'+
                                            '</div>'+
                                            '<div class="input-group-addon bg-transparent h-c-50">'+
                                            	'<input type="hidden" name="other_tds[]" id="tds_val_'+counter+'" value="0" />'+
                                                '<input type="checkbox" id="tds_'+counter+'" value="yes" onchange="set_tds2(this);" class="toggle"  />'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="col-md-1">'+
                                    	'<div class="delete delete_row" id="transaction_'+counter+'_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>');
        
        $('#transaction').append(newRow);
        $('.datepicker', newRow).datepicker({changeMonth: true,changeYear: true});
        $('.select2', newRow).select2();

        // $('.input-group-addon input[type=checkbox]', newRow).switchery();

        // $('.switchery', newRow).switchery();
		$('.format_number').keyup(function(){
			format_number(this);
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

function calculatedate(){
	var lease="";
	if(document.getElementById('possession_date').value!=null && document.getElementById('possession_date').value!="" && 
		document.getElementById('termination_date').value!=null && document.getElementById('termination_date').value!="") {
			var stdt= $("#possession_date").val();
			var endt=$('#termination_date').val();
			var from = moment(stdt, 'DD/MM/YYYY'); 
			var to = moment(endt, 'DD/MM/YYYY'); 
			var duration = to.diff(from, 'months');
			lease=duration;
	}

	document.getElementById('locking_period').value=lease;
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
	removeMultiInputNamingRules('#form_rent', 'input[alt="sch_event[]"]');
	removeMultiInputNamingRules('#form_rent', 'input[alt="sch_date[]"]');
	removeMultiInputNamingRules('#form_rent', 'input[alt="sch_basiccost[]"]');

	var formdata = {};
	var formdata={
		// sch_type:$('input[name="sch_type[]"]').map(function(){return $(this).val();}).get(),
		sch_type:$('input[name="sch_event[]"]').map(function(){return $(this).val();}).get(),
		sch_event:$('input[name="sch_event[]"]').map(function(){return $(this).val();}).get(),
		sch_date:$('input[name="sch_date[]"]').map(function(){return $(this).val();}).get(),
		sch_basiccost:$('input[name="sch_basiccost[]"]').map(function(){return $(this).val();}).get()
		//sch_event:$('input[name="sch_event[]"]').map(function(){return $(this).val();}).get()
	}

	// var sch_type=$('input[name="sch_type[]"]').map(function(){return $(this).val();}).get();
	var sch_type=$('input[name="sch_event[]"]').map(function(){return $(this).val();}).get();
	//console.log(sch_type.length);
	var j=1;
	for(var i=0;i<sch_type.length;++i){
		//console.log("step1");
		formdata['sch_tax_'+j] = $('select[name="sch_tax_'+j+'[]"]').map(function(){return $(this).val();}).get();
		j++;
	}
	// console.log(formdata);
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

	//var bl=parseInt(document.getElementById('sch_bal').value);
	/*if(bl!=0) {
	alert("Balance should be 0. Kindly check the same.")
	} else {*/

		// document.getElementById('myModal').style.display = "none";

        // $('#myModal').modal('hide');
        $("#actual_schedule_div").removeClass('show').addClass('hide');

	//$("#actual_schedule_div").removeClass('show').addClass('hide');
	//}
}

function closetemp() {
	document.getElementById('myModal').style.display = "none";
}

function instchange(){
	flag=false;
}

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
	// 	var newRow = jQuery('<tr> <td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" id="txttype" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtevent" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtdtp" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtprojdate" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtrevdate" class="form-control" style="border:none;"/></td> <td><input type="text" id="txtprojamount" class="form-control" style="border:none;"/></td> <td><input type="text" id="txttds" class="form-control" style="border:none;"/></td> </tr>');
	// 	$('.addschedule').append(newRow);
	// }
	// else
	// {
	// 	var newRow = jQuery('<tr> <td style="color:#000; vertical-align: middle;" align="middle">'+counter+'</td> <td><input type="text" id="txttype" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtevent" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtdtp" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtprojdate" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtrevdate" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txtprojamount" class="form-control" style="border:none;background:none;"/></td> <td><input type="text" id="txttds" class="form-control" style="border:none;background:none;"/></td> </tr>');
	// }
	rows=rows+ '<tr id="repeat_schedule_'+counter+'"> <td style="color:#000;background:#F9F9F9; vertical-align: middle;" align="middle">'+ counter +'</td> <td style="display: none;"><input type="text"  name="sch_type[]" class="form-control" value="" style="border:none;"/></td><td><input type="text"  name="sch_event[]" class="form-control" value="" style="border:none;"/></td> <td><input type="text"  name="sch_date[]" value=""  class="form-control datepicker" style="border:none;"/></td> <td><input type="text" name="sch_basiccost[]" value="" class="form-control format_number" style="border:none; text-align:right;"/></td><td><select class="select" multiple name="sch_tax_'+counter+'[]">'+tax_list_details+'</select></td></tr>';
	// counter++;
	$('.addschedule').append(rows);	$("#rowdisplaycount").val(counter);
	$('.datepicker', rows).datepicker({changeMonth: true,changeYear: true});
	$('.select', rows).select2();
	$('.format_number').keyup(function(){
		format_number(this);
	});
	$("form :input").change(function() {
		$(".save-form").prop("disabled",false);
	});
}

function scheduleReverse(){
	var counter = $("#rowdisplaycount").val();
	//   	var ctr=window.cntrinst;
	// var counter = tst;
	// if(ctr == 0){
	// var tst=$("#schedule_id").val();						
	// }
	// else{
	// 	//alert(ctr);
	// 	tst=parseInt(ctr);
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

$(document).ready(function(){
	
		addMultiInputNamingRules('#form_rent', 'select[name="tenant[]"]', { required: function(element) {
                                                                                        if($("#submitVal").val()=="0"){
                                                                                            return true;
                                                                                        } else {
                                                                                            return false;
                                                                                        }
                                                                                    } }, "");
	
	
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
	addMultiInputNamingRules('#form_rent', 'input[name="other_invoice_date[]"]', { required: function(element) {
                                                                                        if($("#submitVal").val()=="0"){
                                                                                            return true;
                                                                                        } else {
                                                                                            return false;
                                                                                        }
                                                                                    } }, "");

	// addMultiInputNamingRules('#form_rent', 'input[name="sch_type[]"]', { required: true }, "");
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
	addMultiInputNamingRules('#form_rent', '.doc_name', { required:function(element) {
		if($("#submitVal").val()=="0"){
			return true;
		} else {
			return false;
		}
	}
	}, "Document");

	get_property_details();
});

function saveTempBulkUpload(){
	var input = ($("#schedule_upload"))[0];
	var upload_txn_type = 'rent';
	file = input.files[0];
	if(file != undefined){
		formData= new FormData();            
		formData.append("data_file", file);
		formData.append("upload_txn_type",upload_txn_type);

		$.ajax({
			url: BASE_URL+"index.php/rent/saveTempBulkUpload",
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
					$("#import_schedule").html(data.data);
					$('.select3').select2();
					$('.datepicker').datepicker({changeMonth: true,changeYear: true});
					// $('#schedule_upload').bootstrapFileInput();
					// $('.repeat-schedule').click(function(event){
					// 	event.preventDefault();
					// 	//alert(window.cntrinst);
					// 	scheduleRepeat();
					// });
					// $('.reverse-schedule').click(function(event){
					// 	event.preventDefault();
					// 	//alert(window.cntrinst);
					// 	scheduleReverse();
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
		//                alert('Input something!');
	}
}

var get_property_details = function() {
	var property = $("#property").val()==''?'0':$("#property").val();
    var r_id = $("#r_id").val()==''?'0':$("#r_id").val();

    // console.log(property);
    // console.log(r_id);

    var dataString = 'property_id=' + property + '&txn_id=' + r_id;

    $.ajax({
        type: "POST",
        url: BASE_URL+"index.php/rent/get_sub_property",
        data: dataString,
        cache: false,
        success: function(html){
            $("#sub_property").html(html);
        	if(html=='<option value="0">Select Sub Property</option>'){
        		$("#sub_property_div").hide();
        	} else {
        		$("#sub_property_div").show();
        	}
        } 
    });

    $.ajax({
        type: "POST",
        url: BASE_URL+"index.php/rent/get_property_owners",
        data: dataString,
        cache: false,
        success: function(html){
            $("#invoice_issuer").html(html);

            var counter = $('input.amount').length;
            for(var i=1; i<=counter; i++){
                $("#invoice_issuer_"+i).html(html);
                $("#invoice_issuer_"+i).select2();
            }
            
        } 
    });

    $.ajax({
        type: "POST",
        url: BASE_URL+"index.php/rent/get_property_utilities",
        data: dataString,
        cache: false,
        success: function(html){
            $("#rent_utilities").html(html);
            if(html==''){
            	$("#rent_utility_div").hide();
            } else {
            	$("#rent_utility_div").show();
            }
        } 
    });
}

var set_utilities = function(elem) {
	var elem_id = elem.id;
	var index = elem_id.substr(elem_id.indexOf('_')+1);

	if(elem_id.indexOf('landlord')!==-1){
		$('#tenant_'+index).attr('checked', false);
		$('#na_'+index).attr('checked', false);
	} else if(elem_id.indexOf('tenant')!==-1){
		$('#landlord_'+index).attr('checked', false);
		$('#na_'+index).attr('checked', false);
	} else if(elem_id.indexOf('na')!==-1){
		$('#landlord_'+index).attr('checked', false);
		$('#tenant_'+index).attr('checked', false);
	}
}