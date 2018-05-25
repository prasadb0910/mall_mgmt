var format_money = function(num, decimals){
    if(num==null || num==""){
        num="";
    }
    num = num.toString().replace(/[^0-9]/g,'');
    var x=num;
    x=x.toString();
    x = x.split(",").join("");
    var lastThree = x.substring(x.length-3);
    var otherNumbers = x.substring(0,x.length-3);
    if(otherNumbers != '') lastThree = ',' + lastThree;
    var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
    return res;
}

var get_number = function(num, decimals){
    if(num==null || num==""){
        num="0";
    }
    res = parseFloat(num.replaceAll(",",""));
    return res;
}

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};

var format_number = function(elem){
    var res = format_money(elem.value,2);
    $(elem).val(res);
}

var delete_row = function(elem){
    var id = elem.attr('id');
    id = '#'+id.substr(0,id.lastIndexOf('_'));
    if($(id).length>0){
        $(id).remove();
        $(".save-form").prop("disabled",false);
    }
}

$(document).ready(function(){
    $('.format_number').keyup(function(){
        format_number(this);
    });

    $('.delete_row').click(function(event){
        delete_row($(this));
    });
});


$(document).ready(function() {
	$('#collapse_menu').click(function() {
		//alert('hi');
		if($('.vertical_nav').hasClass('vertical_nav__minify')) {
			//alert('hi');
			$.cookie("menu","open");
			$('.mCustomScrollBox').css('overflow','hidden');
			//$('.mCustomScrollbar _mCS_1').css('overflow','hidden');
		} else {
			$.cookie("menu","close"); 
			$('.mCSB_scrollTools').hide();
			$('.mCustomScrollBox').css('overflow','visible');
			//$('.mCustomScrollbar _mCS_1').css('overflow','hidden');
		}
	}); 
});

$(document).ready(function() {
	$("form").attr("autocomplete", "Off");
	// $("input[name='submit']").prop("disabled",true);
	$(".save-form").prop("disabled",true);
});

$("form :input").change(function() {
	$(".save-form").prop("disabled",false);
});

// $('.datepicker').attr('readonly','true');
// $('.datepicker1').attr('readonly','true');

$('.date').attr('readonly','true');
$('.date1').attr('readonly','true');
$('.datepicker').attr('readonly','true');

$(function() { $('.date').datepicker(); });
$(function() { $('.date1').datepicker({  maxDate: 0,changeMonth: true,yearRange:'-100:+0', changeYear: true }); });
$(function() { $('.datepicker').datepicker(); });

$(document).ready(function(){
	var pathname = window.location.pathname;
	if (pathname.toLowerCase().indexOf("dashboard") >= 0) {
		//alert('hi');
	$('.edit-show').show();
	} else {
		$('.edit-show').hide();
	}
});

$(document).ready(function() {
	$.uploadPreview({
		input_field: "#image-upload",
		preview_box: "#image-preview",
		label_field: "#image-label"
	});
});
$('#img_delete').click(function(){
    $("#image-preview").css('background-image', 'none');
    $("#image-upload").val('');
});
$(document).ready(function($) {
	$(".uploadlogo").change(function() {
		readURL(this);
	});
});

var readURL = function (input) {
	var url = input.value;
	var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
	var filename = '';
	if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == "gif" || ext == "pdf" || ext == "xls" || ext == "xlsx")) {
		var path = $(input).val();
		var filename = path.replace(/^.*\\/, "");
		filename = ""+filename;
	} else {
		$(input).val("");
		filename = "Only image/pdf formats are allowed!";
	}
	$(input).parent().children('span').html(filename);
}

$(function(){
	$('#popModal_ex1').click(function(){
		$('#popModal_ex1').popModal({
			html : $('#content'),
			placement : 'bottomLeft',
			showCloseBut : true,
			onDocumentClickClose : true,
			onDocumentClickClosePrevent : '',
			overflowContent : false,
			inline : true,
			asMenu : false,
			beforeLoadingContent : 'Please, wait...',
			onOkBut : function() {},
			onCancelBut : function() {},
			onLoad : function() {},
			onClose : function() {}
		});
	});

	$('#popModal_ex2').click(function(){
		$('#popModal_ex2').popModal({
			html : function(callback) {
				$.ajax({url:'ajax.html'}).done(function(content){
					callback(content);
				});
			}
		});
	});

	$('#popModal_ex3').click(function(){
		$('#popModal_ex3').popModal({
			html : $('#content3'),
			placement : 'bottomLeft',
			asMenu : true
		});
	});

	$('#notifyModal_ex1').click(function(){
		$('#content2').notifyModal({
			duration : 2500,
			placement : 'center',
			overlay : true,
			type : 'notify',
			onClose : function() {}
		});
	});

	$('#dialogModal_ex1').click(function(){
		$('.dialog_content').dialogModal({
			topOffset: 0,
			top: '10%',
			type: '',
			onOkBut: function() {},
			onCancelBut: function() {},
			onLoad: function(el, current) {},
			onClose: function() {},
			onChange: function(el, current) {
				if(current == 3){
					el.find('.dialogModal_header span').text('Page 3');
					$.ajax({url:'ajax.html'}).done(function(content){
						el.find('.dialogModal_content').html(content);
					});
				}
			}
		});
	});

	$('#confirmModal_ex1').click(function(){
		$('#confirm_content1').confirmModal({
			topOffset: 0,
			onOkBut: function() {},
			onCancelBut: function() {},
			onLoad: function() {},
			onClose: function() {}
		});
	});

	$('#confirmModal_ex').click(function(){
		$('#confirm_content1').confirmModal({
			topOffset: 0,
			onOkBut: function() {},
			onCancelBut: function() {},
			onLoad: function() {},
			onClose: function() {}
		});
	});


	(function($) {
		$.fn.tab = function(method){
			var methods = {
				init : function(params) {

					$('.tab').click(function() {
						var curPage = $(this).attr('data-tab');
						$(this).parent().find('> .tab').each(function(){
							$(this).removeClass('active');
						});
						$(this).parent().find('+ .page_container > .page').each(function(){
							$(this).removeClass('active');
						});
						$(this).addClass('active');
						$('.page[data-page="' + curPage + '"]').addClass('active');
					});

				}
			};
			if (methods[method]) {
				return methods[method].apply( this, Array.prototype.slice.call(arguments, 1));
			} else if (typeof method === 'object' || ! method) {
				return methods.init.apply(this, arguments);
			}
		};
		$('html').tab();
	})(jQuery);
});

$("#form_change_password").validate({
    rules: {
        old_password: {
            required: true,
            checkValidPassword: true
        },
        new_password: {
            required: true,
            minlength: 6,
            maxlength: 10
        },
        confirm_new_password: {
            required: true,
            minlength: 6,
            maxlength: 10,
            equalTo: "#new_password"
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

$.validator.addMethod("checkValidPassword", function (value, element) {
    var result = 1;

    $.ajax({
        url: BASE_URL+'index.php/Login/check_valid_password',
        data: 'password='+$("#old_password").val(),
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
}, 'Old Password does not match.');

$('#form_change_password').submit(function() {
    if (!$("#form_change_password").valid()) {
        return false;
    } else {
        return true;
    }
});

$('#btn_change_password').on('click', function (e) {

    if (!$("#form_change_password").valid()) {
        return false;
    } else {

    	var result = 1;

	    $.ajax({
	        url: BASE_URL+'index.php/Login/change_password',
	        data: 'password='+$("#new_password").val(),
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

	    if(result==1) {
	    	alert("Password changed successfully.")
	    	$(this).parents(".message-box").removeClass("open");
				return true;
	    } else {
	    	return false;
	    }
    }
});



$(document).ready(function() {
	$('.menu-pin').click(function() {
		//alert('hi');
		if($('.vertical_nav').hasClass('vertical_nav__minify')) {
			//alert('hi');
			$.cookie("menu","open");
			$('.mCustomScrollBox').css('overflow','hidden');
			//$('.mCustomScrollbar _mCS_1').css('overflow','hidden');
		} else {
			$.cookie("menu","open");
			$('.mCustomScrollBox').css('overflow','hidden');
			//$('.mCustomScrollbar _mCS_1').css('overflow','hidden');
		}
	}); 
});

  $("#con_add_city,#pur_add_city").on("change",function()
    {
        
        var cityid = $('option:selected', this).attr('data-id');
        $.ajax({
            url: BASE_URL + "index.php/Contacts/get_state_country",
            data: 'cityid='+ cityid,
            cache: false,
            type: "POST",
            dataType: 'html',
            global: false,
            async: false,
            success: function (data) {
                var detail = $.parseJSON(data);
                //console.log(detail[0]['state_name']+detail[0]['country_name']);
                $("#con_add_state,#pur_add_state").val(detail[0]['state_name']);
                $("#con_add_country,#pur_add_country").val(detail[0]['country_name']);
            },
            error: function (xhr, status, error) {
                    //alert(xhr.responseText);
            }
        });
    });
// $(document).ready(function() {
// 	if($.cookie("menu")==="open") {
// 		$('.vertical_nav').removeClass('vertical_nav__minify');
// 		$('.wrapper').removeClass('wrapper__minify');
// 		//alert('if');
// 	} else {
// 		$('.vertical_nav').removeClass('vertical_nav__minify');
// 		$('.wrapper').removeClass('wrapper__minify');
// 		// alert('else');
// 	}
// });



// function submit_form_change_password(){
// 	if (!$("#form_change_password").valid()) {
//         return false;
//     } else {

//     	var result = 1;

// 	    $.ajax({
// 	        url: BASE_URL+'index.php/Login/change_password',
// 	        data: 'password='+$("#new_password").val(),
// 	        type: "POST",
// 	        dataType: 'html',
// 	        global: false,
// 	        async: false,
// 	        success: function (data) {
// 	            result = parseInt(data);
// 	        },
// 	        error: function (xhr, ajaxOptions, thrownError) {
// 	            alert(xhr.status);
// 	            alert(thrownError);
// 	        }
// 	    });

// 	    if(result==1) {
// 	    	alert("Password changed successfully.")
// 	    	$(this).parents(".message-box").removeClass("open");
// 				return true;
// 	    } else {
// 	    	return false;
// 	    }
//     }
// }

// $('#submit_form_change_password').on("click", function() {
// 	console.log('sfsdf');

// 	// if (!$("#form_reset_password").valid()) {
//  //        return false;
//  //    } else {
//  //        // return true;
//  //        $('#confirm_content').toggle();
//  //    }
// });