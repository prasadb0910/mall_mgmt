// $(function() {
//     $('#repeat-periodically').hide(); 
//     $('#repeat-monthly').hide();
//     $('#repeat-weekly').hide();
//     $('#repeat').change(function(){
//         if($('#repeat').val() == 'Periodically') {
//             $('#repeat-monthly').hide(); 
//             $('#repeat-periodically').show(); 
//             $('#repeat-weekly').hide();
//         } else if($('#repeat').val() == 'Monthly') {				
//             $('#repeat-periodically').hide(); 
//             $('#repeat-monthly').show(); 
//             $('#repeat-weekly').hide();
//         } else if($('#repeat').val() == 'Never' || $('#repeat').val() == 'Daily' || $('#repeat').val() == 'Yearly') {
//             $('#repeat-periodically').hide(); 
//             $('#repeat-weekly').hide(); 
//             $('#repeat-monthly').hide(); 			
//         } else if($('#repeat').val() == 'Weekly') {				
//             $('#repeat-periodically').hide(); 
//             $('#repeat-monthly').hide();
//             $('#repeat-weekly').show(); 
//         }
//     });
// });

// function loadUser(user_id){
//     $.ajax({
//         url: BASE_URL +'index.php/Task/getUsers',
//         dataType:'json',
//         success:function(respondata){
//             $.each(respondata.userdetail,function(id,val){
//                 if(val.id==user_id){
//                     $('#assigned').append($('<option></option>').val(val.id).html(val.text).attr('selected', 'selected'));
//                 } else{
//                     $('#assigned').append($('<option></option>').val(val.id).html(val.text)) ;
//                 }
//             });
//         }
//     });
// }

// function submitForm(){
//     var form_name = "task_detail";
//     var options = {
//         beforeSubmit: function (){
//             return validate(form_name);
//         },
//         beforeSend: function(){},
//         dataType: 'json',				 
//         success: function(responsmydata){
//             alert('hi');                 
//         }
//     };
//     $("#"+form_name).ajaxForm(options);
//     return false;
// }

// function validate(form_name){
//     var $form = $("#"+form_name);
//     if(!$form.valid()){
//         return false;
//     }
// }

function loadTaskList(){
    $('#task_list_datatable').dataTable( {
        "bDestroy":true,
        "autoWidth": false,
        "bProcessing":true,
        "sServerMethod": "POST",
        "sAjaxSource": BASE_URL+'index.php/Task/loadTaskListGrid',
        "columns": [
            { "data": "id" },
            { "data": "name" },
            { "data": "subject_detail" },
            { "data": "priority" },
            { "data": "from_date"},
            { "data": "to_date" },
            { "data": "status"},
            { "data": "c_view"},
            { "data": "c_edit"},
            { "data": "c_delete"}
        ]
    });
}

function getselfContactId(vrtval){
    if($("#self_assigned").is(":checked")) {
        $.ajax({
            url: BASE_URL +'index.php/Task/getUsersContact',
            dataType:'json',
            success:function(respondata){
                $("#txtname_id").val(respondata.value);
                $("#txtname").val(respondata.label);
            }
        });
    } else {
        $("#txtname_id").val('');
        $("#txtname").val('');
    }
}

function deleteRecord(task_id){
    var formdata = {
        task_id : task_id
    }
    if((task_id != 0 || task_id) && confirm('Are you sure you wish to delete this Task?')){ 
        $.ajax({
            type : "POST",
            data : formdata,
            dataType : 'json',
            url : BASE_URL+'index.php/Task/deleteRecord',
            success : function(responsmydata){
                console.log(responsmydata);
                if(responsmydata.status == 0){
                    alert(responsmydata.msg);
                } else {
                    window.location.href=BASE_URL + 'index.php/Task';
                }
            }
        });
    }
}

function completeTask(task_id){
    var formdata = {
        task_id : task_id
    }
    if((task_id != 0 || task_id) && confirm('Are you sure you wish to complete this Task?')){ 
        $.ajax({
            type : "POST",
            data : formdata,
            dataType : 'json',
            url : BASE_URL+'index.php/Task/completeTask',
            success : function(responsmydata){
                console.log(responsmydata);
                if(responsmydata.status == 0){
                    alert(responsmydata.msg);
                } else {
                    window.location.href=BASE_URL + 'index.php/Task';
                }
            }
        });
    }
}

function addComment(task_id){
    var formdata = {
        task_id : task_id,
        task_comment: $("textarea#follower_comment_id").val()
    }
    if((task_id != 0 || task_id)){ 
        $.ajax({
            type : "POST",
            data : formdata,
            dataType : 'json',
            url : BASE_URL+'index.php/Task/addCommentTask',
            success : function(responsmydata){
                $("#follower_comment_id").val('');
            }
        });
    }
}

$("input[name*='self_assigned']").change(function(){
    if($(this).val()=='1'){
        $("#contact_1_id").val('');
        $("#contact_1_id").attr('disabled', true);
    } else {
        $("#contact_1_id").attr('disabled', false);
    }
});

$('.m-btn').click(function(){
    $('.m-btn').removeClass('active');
    $(this).addClass('active');
    $('#priority').val($(this).val());
});

$(document).on('click','.close',function(){
    $(this).parents('span').remove();

})

document.getElementById('uploadBtn').onchange = uploadOnChange;
// document.getElementById('uploadBtn1').onchange = uploadOnChange1;
    
function uploadOnChange() {
    document.getElementById("uploadFile").value = this.value;
    var filename = this.value;
    var lastIndex = filename.lastIndexOf("\\");
    if (lastIndex >= 0) {
        filename = filename.substring(lastIndex + 1);
    }
    var files = $('#uploadBtn')[0].files;
    for (var i = 0; i < files.length; i++) {
     $("#upload_prev").append('<span>'+'<div class="filenameupload">'+files[i].name+'</div>'+'<p class="close" ><i class="fa fa-trash "></i></p></span>');
    }
    // document.getElementById('filename').value = filename;
}

// function uploadOnChange1() {
//     document.getElementById("uploadFile1").value = this.value;
//     var filename = this.value;
//     var lastIndex = filename.lastIndexOf("\\");
//     if (lastIndex >= 0) {
//         filename = filename.substring(lastIndex + 1);
//     }
//     var files = $('#uploadBtn1')[0].files;
//     for (var i = 0; i < files.length; i++) {
//      $("#upload_prev1").append('<span>'+'<div class="filenameupload">'+files[i].name+'</div>'+'<p class="close" ><i class="fa fa-trash "></i></p></span>');
//     }
//     document.getElementById('filename').value = filename;
// }