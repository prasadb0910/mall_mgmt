<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>
    <style>
	
	  .toggle {
            -webkit-appearance: none;
            appearance: none;
            width: 45px;
            height: 24px;
            display: inline-block;
            position: relative;
            border-radius: 50px;
            overflow: hidden;
            outline: none;
            border: none;
            cursor: pointer;
            background-color: #da5050;
            transition: background-color ease 0.3s;
        }
        .toggle:before {
            content: "on off";
            display: block;
            position: absolute;
            z-index: 2;
            width: 16px;
            height: 16px;
            background: #fff;
            left: 1px;
            top: 4px;
            border-radius: 50%;
            font: 9px/19px Helvetica;
            text-transform: uppercase;
            font-weight: bold;
            text-indent: -22px;
            word-spacing: 27px;
            color: #fff;
            text-shadow: -1px -1px rgba(0,0,0,0.15);
            white-space: nowrap;
            box-shadow: 0 1px 2px rgba(0,0,0,0.2);
            transition: all cubic-bezier(0.3, 1.5, 0.7, 1) 0.3s;
        }
        .toggle:checked {
            background-color: #4CD964;
        }
        .toggle:checked:before {
            left: 29px;
        }
        .a {
            border-bottom: 2px solid #edf0f5;
         
            padding-bottom: 25px;
        }
		   .div_heading h5 {
           font-size: 14px;
            font-weight: 600;
            color: #40434b;
            margin-top: 0px;
            margin-bottom: 0px;
        	text-align:left;
        }
        #image-preview {
            min-width: auto;
            min-height: 300px;
            width:100%;
            height:auto;
            position: relative;
            overflow: hidden;
            background: url("<?php echo base_url();?>assets/img/demo/preview.jpg") ;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            color: #ecf0f1;
            margin:auto;
        }
        #image-preview input {
            line-height: 200px;
            font-size: 200px;
            position: absolute;
            opacity: 0;
            z-index: 10;
        }
        #image-label {
            color:white;
            padding-left:6px;
        }
        #image-label_field{
            background: transparent -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(75%, rgba(0,0,0,0.8))) repeat scroll 0 0;
        }
        #image-label_field:hover{
            background: transparent linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.8) 75%) repeat scroll 0 0;
        }
        .add{
            color:#41a541;
            cursor:pointer;
            font-size:14px;
            font-weight:500;
        }
        .remove{
            color:#d63b3b;
            text-align:right;
            cursor:pointer;
            margin-bottom: 10px;
            font-size:14px;
            font-weight:500;
        }
        .block1{
            padding: 20px 20px;
            border: 2px solid #edf0f5;
            border-radius: 7px;
            background: #f6f9fc;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .delete{
            color:#d63b3b;
            text-align:left;
            vertical-align:center;
            cursor:pointer;
            margin-top: 15px;
            font-size:20px;
            font-weight:500;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 28px;
            font-weight:400;
        }
        .blue-btn:hover,
        .blue-btn:active,
        .blue-btn:focus,
        .blue-btn {
            background: transparent;
            border: dotted 1px #27a9e0;
            border-radius: 3px;
            color: #27a9e0;
            font-size: 16px;
            margin-bottom: 20px;
            outline: none !important;
            padding: 10px 20px;
        }
        .fileUpload {
            position: relative;
            overflow: hidden;
            height: 43px;
            margin-top: 0;
        }
        .fileUpload input.uploadlogo {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
            width: 100%;
            height: 42px;
        }
        input::-webkit-file-upload-button {
            cursor: pointer !important;
            height: 42px;
            width: 100%;
        }
        .attachments{
            fon-size:20px!important;
            font-weight:600;
            padding-left:15px;
            border-left: solid 2px #27a9e0;
        }
        .addschedule td{
            border:1px solid;
            padding:0px !important;
        }
        .addschedule th{
            border:1px solid;
        }
        .addtax td{
            border:1px solid;
            /*padding:0px !important;*/
        }
        .addtax th{
            border:1px solid;
        }
        .modal-content{
            width: 1000px;
        }
        #schedule_table td{
            background:#ffffff;
        }
        .modal-footer{
            display: block;
        }
        .select2-container {
            /* z-index:9999!important;*/
        }
        /*.modal.fade {
            z-index:9999!important;
        }*/
		#ownership-section .select2-container,#general_info .select2-container,#address_info .select2-container,#property_desc .select2-container,#documents .select2-container
		{
			   z-index:0!important;
		}
    </style>
</head>
<body class="fixed-header ">
<?php  $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper ">
<div class="content">
    <form id="form_revenue" role="form" method="POST" enctype="multipart/form-data" 
    action="<?php if(isset($rent)){ echo base_url().'index.php/Rent_revenue_sharing/updaterecord/'.$r_id; } else { echo base_url().'index.php/Rent_revenue_sharing/saverecord';} ?>">
        
        <div class=" container-fluid   container-fixed-lg ">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index/Dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Rent_revenue_sharing">Rent List</a></li>
                
                <li class="breadcrumb-item active">Revenue Details </li>
                <input type="hidden" id="rent_id" name="rent_id" value="<?=(isset($r_id)?$r_id:'')?>" />
                <input type="hidden" id="edit" name="edit" value="<?=(isset($r_id)?1:0)?>" />
            </ol>
            <div class="row">
               <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class=" container-fluid container-fixed-lg bg-white">
                        <div class="card card-transparent">
                            <div class="a m-b-20 allocated_maintenance" id="general_info">
                               <p class="m-t-20">	 
                                <div class="div_heading ">
                                              <h2><?php echo $this->session->flashdata('message'); ?></h2> 
                                              <h5>Property Information & Terms</h5></div></p>
                                               <p class="panel-description"></p>
                                                <div class="row clearfix">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default form-group-default-select2 required">
                                                            <label class="">Unit Name</label>
                                                          <select class="full-width" name="property" id="property" data-error="#err_property" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity" onchange="property_selected();">
                                                                <option value="">Select</option>
                                                                 <?php if(isset($rent)) { 
                                                                    for($i=0; $i<count($property); $i++) { ?>
                                                                        <option value="<?php echo $property[$i]->property_txn_id; ?>" <?php if($revenue_sharing[0]['property_id'] == $property[$i]->property_txn_id) { echo 'selected';} ?> ><?php echo $property[$i]->unit_name; ?></option>
                                                                <?php } } else { ?>
                                                                        <?php for($i=0; $i<count($property); $i++) { ?>
                                                                        <option value="<?php echo $property[$i]->property_txn_id; ?>"><?php echo $property[$i]->unit_name; ?></option>
                                                                <?php } } ?>
                                                            
                                                            </select>
                                                            <div id="err_property"></div>
                                                        </div>
                                                    </div>
                                                </div>
                        					     <div class="row clearfix">
                        								<div class="col-md-3">
                        									<div class="form-group form-group-default form-group-default-select2 required">
                        									<label>Month</label>
                        									<select class="full-width" 
                                                            name="revenue_schedule_id" id="month" data-error="#err_unit" data-placeholder="Select" data-init-plugin="select2" data-minimum-results-for-search="Infinity">

                                                            </select>
                        								    <div id="err_unit"></div>
                        									</div>
                        								</div>
                        						</div>
                        						<div class="row clearfix">
                        							<div class="col-md-3">
                        									<div class="form-group form-group-default ">
                        										<label>Amount</label>
                        										<input type="text" class="form-control format_number rent_amount" name="revenue_amount" id="revenue_amount" onchange="instchange(); opentable();" placeholder="Enter Here" value="<?php if(isset($revenue_sharing)) { if(count($revenue_sharing)>=0) { echo format_money($revenue_sharing[0]['revenue_amount'],2); }} ?>" />
                        									</div>
                        							</div>
                        						</div>
                            </div>
                            <div class="form-footer" style="padding-bottom: 60px;">
                                <input type="hidden" id="submitVal" value="1" />
                                <a href="index/Purchase" class="btn btn-default-danger pull-left" >Cancel</a>
                                <input type="submit" class="btn btn-default pull-right submit-form" name="submit" value="Submit" style="margin-right: 10px;" />
                                <input formnovalidate="formnovalidate" type="submit" class="btn btn-default pull-right save-form m-r-10" name="submit" value="Save" style="<?php// if($maker_checker!='yes' && isset($p_txn)) echo 'display:none'; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
    		   <div class="col-md-1"></div>
            </div>
    </form>
</div>

<?php $this->load->view('templates/script');?>

<script type="text/javascript">
    var BASE_URL ="<?php echo base_url(); ?>";
    var selected = "<?php if(isset($revenue_sharing[0]['event_date']))
                    echo date('F Y',strtotime($revenue_sharing[0]['event_date']));?>";
    console.log(selected);
</script>
<!--script type="text/javascript" src="js/load_autocomplete.js"></script-->
<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>

<script type="text/javascript">
     $( document ).ready(function() {
       property_selected();
      });
     var property_selected = function() {
         $.ajax({
            url:BASE_URL+"index.php/Rent_revenue_sharing/get_month",
            data:{'property_id':$('#property').val(),'edit':$('#edit').val()},
            dataType:"json",
            type:"POST",
            success:function(response){

             if(response.length>0)
            {
               var option='';
               $.each(response, function (index, data) {
                var select = '';
                if(selected==data.event_date)
                    select="selected";
                option += "<option value='"+data.revenue_schedule_id+"' "+select+">"+data.event_date+"</option>";
               })
               $('#month').append(option);  
            }
                
            
            },
            error:function(responsemydata,status,error) {
                var err=eval("("+responsemydata.responseText+")");
                alert(err.Message);
                //alert(responsemydata.data);
            },
        });
    }
</script>

</body>
</html>