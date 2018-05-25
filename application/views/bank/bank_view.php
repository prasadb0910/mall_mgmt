<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>

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
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
    <?php $this->load->view('templates/main_header');?>
    <div class="page-content-wrapper ">
        <div class="content ">
            <form id="form_bank_view" role="form" method ="post" action="<?php echo base_url().'index.php/Bank/update/'.$b_id; ?>" enctype="multipart/form-data">
            <div class=" container-fluid   container-fixed-lg">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/Dashboard'; ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>index.php/Bank/checkstatus/All">Bank List</a></li>
                    <li class="breadcrumb-item active">Bank View</li>
                </ol>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-transparent  bg-white" style="background:#fff;">
                                <div class=" " style="padding:10px;">
                                    <a href="<?php echo base_url().'index.php/Bank'; ?>">
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
                                            <?php  if(isset($access)) { if($access[0]->r_edit == 1) {  ?> 
                                                <a href="<?php echo base_url().'index.php/Bank/editbank/'.$b_id; ?>" class="dropdown-item edit" ><i class="pg-settings_small"></i> Edit</a>
                                            <?php } }  ?>

                                            <!-- <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete</a> -->

                                            <?php if(isset($bankdetail)) { ?>
                                            <?php if($bankdetail[0]->b_status == 'Approved') { if(isset($access)) { if($access[0]->r_delete == 1) { ?> 
                                                <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete <!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> --> </a>
                                            <?php } } } else if($bankdetail[0]->modified_by != '' && $bankdetail[0]->modified_by != null) { if($bankdetail[0]->modified_by!=$contactby) { if($bankdetail[0]->b_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                                                <a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
                                                <a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
                                            <?php } } } } else { ?>
                                                <!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> -->
                                                <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');" /> </a>
                                            <?php } } else if($bankdetail[0]->created_by != '' && $bankdetail[0]->created_by != null) { if($bankdetail[0]->created_by!=$contactby && $bankdetail[0]->b_status != 'In Process') { if($bankdetail[0]->b_status != 'In Process') { if(isset($access)) { if($access[0]->r_approvals == 1) { ?> 
                                                <a href="#" class="dropdown-item edit" ><i class="pg-settings_small"></i> <input class="dropdown-item edit" type="submit" value="Approve" name="submit"/></a>
                                                <a href="#" class="dropdown-item delete" ><i class="fa fa-trash"></i> <input class="dropdown-item delete" type="submit" value="Reject" name="submit"/></a>
                                            <?php } } } } else { ?>
                                                <!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> -->
                                                <a href="#" class="dropdown-item delete"><i class="fa fa-trash"></i> Delete <!-- <input  type="submit" class="dropdown-item delete" name="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');"/> --> </a>
                                            <?php } } } ?>

                                            <a href="#" class="dropdown-item print"><i class="fa fa-print"></i> Print</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-left: 0px!important;">
                            <div class="container-fluid p-t-20 container-fixed-lg bg-white">
                                <div class="card card-transparent">
                                    <div class="a">
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default form-group-default-select2">
                                                    <label>Owner </label>
                                                    <select id="owner_name_id" name="owner_name" class="form-control full-width" data-error="#err_owner_name" data-placeholder="Select Owner" data-init-plugin="select2">
                                                     
                                                        <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                            <option value="<?php echo $contact[$k]->c_id; ?>" <?php if(isset($bankdetail[0]->b_ownerid)) { if($contact[$k]->c_id==$bankdetail[0]->b_ownerid) { echo 'selected'; } } ?>><?php echo $contact[$k]->contact_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div id="err_owner_name"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Reg Address</label>
                                                    <input type="text" class="form-control" name="registered_address" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->registered_address; } ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Reg Phone</label>
                                                    <input type="text" class="form-control" name="registered_phone"  value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->registered_phone; } ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Reg Email </label>
                                                    <input type="text" class="form-control" name="registered_email" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->registered_email; } ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="a">
                                        <p class=""><b>Bank Details<b></p>
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Bank Name</label>
                                                    <input type="text" class="form-control" name="bank_name" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_name; } ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Bank Branch  </label>
                                                    <input type="text" class="form-control" name="bank_branch"  value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_branch; } ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Bank Address</label>
                                                    <input type="text" class="form-control" name="bank_address"  value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_address; } ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default ">
                                                    <label>Bank Landmark </label>
                                                    <input type="text" class="form-control" name="bank_landmark"  value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_landmark; } ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default ">
                                                    <label>Bank City </label>
                                                    <input type="hidden" name="bank_city_id" id="bank_add_city_id" /> 
                                                    <input type="text" class="form-control autocompleteCity" name="bank_city" id ="bank_add_city"  value="<?php if(isset($bankdetail)) { echo  $bankdetail[0]->b_city; } ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Bank Pincode </label>
                                                    <input type="text" class="form-control" name="bank_pincode" id ="bank_add_pincode" value="<?php if(isset($bankdetail)) { echo  $bankdetail[0]->b_pincode; } ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default ">
                                                    <label>Bank State </label>
                                                    <input type="hidden" name="bank_state_id" id="bank_add_state_id" />
                                                    <input type="text" class="form-control loadstatedropdown" name="bank_state" id ="bank_add_state"  value="<?php if(isset($bankdetail)) { echo  $bankdetail[0]->b_state; } ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default ">
                                                    <label>Bank Country </label>
                                                    <input type="hidden" name="bank_country_id" id="bank_add_country_id" />
                                                    <input type="text" class="form-control loadcountrydropdown" name="bank_country" id ="bank_add_country"  value="<?php if(isset($bankdetail)) { echo  $bankdetail[0]->b_country; } ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default form-group-default-select2">
                                                    <label class="">Account Type </label>
                                                    <select id="account_type" name="account_type" class="form-control full-width" data-error="#err_account_type"  data-init-plugin="select2">
                                                      
                                                        <option value="Savings" <?php if(isset($bankdetail)) { if($bankdetail[0]->b_accounttype == 'Savings') echo 'selected'; } ?>>Savings</option>
                                                        <option value="Current" <?php if(isset($bankdetail)) { if($bankdetail[0]->b_accounttype == 'Current') echo 'selected'; } ?>>Current</option>
                                                        <option value="Overdraft" <?php if(isset($bankdetail)) { if($bankdetail[0]->b_accounttype == 'Overdraft') echo 'selected'; } ?>>Overdraft</option>
                                                        <option value="Loan" <?php if(isset($bankdetail)) { if($bankdetail[0]->b_accounttype == 'Loan') echo 'selected'; } ?>>Loan</option>
                                                    </select>
                                                    <div id="err_account_type"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Account No.</label>
                                                    <input type="text" class="form-control" name="account_no"  value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_accountnumber; } ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>IFSC Code </label>
                                                    <input type="text" class="form-control" name="ifsc"  value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_ifsc; } ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default ">
                                                    <label>Customer ID</label>
                                                    <input type="text" class="form-control" name="customer_id"  value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_customerid; } ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Bank Phone No. </label>
                                                    <input type="text" class="form-control" name="phone_no"  value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_phone_number; } ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default form-group-default-select2">
                                                    <label>Relationship Manager</label>
                                                    <select id="relation_manager_id" name="relation_manager" class="form-control full-width" data-error="#err_relation_manager"  data-init-plugin="select2">
                                                      
                                                        <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                            <option value="<?php echo $contact[$k]->c_id; ?>" <?php if(isset($bankdetail[0]->b_relationshipmanager)) { if($contact[$k]->c_id==$bankdetail[0]->b_relationshipmanager) { echo 'selected'; } } ?>><?php echo $contact[$k]->contact_name; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div id="err_relation_manager"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Opening Balance </label>
                                                    <input type="text" class="form-control format_number" name="opening_balance"  value="<?php if(isset($bankdetail)) {echo format_money($bankdetail[0]->b_openingbalance,2); } ?>" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Balance Ref Date</label>
                                                    <input type="text" class="form-control datepicker" name="b_bal_ref_date" id="payment_date"  value="<?php if (isset($bankdetail)) {if($bankdetail[0]->b_bal_ref_date!='') echo date("d/m/Y",strtotime($bankdetail[0]->b_bal_ref_date));}?>" placeholder=""/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="a" id="bank_signatory">
                                        <p class=""><b>Authorised Signatory<b></p>
                                        <div id="banksign">
                                            <?php 
                                            $j=0;
                                            if(isset($bank_sign)) {
                                                for ($j=0; $j<count($bank_sign); $j++) { 
                                            ?>

                                            <div class="row clearfix" id="repeat_bank_sign_<?php echo $j+1; ?>">
                                                <div class="col-md-4">
                                                    <div class="form-group form-group-default form-group-default-select2">
                                                        <label class="">Authorised Signatory</label>
                                                        <select id="auth_name_<?php echo $j+1; ?>" name="auth_name[]" class="form-control auth_name full-width" data-error="#err_auth_name_<?php echo $j+1; ?>"  data-init-plugin="select2">
                                                         
                                                            <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                            <option value="<?php echo $contact[$k]->c_id; ?>" <?php if($contact[$k]->c_id==$bank_sign[$j]->ath_contactid) { echo 'selected'; } ?>><?php echo $contact[$k]->contact_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div id="err_auth_name_<?php echo $j+1; ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group form-group-default">
                                                        <label>Purpose of AS</label>
                                                        <input type="text" class="form-control" name="auth_purpose[]" value="<?php if(isset($bank_sign)) { echo $bank_sign[$j]->ath_purpose;  } ?>" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group form-group-default form-group-default-select2">
                                                        <label class="">Authorised Type</label>
                                                        <select id="auth_type_<?php echo $j+1; ?>" name="auth_type[]" class="form-control auth_type full-width" data-error="#err_auth_type_<?php echo $j+1; ?>"  data-init-plugin="select2">
                                                           
                                                            <option <?php if(isset($bank_sign)) { if($bank_sign[$j]->ath_type=='Sole') echo 'selected';  } ?>>Sole</option>
                                                            <option <?php if(isset($bank_sign)) { if($bank_sign[$j]->ath_type=='Joint') echo 'selected';  } ?>>Joint</option>
                                                        </select>
                                                        <div id="err_auth_type_<?php echo $j+1; ?>"></div>
                                                    </div>
                                                </div>
                                                <!-- <div class="delete delete_row" id="repeat_bank_sign_<?php //echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div> -->
                                            </div>

                                            <?php }} else { ?>

                                            <div class="row clearfix" id="repeat_bank_sign_<?php echo $j+1; ?>">
                                                <div class="col-md-4">
                                                    <div class="form-group form-group-default form-group-default-select2">
                                                        <label class="">Authorised Signatory</label>
                                                        <select id="auth_name_<?php echo $j+1; ?>" name="auth_name[]" class="form-control auth_name full-width" data-error="#err_auth_name_<?php echo $j+1; ?>" data-placeholder="Select Authorised Signatory" data-init-plugin="select2">
                                                           
                                                            <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                            <option value="<?php echo $contact[$k]->c_id; ?>"><?php echo $contact[$k]->contact_name; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div id="err_auth_name_<?php echo $j+1; ?>"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group form-group-default">
                                                        <label>Purpose of AS</label>
                                                        <input type="text" class="form-control" name="auth_purpose[]" value="" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group form-group-default form-group-default-select2">
                                                        <label class="">Authorised Type</label>
                                                        <select id="auth_type_<?php echo $j+1; ?>" name="auth_type[]" class="form-control auth_type full-width" data-error="#err_auth_type_<?php echo $j+1; ?>"  data-init-plugin="select2">
                                                            
                                                            <option>Sole</option>
                                                            <option>Joint</option>
                                                        </select>
                                                        <div id="err_auth_type_<?php echo $j+1; ?>"></div>
                                                    </div>
                                                </div>
                                                <!-- <div class="delete delete_row" id="repeat_bank_sign_<?php //echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div> -->
                                            </div>

                                            <?php } ?>
                                        </div>
                                        <!-- <div class="optionBox" id="bank_signatory_box">
                                            <div class="block" id="bank_signatory_block">
                                                <span class="add" id="add_bank_sign">+ Add Authorised Signatory</span>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="a  m-b-20">
                                        <div class="row clearfix">
                                            <div class="col-md-12">
                                                <div class="form-group form-group-default">
                                                    <label>Remark</label>
                                                    <input type="text" class="form-control" id="maker_remark" name="maker_remark" value="<?php if(isset($bankdetail)){ echo $bankdetail[0]->maker_remark;}?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    $("input").attr("readonly", true);
    $("select").attr("disabled", true);
    $("#txtstatus").attr("readonly", false);
</script>

</body>
</html>