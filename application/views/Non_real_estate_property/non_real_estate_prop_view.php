<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

	<style>
.checkbox
{
	padding-left: 12px!important;
}
.view_table
{
	margin-left:12px!important;
	margin-right:12px!important;
}
        #image-preview {
            min-width: auto;
            min-height: 250px;
            width:100%;
            height:auto;
            position: relative;
            overflow: hidden;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            color: #ecf0f1;
            margin:auto;
        }
		.edit {
			color:#41a541!important;
		}
		.delete {
			color:#da5050!important;
			margin-left:0px!important;
		}
		.print {
			color:#fe970a!important;
			display:none!important;
		}
		.a {
			border-bottom: 2px solid #edf0f5;
			margin-bottom: 25px;
			padding-bottom: 25px;
		}
		.prop_img {
			border: 1px solid #ddd;
			border-radius: 4px;
			padding: 5px;
			width: 150px;
		}
		.markup {
			border-radius:20px;
		}
		#contact1 {
			width: 150px;
			height: 150px;
			text-align: center;
			float: none;
			margin: 15px auto;
			display: block;
			color:#fff!important;
		}
		.info {
			text-align:center;

		}
	
  
		.invoice {
			margin: 10px;
			padding: 0 27px;
			border-radius: 30px;
			font-size: 13px;
		}
		.btn-group-justified {
			margin-left:2px;
		}
		.email {
			font-size:13px!important;
			color:#fff!important;
		}
		.title_1 {
			font-size: 1.14286rem!important;
			font-family: inherit!important;
			font-weight: 500!important;
			letter-spacing: 0.02em!important;
			text-transform: capitalize!important;
			color:#fff!important;
		}
		.contact_card {
			border-radius:5px!important;
		}
		.rent {
			color:#fff!important;
			border-right:2px solid #edf0f5;
			padding: 6px 10px;
			text-align:center;
			color:#40434b;
			border-color: rgba(255,255,255,0.1) !important;	
		}
		.rent:hover {
			background-color: rgba(255,255,255,0.1) !important;
		}
		.leases {
			color:#fff!important;
			border-top: 2px solid #edf0f5;
			padding: 6px 10px;
			text-align:center;
			color:#40434b;
			border-right:2px solid #edf0f5;
			border-color: rgba(255,255,255,0.1) !important;
		}
		.leases:hover {
			background-color: rgba(255,255,255,0.1) !important;
		}
		.badge-notify {
			background: #899be7;
			position: relative;
			top: -88px;

			left: 188px;
			width: 28px;
			height: 28px;
			color: #fff;

			border: 2px solid #ffffff;
			position: absolute;
			top: 30px;

			width: 28px;
			height: 28px;
			border-radius: 50%;
			background-color: #41c997;
			display: -webkit-box;
			display: -webkit-flex;
			display: -ms-flexbox;

			-webkit-box-align: center;
			-webkit-align-items: center;
			-ms-flex-align: center;
			align-items: center;
			-webkit-box-pack: center;
			-webkit-justify-content: center;
			-ms-flex-pack: center;
			justify-content: center;
			border: 2px solid #ffffff;
			-webkit-transition: background-color 0.2s linear;
			transition: background-color 0.2s linear;
		}
		#money.fa {
			font-size:22px!important;
		}
		.user-roommates:after {
			content: '';
			position: absolute;
			left: 50%;
			top: 161px;
			width: 22px;
			height: 1px;
			margin-left: -11px;
			background-color: #e6ebf1;
		}
		.user-roommates.empty>p {
			text-align:center;
			font-size: 12px;
			color: #d1d3d8;
		}
		.form-group-default {
			border:none!important;
		}
		.form-group-default label {
			font-weight:1000!important;
		}
		.thumbnail-wrapper.d32>* {
			line-height: 110px!important;
		}
		#pricing_box:before {
			content: '';
			position: absolute;
			top: -16px;
			left: 50%;
			width: 22px;
			height: 3px;
			opacity: 0.4;
			margin-left: -11px;
			border-radius: 2px;
			background-color: #000000;
		}
		#invoice_box:before {
			content: '';
			position: absolute;
			top: -16px;
			left: 50%;
			width: 22px;
			height: 3px;
			opacity: 0.4;
			margin-left: -11px;
			border-radius: 2px;
			background-color: #000000;
		}
	.block1 {
			padding: 20px 20px;
			border: 2px solid #edf0f5;
			border-radius: 7px;
			background: #f6f9fc;
			margin-top: 10px;
			margin-bottom: 10px;
			margin-left:12px;
			margin-right:12px;
		}
		p {
			font-weight: 200px!important;
			margin-left:12px;
			
		}
		.created_date {
			text-align:center;
		}
		.dropdown-item input {
			display: inline; 
			padding-left: 0px;
			cursor: pointer;
			font-size: 13px;
		}
		.select2-selection, .select2-selection__rendered{
			background: white!important;
			color: rgba(0, 0, 0, 0.36)!important;
			font-weight: normal;
		}
		.select2-selection__arrow {
			display: none;
		}
	</style>
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
	<?php $this->load->view('templates/main_header');?>
	<div class="page-content-wrapper ">
		<div class="content ">
			<form id="form_purchase_view" role="form" method ="post" action="" enctype="multipart/form-data">
			<div class=" container-fluid   container-fixed-lg">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="">Dashboard</a></li>
					<li class="breadcrumb-item"><a href="index/Purchase/checkstatus/All">Purchase List</a></li>
					<li class="breadcrumb-item active">Property View</li>
				</ol>
				<div class="container">
					<div class="row">
						<div class="card card-transparent  bg-white" style="background:#fff;margin-right:8px;">
							<div class=" " style="padding:10px;">
								<a href="">
									<div class="fileUpload blue-btn btn width100 pull-left">
										<span><i class="fa fa-arrow-left"></i></span> 
									</div>
								</a>
								<div class="dropdown pull-right hidden-md-down">
									<button class="profile-dropdown-toggle pull-right" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<div class="fileUpload blue-btn btn width100">
											<span><i class="fa fa-ellipsis-h"></i></span> 
										</div>
									</button>
									<div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
										<?php  if(isset($access)) { 
											if($access[0]->r_edit == 1) {  ?> 
											<a href="<?php echo base_url().'index.php/Non_real_estate_property/edit/'.$p_id; ?>" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a>
										<?php } }  ?>
										<?php if(isset($property)) { ?>
										<?php  if(isset($access)) { 
											if($access[0]->r_delete == 1) {  ?><a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> 
										<?php } } } 
										 	else if($p_txn[0]->txn_status != 'In Process') { 
											if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
											<a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
	                                        <a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
                                        <?php } } }?>    		

										<a href="#" class="dropdown-item print"><i class="fa fa-print"></i> Print</a>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-3" style="background: linear-gradient(45deg, #39414d 0%, #39414d 25%, #444c59 51%, #4c5561 78%, #4e5663 100%); padding-right: 15px;padding-left: 15px;">
						  	<div class="p-t-20">
		                         <div id="image-preview" class="p-l-20 p-b-20 p-t-20 p-r-20" style="background-image: url('<?php if (isset($property[0]->p_image)) echo base_url().$property[0]->p_image; else echo base_url().'assets/img/demo/preview.jpg'; ?>');">
                        </div>
		                    </div>
					
							<!-- <div class="card card-transparent container-fixed-lg bg-white contact_card m-t-30" id="pricing_box"style="background:rgba(0,0,0,0.2);">
								<div class="row" style="">
									<div class="col-md-6 rent">
										<b style="font-size:22px;">1</b><br>
										Tenant
									</div>
									<div class="col-md-6 rent" style="border-right:none;">
										<b style="font-size:22px;" >1</b><br>
										Maintenance 
									</div>
								</div>
							</div> -->
						</div>
						
						<div class="col-md-9">
							<div class=" container-fluid container-fixed-lg bg-white">
			                    <div class="card card-transparent">
			                     
			                           
								<div class="a">
			                        <p class="m-t-20"><b>General Information</b></p>
			                   
			                            <div class="row clearfix">
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>Unit Name</label>
			                                   	<span class="label_addr"><?=$property[0]->unit_name?></span>
			                                    </div>
			                                </div>
			                               
										    <div class="col-md-6">
			                                    <div class="form-group form-group-default">
			                                        <label>Unit Type</label>
			                                        <span class="label_addr"><?=$property[0]->np_unit_type?></span>
			                                    </div>
			                                </div>
										   
			                            </div>
			                   
			                         
			                            <div class="row clearfix">
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default ">
			                                        <label class=""> Area</label>
													<span class="label_addr"><?=$property[0]->area?></span>
			                                    </div>
			                                </div>
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default ">
			                                        <label class=""> Area Unit </label>
													<span class="label_addr"><?=$property[0]->area_unit?></span>
			                                    </div>
			                                </div>
			                            </div>
			                        
									<div class="row clearfix">
			                                <div class="col-md-6">
			                                    <div class="form-group form-group-default ">
			                                        <label class=""> Location</label>
													<span class="label_addr"><?=$property[0]->location;?></span>
			                                    </div>
			                                </div>
			                               
			                            </div>
			                   

			                    <?php //$this->load->view('templates/document_view');?>

			            
			                </div>
			                </div>
		                </div>
					</div>
				</div>
			</div>
    		</form>
		</div>
		<?php $this->load->view('templates/footer');?>
	</div>
</div>

<?php $this->load->view('templates/script');?>
<script type="text/javascript">
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

</script>

<script>

$("#sidebar_cntrl").click(function(e) {
    e.preventDefault();
    if (!$(this).hasClass('menu-pin')) {
       $( "#map" ).css('width', '100%');
	      
    }
	  else if (!$(this).removeClass('menu-pin')) {
       $( "#rent_field" ).css('width', '222px');
	      
    }
	
	
		
	
});
</script>
</body>
</html>