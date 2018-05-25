
<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>    
        <!-- META SECTION -->
       

                        
		    <style>
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
		<style>
			.faq .faq-item.active .faq-text {background:#FFFFFF;}
			hr{display: block;
			float: left;
			width: 100%;
			margin-top: 10px;
			margin-bottom: 10px;
			border-color: #BDBDBD;}
			th{text-align:center;}
			.center{text-align:center;}
		</style>

        <style>
            .tile {padding: 0px;
                   min-height: 77px;}

        </style>
         
    </head>

  <body class="fixed-header ">
<?php $this->load->view('templates/sidebar1');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>



<div class="page-content-wrapper ">

<div class="content ">



<div class=" container-fluid   container-fixed-lg ">



<ol class="breadcrumb">
	<li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
<li class="breadcrumb-item active "><a href="#">User View</a></li>

</ol>
      <!-- <div class="pull-right btn-top-margin">
                                  
                                      <a class="btn-margin" href="<?php echo base_url().'index.php/Assign/edit/'.$assignusr[0]->gu_id; ?>"><span class="btn btn-success pull-right btn-font"> Edit </span>  </a>

                                            <a  class="btn-margin"  href="<?php echo base_url()?>index.php/Assign" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a>
                             
                                </div>
<div class="row">-->






               <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-transparent  bg-white" style="background:#fff;">
                                <div class=" " style="padding:10px;">
                                    <a href="<?php echo base_url().'index.php/Assign'; ?>">
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
                                          
                                                <a href="<?php echo base_url().'index.php/Assign/edit/'.$assignusr[0]->gu_id; ?>" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a>
                                  

                                            <!-- <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete</a> -->

                                        

                                            <a  href="<?php echo base_url()?>index.php/Assign"  class="dropdown-item delete"><i class="fa fa-print"></i> Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" >
                            <div class="container-fluid p-t-20 container-fixed-lg bg-white">
                                <div class="card card-transparent">
                                <form id="jvalidate" role="form"  method="post" action="<?php echo base_url().'index.php/Assign'; ?>">
                           
                                        <p class=""><b>User Details<b></p>
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Contact</label>
                                                    <input type="text" class="form-control"  value=" <?php if(isset($assignusr[0]->gu_name)){ echo $assignusr[0]->gu_name; } else { echo ''; }?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Status  </label>
                                                    <input type="text" class="form-control"  value="<?php if(isset($assignusr[0]->assigned_status)){ if(($assignusr[0]->assigned_status)=='Approved' || ($assignusr[0]->assigned_status)=='Active') { echo 'Active'; } else { echo 'InActive'; } } else { echo ''; }?> " readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-6" style="<?php if(isset($group_details)) if($group_details[0]->maker_checker=='no') echo 'display: none;'; ?>">
                                                <div class="form-group form-group-default">
                                                    <label>Role</label>
                                                    <input type="text" class="form-control"  value="<?php if(isset($assignusr[0]->role_name)){ echo $assignusr[0]->role_name; } else { echo ''; }?>" readonly />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default ">
                                                    <label>Owner </label>
                                                    <input type="text" class="form-control"   value="<?php if(isset($owner_name)){ if(strlen($owner_name)>0) echo substr($owner_name,0,strlen($owner_name)-1); } else { echo ''; }?>" readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default ">
                                                    <label>Email</label>
                                                   
                                                    <input type="text" class="form-control autocompleteCity"   value=" <?php if(isset($assignusr[0]->gu_email)){ echo $assignusr[0]->gu_email; } else { echo ''; }?> "readonly />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>For Assure </label>
                                                    <input type="text" class="form-control"  value="    <?php if(isset($assignusr[0]->assure)){ echo $assignusr[0]->assure=='1'?'yes':'no'; } else { echo 'No'; }?>" readonly />
                                                </div>
                                            </div>
                                        </div>
										  <div class="row clearfix">
                                          
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Maker Remark </label>
                                                    <input type="text" class="form-control"  value="<?php if(isset($assignusr[0]->maker_remark)){ echo $assignusr[0]->maker_remark; } else { echo ''; }?>" readonly />
                                                </div>
                                            </div>
                                        </div>
										
										         <div class="form_group" style="display: none;">
										<div class="col-md-12 " style="display:-webkit-box; padding:10px;">
                                            <div class="col-md-5">
                                                &nbsp;
                                            </div>
											<div class="col-md-2 ">
                                                <span id="reset_password" type="submit" class="btn btn-default btn-danger btn-font" style=" "><span class="fa fa-plus"></span> Reset Password</span>
											</div>
											<div class="col-md-6">
												&nbsp;
											</div>
										</div>
									</div>
										
                                       </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>






















                     </div>
                     </div>
						
                    </div>
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>
    <?php $this->load->view('templates/script');?>

        <script type="text/javascript">
            $("#reset_password").click(function(){
                var $result = 0;
                $.ajax({
                    url: "<?php echo base_url() . 'index.php/assign/updatepassword/' . $assignusr[0]->gu_id; ?>",
                    data: '',
                    cache: false,
                    type: "POST",
                    dataType: 'html',
                    global: false,
                    async: false,
                    success: function (data) {
                        if ($.isNumeric($.trim(data))) {
                            $result = 1;
                        } else {
                            $result = 0;
                        }
                    },
                    error: function (data) {
                        $result = 0;
                    }
                });

                if($result==1) {
                    alert("Password changed.");
                } else {
                    alert("Change password process failed.");
                }
            });
        </script>
    </body>
</html>