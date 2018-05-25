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
  change: function(event, ui) {
          var id = this.id;
          $("#" + id + "_id").val('');
          var con_name = $(this).val();
          $(this).val('');

          if (con_name!="" && con_name!=null) {
            $.ajax({
              method:"GET",
              url:BASE_URL+'index.php/owners/loadcontacts',
              data:{term : con_name},
              dataType:"json",
              success:function(responsdata){
                $("#"+id).val(responsdata[0].label);
                $("#" + id + "_id").val(responsdata[0].value);
              }   
            });
          }
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
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/owners/loadcontacts',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].value);
                }   
              });
            }
    },
    minLength: 1
  });
});

$("#save_contact").click(function(){
    if ($("#contact_popup_form").valid()) {
        var $result = 0;
        //            alert("success");
        $.ajax({
            url: BASE_URL+'index.php/contacts/saveContact',
            data: $("#contact_popup_form").serialize(),
            cache: false,
            type: "POST",
            dataType: 'html',
            global: false,
            async: false,
            success: function (data) {
            //                    alert(data);
                if ($.isNumeric($.trim(data))) {
                    $result = 1;
                } else {
                    $result = 0;
                }

            },
            error: function (data) {
            //                    alert(data);
                $result = 0;
            }
        });

        if ($result) {
            $(this).parents(".message-box").removeClass("open");
            $('#con_first_name').val('');
            $('#con_middle_name').val('');
            $('#con_last_name').val('');
            $('#con_email_id1').val('');
            $('#con_mobile_no1').val('');
            $('#con_first_name, #con_middle_name, #con_last_name, #con_email_id1, #con_mobile_no1').removeClass('valid');
            return false;
        }
        else {
            return false;
        }
    }
});


/**
*getOwner list autocomplete
**/
var autocomp_opt_owner={
    source: BASE_URL+'index.php/owners/loadowners',
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
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/owners/loadowners',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].value);
                }   
              });
            }
    },
    minLength: 1
};

$(function() {
  //autocomplete
  $(".auto_owner").autocomplete({
    source: BASE_URL+'index.php/owners/loadowners',
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
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/owners/loadowners',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].value);
                }   
              });
            }
    },
    minLength: 1
  });
});


/**
*getCity list autocomplete
**/
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
            // console.log(id1[0]);
            var newid=id1[0]+"_"+id1[1];
            $("#"+newid+"_state_id").val(ui.item.state_id);
    },
    change: function (event, ui) { 
          	// $(this).val(ui.item.label);
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


/**
*getCountry list autocomplete
**/
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


/**
*getState list autocomplete
**/
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


/**
*getRelatedParty list autocomplete
**/
var auto_client_by_type_opt={
  source: function(request, response) {
            var id = this.element[0].id;
            var cnt = id.substr(id.lastIndexOf("_")+1);
            var type_id = "#rp_type_" + cnt.toString();
            var type = $(type_id).val();

            $.ajax({
                url: BASE_URL+'index.php/owners/loadcontacts',
                dataType: "json",
                data: {
                    term : request.term,
                    type : type
                },
                success: function(data) {
                    response(data);
                }
            });
  },
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
  change: function(event, ui) {
          var id = this.id;
          $("#" + id + "_id").val('');
          var con_name = $(this).val();
          $(this).val('');
          var cnt = id.substr(id.lastIndexOf("_")+1);
          var type_id = "#rp_type_" + cnt.toString();
          var type = $(type_id).val();

          if (con_name!="" && con_name!=null) {
            $.ajax({
              method:"GET",
              url:BASE_URL+'index.php/owners/loadcontacts',
              data:{term : con_name, type : type},
              dataType:"json",
              success:function(responsdata){
                $("#"+id).val(responsdata[0].label);
                $("#" + id + "_id").val(responsdata[0].value);
              }   
            });
          }
  },
  minLength: 1
};

$(function() {
  //autocomplete
  $(".auto_client_by_type").autocomplete({
    source: function(request, response) {
              var id = this.element[0].id;
              var cnt = id.substr(id.lastIndexOf("_")+1);
              var type_id = "#rp_type_" + cnt.toString();
              var type = $(type_id).val();

              $.ajax({
                  url: BASE_URL+'index.php/owners/loadcontacts',
                  dataType: "json",
                  data: {
                      term : request.term,
                      type : type
                  },
                  success: function(data) {
                      response(data);
                  }
              });
    },
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
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');
            var cnt = id.substr(id.lastIndexOf("_")+1);
            var type_id = "#rp_type_" + cnt.toString();
            var type = $(type_id).val();

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/owners/loadcontacts',
                data:{term : con_name, type : type},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].value);
                }   
              });
            }
    },
    minLength: 1
  });
});


/**
*getDocument list autocomplete
**/
var autocomp_opt_document={
    source: BASE_URL+'index.php/documents/loadDocuments',
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
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            // $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/documents/loadDocuments',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].value);
                  var d_show_expiry_date = responsdata[0].d_show_expiry_date;
                  var index = id.substr(id.lastIndexOf('_')+1);
                  if(d_show_expiry_date=='Yes') {
                    $("#date_expiry_" + index).show();
                  } else {
                    $("#date_expiry_" + index).hide();
                  }
                }   
              });
            }
    },
    minLength: 1
};

$(function() {
  //autocomplete
  $(".auto_document").autocomplete({
    source: BASE_URL+'index.php/documents/loadDocuments',
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
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            // $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/documents/loadDocuments',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].value);
                  var d_show_expiry_date = responsdata[0].d_show_expiry_date;
                  var index = id.substr(id.lastIndexOf('_')+1);
                  if(d_show_expiry_date=='Yes') {
                    $("#date_expiry_" + index).show();
                  } else {
                    $("#date_expiry_" + index).hide();
                  }
                }   
              });
            }
    },
    minLength: 1
  });
});


$(function() {
    //autocomplete
    $(".auto_bank").autocomplete({
            source: BASE_URL+'index.php/bank/loadbanks',
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
*getContactOwner list autocomplete
**/
var autocomp_opt_contact_owner={
    source: BASE_URL+'index.php/owners/loadcontact_owners',
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
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/owners/loadcontact_owners',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].value);
                }   
              });
            }
    },
    minLength: 1
};

$(function() {
  //autocomplete
  $(".auto_contact_owner").autocomplete({
    source: BASE_URL+'index.php/owners/loadcontact_owners',
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
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/owners/loadcontact_owners',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].value);
                }   
              });
            }
    },
    minLength: 1
  });
});


$(function() {
  //autocomplete
  $(".auto_non_legal_contact_owner").autocomplete({
    source: BASE_URL+'index.php/owners/load_non_legal_contact_owners',
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
    change: function(event, ui) {
            var id = this.id;
            $("#" + id + "_id").val('');
            var con_name = $(this).val();
            $(this).val('');

            if (con_name!="" && con_name!=null) {
              $.ajax({
                method:"GET",
                url:BASE_URL+'index.php/owners/load_non_legal_contact_owners',
                data:{term : con_name},
                dataType:"json",
                success:function(responsdata){
                  $("#"+id).val(responsdata[0].label);
                  $("#" + id + "_id").val(responsdata[0].value);
                }   
              });
            }
    },
    minLength: 1
  });
});
