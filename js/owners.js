var approveflag=false;
			function approvalFlag() {
				if (document.getElementById('approvalform')!=null) {
					approveflag=true;
					if(approveflag==true) {
						document.getElementById('approvalform').style.display = "none";
						document.getElementById('submitform').style.display = "block";
					} else {
						document.getElementById('approvalform').style.display = "block";
						document.getElementById('submitform').style.display = "none";
					}
				}
			}
			function loadFlag() {
				if (document.getElementById('approvalform')!=null) {
					document.getElementById('approvalform').style.display = "block";
					document.getElementById('submitform').style.display = "none";
				}
			}
		
/**
*getContact list autocomplete
**/

 var autocomp_opt={
        source: BASE_URL+'index.php/owners/loadcontacts',
        focus: function(event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
                // manually update the textbox
                $(this).val(ui.item.label);
        },
        select: function(event, ui) {
                // prevent autocomplete from updating the textbox
                event.preventDefault();
                // manually update the textbox and hidden field
                $(this).val(ui.item.label);

                var id = this.id;

                $("#" + id + "_id").val(ui.item.value);
        },
        minLength: 1
   };

$(function() {
                //autocomplete
                $(".auto_client").autocomplete({

                        source: BASE_URL+'index.php/owners/loadcontacts',
                        focus: function(event, ui) {
                                // prevent autocomplete from updating the textbox
                                event.preventDefault();
                                // manually update the textbox
                                $(this).val(ui.item.label);
                        },
                        select: function(event, ui) {
                                // prevent autocomplete from updating the textbox
                                event.preventDefault();
                                // manually update the textbox and hidden field
                                $(this).val(ui.item.label);

                                var id = this.id;

                                $("#" + id + "_id").val(ui.item.value);

                        },
                        minLength: 1
                });
            });


 /**
   autocomplete city
   */
   //  var autocomp_opt={
   //      source: BASE_URL+'index.php/owners/loadcity',
   //      focus: function(event, ui) {
   //              // prevent autocomplete from updating the textbox
   //              event.preventDefault();
   //              // manually update the textbox
   //              $(this).val(ui.item.label);
   //      },
   //      select: function(event, ui) {
   //              // prevent autocomplete from updating the textbox
   //              event.preventDefault();
   //              // manually update the textbox and hidden field
   //              $(this).val(ui.item.label);

   //              var id = this.id;

   //              $("#" + id + "_id").val(ui.item.id);
                
   //              //$("#"+id1+"_state_id").val(ui.item);
   //      },
   //      minLength: 1
   // };


    $(function() {
                //autocomplete
                $(".autocompleteCity").autocomplete({

                        source: BASE_URL+'index.php/owners/loadcity',
                        focus: function(event, ui) {
                                // prevent autocomplete from updating the textbox
                                event.preventDefault();
                                // manually update the textbox
                                $(this).val(ui.item.label);
                        },
                        select: function(event, ui) {
                        	//console.log(event);
                        	//console.log(this);
                                // prevent autocomplete from updating the textbox
                                event.preventDefault();
                                // manually update the textbox and hidden field
                                $(this).val(ui.item.label);

                                var id = this.id;

                                $("#" + id + "_id").val(ui.item.id);
                                var id1=id.split('_');
                            console.log(id1[0]);
                            var newid=id1[0]+"_"+id1[1];
                                $("#"+newid+"_state_id").val(ui.item.state_id)

                        },
                        change: function (event, ui) { 
                        	$(this).val(ui.item.label);
                                var id = this.id;
                                //alert(id);
                        	var id1=id.split('_');
                            //console.log(id1[0]);
                            var newid=id1[0]+"_"+id1[1];
                            //console.log(newid);
                              var state_id= $("#"+newid+"_state_id").val();
                              //alert(state_id);
                                 	$.ajax({
   		method:"POST",
   		url:BASE_URL+'index.php/owners/getStateCountryByCity',
   		data:{state_id : state_id},
   		dataType:"json",
   		success:function(responsdata){
   			$("#"+id1[0]+"_"+id1[1]+"_state").val(responsdata.state_name);
   			$("#"+id1[0]+"_"+id1[1]+"_country").val(responsdata.country_name);
   			$("#"+id1[0]+"_"+id1[1]+"_country_id").val(responsdata.country_id);
   		}   
   	});
                        },

                        minLength: 1
                });
            });

   $(function(){
    $(".loadcountrydropdown").autocomplete({

                        source: BASE_URL+'index.php/owners/loadcountry',
                        focus: function(event, ui) {
                                // prevent autocomplete from updating the textbox
                                event.preventDefault();
                                // manually update the textbox
                                $(this).val(ui.item.label);
                        },
                        select: function(event, ui) {
                            //console.log(event);
                            //console.log(this);
                                // prevent autocomplete from updating the textbox
                                event.preventDefault();
                                // manually update the textbox and hidden field
                                $(this).val(ui.item.label);

                                var id = this.id;

                                $("#" + id + "_id").val(ui.item.id);
                                //var id1=id.substr(0, 9);
                               // $("#"+id1+"state_id").val(ui.item.state_id)

                        },
                        minLength:1

    });

   });

 $(function(){
    $(".loadstatedropdown").autocomplete({

                        source: BASE_URL+'index.php/owners/loadState',
                        focus: function(event, ui) {
                                // prevent autocomplete from updating the textbox
                                event.preventDefault();
                                // manually update the textbox
                                $(this).val(ui.item.label);
                        },
                        select: function(event, ui) {
                            //console.log(event);
                            //console.log(this);
                                // prevent autocomplete from updating the textbox
                                event.preventDefault();
                                // manually update the textbox and hidden field
                                $(this).val(ui.item.label);

                                var id = this.id;

                                $("#" + id + "_id").val(ui.item.id);
                                //var id1=id.substr(0, 9);
                               // $("#"+id1+"state_id").val(ui.item.state_id)

                        },
                        minLength:1

    });

   });