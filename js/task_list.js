function allowDrop(ev) {
    ev.preventDefault();
    document.getElementById("text1").style.display = "none";
    document.getElementById("text2").style.display = "none";
    document.getElementById("text3").style.display = "none";
    document.getElementById("border_1").style.border = "0";
    document.getElementById("border_2").style.border = "0";
    document.getElementById("border_3").style.border = "0";
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);

    // console.log(ev.target.id);

    var target_id = ev.target.id;
    var parent_id = document.getElementById(target_id).parentNode.id;

    // console.log(parent_id);

    var index = parent_id.substr(parent_id.lastIndexOf('_')+1);

    var count = parseInt($('#count_'+index).html())-1;
    // console.log(count);

    $('#count_'+index).html(count);
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");

    // console.log(data);
    // console.log(ev.target.id);

    var target_id = ev.target.id;
    var index = target_id.substr(target_id.lastIndexOf('_')+1);
    // console.log(index);

    var count = parseInt($('#count_'+index).html())+1;
    // console.log(count);

    $('#count_'+index).html(count);

    ev.target.appendChild(document.getElementById(data));
    document.getElementById("text1").style.display = "block";
    document.getElementById("text2").style.display = "block";
    document.getElementById("text3").style.display = "block";

    document.getElementById("border_1").style.border = "2px dashed #d1d3d8";
    document.getElementById("border_2").style.border = "2px dashed #d1d3d8";
    document.getElementById("border_3").style.border = "2px dashed #d1d3d8";

    var task_id = data.substr(data.lastIndexOf('_')+1);

    // console.log(task_id);

    var status = 'New';
    if(index==1){
        status = 'New';
    } else if(index==2){
        status = 'In Progress';
    } else if(index==3){
        status = 'Resolved';
    }

    var formdata = {
        'task_id' : task_id,
        'status' : status
    }
    if(task_id != 0 || task_id) { 
        $.ajax({
            type : "POST",
            data : formdata,
            dataType : 'json',
            url : BASE_URL+'index.php/Task/set_status',
            success : function(responsmydata){
                // console.log(responsmydata);
                // if(responsmydata.status == 0){
                //     alert(responsmydata.msg);
                // } else {
                //     window.location.href=BASE_URL + 'index.php/Task';
                // }
            }
        });
    }
}

// var set_task_status = function(){
//     // var task_id = '297';

//     // var formdata = {
//     //     'task_id' : task_id,
//     //     'status' : 'Resolved'
//     // }
//     // if(task_id != 0 && task_id != '') { 
//     //     $.ajax({
//     //         type : "POST",
//     //         data : formdata,
//     //         dataType : 'json',
//     //         url : 'http://localhost/rent_mgmt/index.php/Task/set_status',
//     //         success : function(responsmydata){
//     //             // console.log(responsmydata);
//     //             // if(responsmydata.status == 0){
//     //             //     alert(responsmydata.msg);
//     //             // } else {
//     //             //     window.location.href=BASE_URL + 'index.php/Task';
//     //             // }
//     //         }
//     //     });
//     // }
// }