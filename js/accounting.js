function setTotalAmount(elem, type){
	var tot_sch = $('.sch_cnt').length;
	var id = elem.id;
	var i = id.substr(id.lastIndexOf('_')+1);
	var type = id.substr(1, id.lastIndexOf('_'));

	// console.log(tot_sch);

	// for(var i=1;i<=tot_sch;i++){
		// console.log($("#basic_amount_"+i).val());
		// console.log($("#gst_rate_"+i).val());

		var amount=0;
		var gst_rate=0;

		if(type.indexOf('basic')!==-1){
			amount=parseInt(get_number(this.value,2));
		} else {
			amount=parseInt(get_number($("#basic_amount_"+i).val(),2));
		}

		if(type.indexOf('gst')!==-1){
			gst_rate=parseInt(get_number(this.value,2));
		} else {
			gst_rate=parseInt(get_number($("#gst_rate_"+i).val(),2));
		}

		var paid_amount=parseInt(get_number($("#paid_till_date_"+i).val(),2));

		// console.log(amount);
		// console.log(gst_rate);

		if(amount=='') amount = 0;
		if(gst_rate=='') gst_rate = 0;

		// console.log(amount);

		var tax_amount = (amount*gst_rate)/100;
		var total_amount = amount + tax_amount;
		var bal_amount = total_amount - paid_amount;

		// console.log(tax_amount);
		// console.log(total_amount);

		$("#tax_amount_"+i).val((tax_amount==0)?0:format_money(tax_amount,2));
		$("#net_amount_"+i).val((total_amount==0)?0:format_money(total_amount,2));
		$("#bal_amount_"+i).val((bal_amount==0)?0:format_money(bal_amount,2));
		$("#tax_amount_text_"+i).html((tax_amount==0)?0:format_money(tax_amount,2));
		$("#net_amount_text_"+i).html((total_amount==0)?0:format_money(total_amount,2));
		$("#bal_amount_text_"+i).html((bal_amount==0)?0:format_money(bal_amount,2));
	// }

	getDifferneceAmt();
}

function getActualAmount(){
	var ids = $('.sch_cnt').length;
	var totalPayAmount=0;

	for(var i=1;i<=ids;i++){
		var actual_amount=get_number($("#actual_amount_"+i).val(),2);
		if(actual_amount != ''){
			var total_actual_amount=actual_amount;
			var selectedTaxes=$('select[name="extra_taxes_'+i+'[]"]').map(function(){return $(this).val();}).get();
			for(var j=0;j<selectedTaxes.length;j++){					
				var  percenttax=selectedTaxes[j];
				var percent1=percenttax.split("_");
				var exact_percent=0;
				exact_percent=percent1[1];
				var percentAmount=0;
				percentAmount=parseInt(exact_percent)*parseInt(actual_amount)/parseInt(100);
				total_actual_amount=parseInt(total_actual_amount) - parseInt(percentAmount);
			}
			totalPayAmount=parseInt(totalPayAmount)+parseInt(total_actual_amount);
			total_actual_amount=0;
		}
	}
	$("#actual_amount_to_pay").html(format_money(totalPayAmount,2));
	setTax();
}

function getDifferneceAmt(){
	var tot_budget=0, tot_paid=0, tot_outstanding=0, tot_actual_amount=0;
	var tot_amount=0, tot_gst=0, tot_tds=0,tds_till_date=0;

	var tot_sch = $('.sch_cnt').length;

	for(var i=1;i<=tot_sch;i++){
		var amount=parseInt(get_number($("#basic_amount_"+i).val(),2));
		var gst=parseInt(get_number($("#tax_amount_"+i).val(),2));

		var netamt_ids='net_amount_'+i;
		var netAmount=parseInt(get_number($("#"+netamt_ids).val(),2));

		var paid_ids='paid_till_date_actual_'+i;
		var paid_amount=parseInt(get_number($("#"+paid_ids).val(),2));

		var tds_id_till_id='tds_amount_till_date_'+i;
		var tds_amount_till_date=parseInt(get_number($("#"+tds_id_till_id).val(),2));	
		tds_till_date = tds_till_date+tds_amount_till_date;
		tot_amount=tot_amount+amount;
		tot_gst=tot_gst+gst;

		tot_budget=tot_budget+netAmount;
		tot_paid=tot_paid+paid_amount;
		console.log('actul_tot_outstanding'+tot_outstanding);
		tot_outstanding=tot_outstanding+netAmount-paid_amount;

/*		if($("#actual_amount_"+i).val()!="" && $("#actual_amount_"+i).val()!=null){
*/			var actual_amount=parseInt(($("#actual_amount_"+i).val()=="")?0:get_number($("#actual_amount_"+i).val(),2));
			
			if($("#tds_amount_"+i).length>0){
				var tds_amount=parseInt(($("#tds_amount_"+i).val()=="")?0:get_number($("#tds_amount_"+i).val(),2));
			} else {
				var tds_amount=0;
			}
			
			if(paid_amount!=netAmount)
			{
				var tot_paid_amount=actual_amount+paid_amount+tds_amount;

			}
			else
			{
				var tot_paid_amount=actual_amount+paid_amount;
			}

/*			var tot_paid_amount=actual_amount+paid_amount+tds_amount;
*/			var difference=netAmount-tot_paid_amount;

			// tot_paid=tot_paid+actual_amount;
			tot_outstanding=tot_outstanding-actual_amount-tds_amount;
			console.log('tot_outstanding'+tot_outstanding);
			tot_actual_amount=tot_actual_amount+actual_amount;
			tot_tds=tot_tds+tds_amount;

			$("#paid_till_date_"+i).val(tot_paid_amount);
			// $("#paid_till_date_link_"+i).html(tot_paid_amount);
			$("#balance_"+i).val(difference);
			$("#difference_"+i).html((difference==0)?0:format_money(difference,2));

			if(difference<0){
				$("#actual_amount_"+i).focus();
				alert("Outstanding cannot be negative.");
				$("#actual_amount_"+i).val(0);
			}
		/*} else {
			$("#paid_till_date_"+i).val(paid_amount);
			// $("#paid_till_date_link_"+i).html(paid_amount);
			$("#balance_"+i).val(netAmount-paid_amount);
			$("#difference_"+i).html(((netAmount-paid_amount)==0)?0:format_money(netAmount-paid_amount,2));
		}*/
	}

	if($('#others_net_amount').length>0){
		tot_budget=tot_budget+parseInt(get_number($('#others_net_amount').html(),2));
	}
	if($('#others_paid_amount').length>0){
		tot_paid=tot_paid+parseInt(get_number($('#others_paid_amount').html(),2));
	}
	if($('#others_balance').length>0){
		tot_outstanding=tot_outstanding+parseInt(get_number($('#others_balance').html(),2));
	}

	$("#tot_amount").html((tot_amount==0)?0:format_money(tot_amount,2));
	$("#tot_tax").html((tot_gst==0)?0:format_money(tot_gst,2));
	$("#tot_tds").html((tot_tds==0)?0:format_money(tot_tds,2));
	$("#tot_tds_paid").html((tot_tds_paid==0)?0:format_money(tds_till_date,2));
	$("#tot_budget").html((tot_budget==0)?0:format_money(tot_budget,2));
	$("#tot_paid").html((tot_paid==0)?0:format_money(tot_paid,2));
	$("#tot_outstanding").html((tot_outstanding==0)?0:format_money(tot_outstanding,2));

	if(tot_actual_amount==0){
		$("#tot_actual_amount").html(0);
		$("#tot_received").html(0);
	} else {
		$("#tot_actual_amount").html((tot_actual_amount==0)?0:format_money(tot_actual_amount,2));
		$("#tot_received").html((tot_actual_amount==0)?0:format_money(tot_actual_amount,2));
	}
	
	setTax();
	
	if($("#status").val()=='loan'){
		getTotOutstanding();
	}
}

function setTax(){
	// $.ajax({
	// 	url: BASE_URL+"index.php/accounting/getTaxDetails",
	// 	type:"post",
	// 	dataType:"JSON",
 //       	async: false,
	// 	data:$("#accounting_details").serialize(),
	// 	success:function(data){
	// 		// console.log('Hiii');

	// 		$("#schedule_tax_detail").html(data.htmldata);
	//         $("form :input").change(function() {
 //                $(".save-form").prop("disabled",false);
 //            });
	// 	},
	// 	error: function(xhr, status, error) {
	// 		  var err = eval("(" + xhr.responseText + ")");
	// 		  alert(err.Message);
	// 	}

	// });
}

function getDifferneceTaxAmt(){
	var tot_sch=parseInt($('.tax_num').length);

	for(var i=1;i<=tot_sch;i++){
		var netamt_ids='tax_amount_'+i;
		var netAmount=parseInt(get_number($("#"+netamt_ids).val(),2));

		var paid_ids='tax_paid_till_date_actual_'+i;
		var paid_amount=parseInt(get_number($("#"+paid_ids).val(),2));

		// tot_budget=tot_budget+netAmount;
		// tot_paid=tot_paid+paid_amount;
		// tot_outstanding=tot_outstanding+netAmount-paid_amount;

		if($("#tax_actual_amount_"+i).val()!="" && $("#tax_actual_amount_"+i).val()!=null){
			var actual_amount=parseInt(($("#tax_actual_amount_"+i).val()=="")?0:get_number($("#tax_actual_amount_"+i).val(),2));

			var tot_paid_amount=actual_amount+paid_amount;
			var difference=netAmount-tot_paid_amount;

			tot_paid=tot_paid+actual_amount;
			tot_outstanding=tot_outstanding-actual_amount;

			$("#tax_paid_till_date_"+i).val(tot_paid_amount);
			// $("#tax_paid_till_date_link_"+i).html(tot_paid_amount);
			$("#tax_balance_"+i).val(difference);
			$("#tax_difference_"+i).html(format_money(difference,2));

			if(difference<0){
				// alert("Outstanding cannot be negative.");
				$("#tax_actual_amount_"+i).focus();
			}
		} else {
			$("#tax_paid_till_date_"+i).val(paid_amount);
			// $("#tax_paid_till_date_link_"+i).html(paid_amount);
			$("#tax_balance_"+i).val(netAmount-paid_amount);
			$("#tax_difference_"+i).html(format_money(netAmount-paid_amount,2));
		}
	}

	// $("#tot_budget").html(tot_budget);
	// $("#tot_paid").html(tot_paid);
	// $("#tot_outstanding").html(tot_outstanding);
}

function setIntRate(elem){
	var elem_id=elem.attr("id");
	var index=elem_id.substr(elem_id.lastIndexOf('_')+1);
	var int_rate_elem_id="#int_rate_"+index;

	if(elem.val()=="Fixed") {
		$(int_rate_elem_id).prop('disabled', true);
	} else {
		$(int_rate_elem_id).prop('disabled', false);
	}

	if($(int_rate_elem_id).val()==null || $(int_rate_elem_id).val()==""){
		$(int_rate_elem_id).val(int_rate_elem_val);
	}

	getTotOutstanding();
}

function parseDate(str) {
	// console.log(str);
    var mdy = str.split('/');
    return new Date(mdy[2], mdy[1], mdy[0]);
}

function getTotOutstanding(){
	var payment_date=$("#payment_date").val();
	payment_date=parseDate(payment_date);
	last_paid_date=parseDate(last_paid_date_val);

	var interest=0, principal=0, no_of_days=0, int_rate=0, actual_amount=0;

	var tot_sch = $('.sch_cnt').length;

	for(var i=1;i<=tot_sch;i++) {
		if($("#actual_amount_"+i).val()!="" && $("#actual_amount_"+i).val()!=null) {
			actual_amount=parseInt(($("#actual_amount_"+i).val()=="")?0:get_number($("#actual_amount_"+i).val(),2));
			int_rate=parseInt(($("#int_rate_"+i).val()=="")?0:get_number($("#int_rate_"+i).val(),2));
			
			if(interest==0) {
				no_of_days=Math.round((payment_date-last_paid_date)/(1000*60*60*24));

				interest=Math.round(tot_outstanding*int_rate/100/360*no_of_days);
				principal=Math.round(actual_amount-interest);
				tot_outstanding=Math.round(tot_outstanding-principal);
				$("#interest_"+i).val(interest);
				$("#interest_text_"+i).html(format_money(interest,2));
				$("#principal_"+i).val(principal);
				$("#principal_text_"+i).html(format_money(principal,2));
				$("#tot_outstanding_"+i).val(tot_outstanding);
				$("#tot_outstanding_text_"+i).html(format_money(tot_outstanding,2));
			} else {
				principal=actual_amount;
				tot_outstanding=Math.round(tot_outstanding-principal);
				$("#interest_"+i).val(0);
				$("#interest_text_"+i).val(0);
				$("#principal_"+i).val(principal);
				$("#principal_text_"+i).html(format_money(principal,2));
				$("#tot_outstanding_"+i).val(tot_outstanding);
				$("#tot_outstanding_text_"+i).html(format_money(tot_outstanding,2));
			}
		}
	}
}

function getAllpaidDetails(event_type,event_name,event_date){
	var fk_txn_id=$("#fk_txn_id").val();
	var formdata={event_type:event_type,event_name:event_name,event_date:event_date,fk_txn_id:fk_txn_id};
	$.ajax({
		url: BASE_URL+"index.php/accounting/getPaidDetails",
		data:formdata,
		type:"post",
		dataType:"json",
       	async: false,
		success:function(data){
			// alert(data.htmldata);
			$("#paid_detail_view").html(data.htmldata);
			document.getElementById('message-box-info').style.display = "block";
		},
		error: function(xhr, status, error) {
			  var err = eval("(" + xhr.responseText + ")");
			  alert(err.Message);
		}
	})
}

function getAllTaxpaidDetails(tax_applied){
	var fk_txn_id=$("#fk_txn_id").val();
	var formdata={tax_applied:tax_applied,fk_txn_id:fk_txn_id};
	$.ajax({
		url: BASE_URL+"index.php/accounting/getTaxPaidDetails",
		data:formdata,
		type:"post",
		dataType:"json",
       	async: false,
		success:function(data){
			// alert(data.htmldata);
			$("#paid_detail_view").html(data.htmldata);
			document.getElementById('message-box-info').style.display = "block";
		},
		error: function(xhr, status, error) {
			  var err = eval("(" + xhr.responseText + ")");
			  alert(err.Message);
		}
	})
}

function getOtherSchedule(){
	var fk_txn_id=$("#fk_txn_id").val();
	var formdata={fk_txn_id:fk_txn_id};
	$.ajax({
		url: BASE_URL+"index.php/accounting/getOtherSchedule",
		data:formdata,
		type:"post",
		dataType:"json",
       	async: false,
		success:function(data){
			// alert(data.htmldata);
			$("#schedule_select_other_detail_view").html(data.htmldata);
			document.getElementById('message-box-info2').style.display = "block";
		},
		error: function(xhr, status, error) {
			  var err = eval("(" + xhr.responseText + ")");
			  alert(err.Message);
		}
	})
}

function closeTemp() {
    document.getElementById('message-box-info').style.display = "none";
    flag=false;
}

function saveOtherSch(){
	$.ajax({
		url: BASE_URL+"index.php/accounting/saveOtherSchDetails",
		type:"post",
		dataType:"JSON",
       	async: false,
		data:$("#accounting_details").serialize(),
		success:function(data){
			document.getElementById('message-box-info2').style.display = "none";
			flag=false;
			window.open(BASE_URL+"index.php/accounting/bankEntry/" + $('#fk_txn_id').val(),"_parent","true");
			
		},
		error: function(xhr, status, error) {
			  var err = eval("(" + xhr.responseText + ")");
			  alert(err.Message);
		}

	});

	document.getElementById('message-box-info2').style.display = "none";
	flag=false;
}

function closeTemp2() {
    document.getElementById('message-box-info2').style.display = "none";
    flag=false;
}

$( "#type" ).change(function() {
	var type=$("#type").val();
	$("#status").html('');

	if(type=="payment") {
		$('<option>', {value: '', text: 'Select'}).appendTo("#status");
		$('<option>', {value: 'purchase', text: 'Property Purchase'}).appendTo("#status");
		$('<option>', {value: 'loan', text: 'Loan EMI'}).appendTo("#status");
		$('<option>', {value: 'expense', text: 'Property Expense'}).appendTo("#status");
		$('<option>', {value: 'maintenance', text: 'Property Maintenance'}).appendTo("#status");
		$('<option>', {value: 'other', text: 'Other'}).appendTo("#status");
	} else if (type=="receipt") {
		$('<option>', {value: '', text: 'Select'}).appendTo("#status");
		$('<option>', {value: 'rent', text: 'Rent'}).appendTo("#status");
		$('<option>', {value: 'sale', text: 'Property Sale'}).appendTo("#status");
		$('<option>', {value: 'other', text: 'Other'}).appendTo("#status");
	}

	$("#property").val('0');
	$("#sub_property").val('0');
	$("#property").html('');
	$("#sub_property").html('');
	$("#payment_summary").html('');
	$("#schedule_tax_detail").html('');
	$("#tot_budget").html('0');
	$("#tot_paid").html('0');
	$("#tot_outstanding").html('0');
});

$("#payer_id").change(function() {
	getSchedule();
});

$( "#status" ).change(function() {
 //    var type=$("#type").val();
 //    var status=$("#status").val();

	// $("#sub_property").val('0');
 //    $("#loan_ref_name").html('');
 //    $("#property").html('');
	// $("#sub_property").html('');
	// $("#payment_summary").html('');
	// $("#schedule_tax_detail").html('');
	// $("#tot_budget").html('0');
	// $("#tot_paid").html('0');
	// $("#tot_outstanding").html('0');
 //    $("#sub_property_div").hide();

 //    if (status=="loan") {
 //        getLoanTxn();
 //    	$("#loan_ref_name_div").show();
 //    	$("#expense_summary_div").hide();
 //    	$("#expense_category_div").hide();
 //    	$("#other_schedule_div").hide();
 //    	$("#payment_summary_div").show();
 //    	$("#property_div").hide();
 //    	$("#other_expense").val('false');
 //    	$("#other_schedule").val('false');
	// 	$(".prop_other_name").hide();
 //    } else if (status=="expense") {
 //    	getExpenseCategory();
 //        getProperties();
 //    	$("#loan_ref_name_div").hide();
 //    	$("#expense_summary_div").show();
 //    	$("#expense_category_div").show();
 //    	$("#other_schedule_div").hide();
 //    	$("#payment_summary_div").hide();
 //    	$("#property_div").show();
 //    	$("#other_expense").val('true');
 //    	$("#other_schedule").val('false');
 //    	$("#accounting_details").attr("action", BASE_URL+"index.php/accounting/saveOtherExpenseBankEntry");
	// 	$(".prop_other_name").hide();
 //    } else if (status=="other") {
 //        getProperties();
 //    	$("#loan_ref_name_div").hide();
 //    	$("#expense_summary_div").hide();
 //    	$("#expense_category_div").hide();
 //    	$("#other_schedule_div").show();
 //    	$("#payment_summary_div").hide();
 //    	$("#property_div").show();
 //    	$("#other_expense").val('false');
 //    	$("#other_schedule").val('true');
 //    	$("#accounting_details").attr("action", BASE_URL+"index.php/accounting/saveOtherScheduleBankEntry");
	// 	$(".prop_other_name").hide();
 //    } else {
 //        getProperties();
 //    	$("#loan_ref_name_div").hide();
 //    	$("#expense_summary_div").hide();
 //    	$("#expense_category_div").hide();
 //    	$("#payment_summary_div").show();
 //    	$("#property_div").show();
 //    	$("#other_expense").val('false');
 //    	$("#other_schedule").val('false');
	// 	$(".prop_other_name").hide();
 //    }

 //    $("#property").val('0');
 //    $("#loan_ref_name").val('0');

 	getSchedule();
});

$( "#property" ).change(function() {
    if($('#type').val()=='receipt' || $('#type').val()=='payment'){
    	getSchedule();
    } else {
    	getSubProperties();
    }
});

$( "#sub_property" ).change(function() {
    getSchedule();
});

$( "#loan_ref_name" ).change(function() {
    getSchedule();
});

var setPayNow = function(elem){
	if(elem.checked==true){
		$('.pay_now').show();
	} else {
		$('.pay_now').hide();
	}
}

function getSchedule(){
	// var payer_id=$("#payer_id").val();
	// var status=$("#status").val();
	// var other_expense=$("#other_expense").val();
	// var other_schedule=$("#other_schedule").val();

	// if(status=="loan") {
 //    	var loan_txn_id=$("#loan_ref_name").val();
	// 	if (loan_txn_id!=null && loan_txn_id!="") {
 //   			window.open(BASE_URL+"index.php/accounting/bankEntry/l_" + loan_txn_id,"_parent","true");
 //   		}
	// } else if(other_expense=="true") {
 //   		//do nothing
	// } else if(other_schedule=="true") {
 //   		//do nothing
	// } else {
 //        var property=$("#property").val();
 //        var sub_property=$("#sub_property").val();
	// 	var dataString = 'status=' + status + '&property_id=' + property + '&sub_property_id=' + sub_property;

	// 	if(property!=0 && property!=null) {
 //        	$.ajax({
 //               	type: "POST",
 //               	url: BASE_URL+"index.php/accounting/getBankEntry",
 //               	data: dataString,
	// 		   	dataType:"json",
 //               	async: false,
 //               	cache: false,
 //               	success: function(data){
 //               		txn_id = data.txn_id;
 //               		sch_id = data.sch_id;

 //               		if (txn_id!=null && txn_id!="" & sch_id!=null & sch_id!="") {
 //               			window.open(BASE_URL+"index.php/accounting/bankEntry/" + txn_id,"_parent","true");
 //               		}
               		
 //               	}
 //            });
 //        }
	// }

	// console.log('getSchedule');
	// if($('#type').val()=='receipt' || $('#type').val()=='payment'){

	// console.log($('#other_schedule').val());
	
	if($('#other_schedule').val()!='true'){
		console.log($('#type').val());

		$.ajax({
	       	type: "POST",
	       	url: BASE_URL+"index.php/accounting/getBankEntryUrl",
	       	data: $('#accounting_details').serialize(),
		   	dataType:"html",
	       	async: false,
	       	cache: false,
	       	success: function(data){
	       		if(data!='' && data!=null){
	       			window.open(data,"_parent","true");
	       		}
	       	}
	    });
	}
}

function getLoanTxn(){
	var status=$("#status").val();
    
    $.ajax({
		type: "POST",
		url: BASE_URL+"index.php/accounting/get_loan_txn",
		data: loan_dataString,
		async: false,
		cache: false,
		success: function(html){
		   $("#loan_ref_name").html(html);
		} 
    });
}

function getExpenseCategory(){
    $.ajax({
		type: "POST",
		url: BASE_URL+"index.php/accounting/get_expense_category",
		data: expense_dataString,
		async: false,
		cache: false,
		success: function(html){
		   $("#expense_category").html(html);
		} 
    });
}

function getProperties(){
	var status=$("#status").val();
	var property_dataString = 'status=' + (status=''?0:status) + '&property_id=' + property_id;

	// console.log(property_dataString);

    $.ajax({
		type: "POST",
		url: BASE_URL+"index.php/accounting/get_property",
		data: property_dataString,
		async: false,
		cache: false,
		success: function(html){
	   		$("#property").html(html);
		} 
    });
}

function getSubProperties(){
	var status=$("#status").val();
	var property=$("#property").val();

    var sub_property_dataString = 'status=' + (status=''?0:status) + '&property_id=' + (property=''?0:property) + '&sub_property_id=' + sub_property_id;

    // console.log(property);
    // console.log(status);

	if(property=='0' || property==''){
		$("#sub_property").html('');
		$("#sub_property_div").show();
		$("#payment_summary").html('');
		$("#schedule_tax_detail").html('');
		$("#tot_budget").html('0');
		$("#tot_paid").html('0');
		$("#tot_outstanding").html('0');
	} else {
		// var status=$("#status").val();
        
        $.ajax({
           	type: "POST",
           	url: BASE_URL+"index.php/accounting/get_sub_property",
           	data: sub_property_dataString,
           	// async: false,
           	cache: false,
           	success: function(html){
               	$("#sub_property").html(html);

				// console.log(html);
				
				if(html==""){
					getSchedule();
					$("#sub_property_div").hide();
				} else {
					$("#sub_property_div").show();

					if($('#other_schedule').val()=='false' || $('#other_schedule').val()==''){
						$("#payment_summary").html('');
						$("#schedule_tax_detail").html('');
						$("#tot_budget").html('0');
						$("#tot_paid").html('0');
						$("#tot_outstanding").html('0');
					}
				}
           	}
        });
	}
}

function setSubProperty(){
	var status=$("#status").val();
	var property=$("#property").val();

    var sub_property_dataString = 'status=' + (status=''?0:status) + '&property_id=' + (property=''?0:property) + '&sub_property_id=' + sub_property_id;

    // console.log(property);
    // console.log(status);

	if(property=='0' || property==''){
		$("#sub_property").html('');
		$("#sub_property_div").hide();
		// $("#payment_summary").html('');
		// $("#schedule_tax_detail").html('');
		// $("#tot_budget").html('0');
		// $("#tot_paid").html('0');
		// $("#tot_outstanding").html('0');
	} else {
		// var status=$("#status").val();
        
        $.ajax({
           	type: "POST",
           	url: BASE_URL+"index.php/accounting/get_sub_property",
           	data: sub_property_dataString,
           	// async: false,
           	cache: false,
           	success: function(html){
               	$("#sub_property").html(html);

				// console.log(html);
				
				if(html==""){
					// getSchedule();
					$("#sub_property_div").hide();
				} else {
					$("#sub_property_div").show();

					// if($('#other_schedule').val()=='false' || $('#other_schedule').val()==''){
					// 	$("#payment_summary").html('');
					// 	$("#schedule_tax_detail").html('');
					// 	$("#tot_budget").html('0');
					// 	$("#tot_paid").html('0');
					// 	$("#tot_outstanding").html('0');
					// }
				}
           	}
        });
	}
}

// $( "#payment_mode" ).change(function() {
// 	checkMode();
// });

function checkMode(){
	if($("#payment_mode").val()=="Cheque"){
		$("#payment_id_details").show();
		$("#payment_id_type").html('Cheque No');
		$("#cheq_no").val("");
	} else if($("#payment_mode").val()=="NEFT"){
		$("#payment_id_details").show();
		$("#payment_id_type").html('Ref No');
		$("#cheq_no").val("");
	} else {
		$("#payment_id_details").hide();
	}
}

$( document ).ready(function() {
// 	  getLoanTxn();
//    getProperties();
//    // getSubProperties();
//    getDifferneceAmt();
//    // setTaxForView();
//    // checkMode();

//    if($('#other_schedule').val()=='true'){
//    	setSubProperty();
//    }

    getDifferneceAmt();
});