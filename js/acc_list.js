var get_details = function(elem) {
	var id = elem.id;
	var index = id.substr(id.lastIndexOf('_')+1);

	$('#status').html($('#status_'+index).val());

	$('#type').html($('#type_'+index).val());
	$('#particular').html($('#particular_'+index).val());
	$('#bal_amount').html($('#bal_amount_'+index).val());
	$('#net_amount').html($('#net_amount_'+index).val());
	$('#due_date').html($('#due_date_'+index).val());
	$('#type').attr('href', $('#link_'+index).val());
	$('#property_name').html($('#property_name_'+index).val());
	if($('#sub_property_name_'+index).val()!="")
	{	
		$('.subprop').show();
		$('#sub_property_name').html($('#sub_property_name_'+index).val());	
	}
	else
	{
		$('.subprop').hide();
	}
	
	$('#owner_name').html($('#owner_name_'+index).val());
	$('#payer_name').html($('#payer_name_'+index).val());
	if($('#status_'+index).val()=='paid')
	{
		$('#status').css({
			"background-color":"#5cb85c!important;"
		})
	}
	else{
		
		$('#status').css({
			"background-color":"#c64643!important;"
		})
	}	
	console.log($('#owner_name_'+index).val());
	console.log($('#payer_name_'+index).val());
}