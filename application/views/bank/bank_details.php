<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>
    <style type="text/css">
        .a
        {
        border-bottom: 2px solid #edf0f5;
        margin-bottom: 25px;
        padding-bottom: 25px;
        }
        #image-preview {
        min-width: auto;
        min-height: 300px;
        width:100%;
        height:auto;
        position: relative;
        overflow: hidden;
        background: url("assets/img/demo/preview.jpg") ;
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
        #image-label 
        {
        color:white;
        padding-left:6px;

        }
        #image-label_field
        {
        background: transparent -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(75%, rgba(0,0,0,0.8))) repeat scroll 0 0;


        }
        #image-label_field:hover
        {
        background: transparent linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.8) 75%) repeat scroll 0 0;
        }
        .add
        {
        color:#41a541;
        cursor:default;
        font-size:14px;
        font-weight:500;
        }
        .remove
        {
        color:#d63b3b;
        text-align:right;
        cursor:default;
        margin-bottom: 10px;
        font-size:14px;
        font-weight:500;
        }
        .block1
        {
        padding: 20px 20px;
        border: 2px solid #edf0f5;
        border-radius: 7px;
        background: #f6f9fc;
        margin-top: 10px;
        margin-bottom: 10px;
        }

        .delete
        {
        color:#d63b3b;
        text-align:left;
        vertical-align:center;
        cursor:default;
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
        .attachments
        {
        fon-size:20px!important;
        font-weight:600;
        padding-left:15px;
        border-left: solid 2px #27a9e0;
        }
    </style>
</head>
<body class="fixed-header ">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>
<div class="page-content-wrapper ">
<div class="content">
    <form id="form_bank" role="form"  method="post" action="<?php if(isset($bankdetail)) { echo base_url().'index.php/bank/updatebank/'.$b_id; } else {echo base_url().'index.php/bank/savebank'; }?>">
    <div class="container-fluid container-fixed-lg">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url().'index.php/dashboard'; ?>" > Dashboard</a></li>
            <li class="breadcrumb-item "><a href="<?php echo base_url().'index.php/bank'; ?>" > Bank Details List </a></li>
            <?php if(isset($bankdetail)){ ?> <li class="breadcrumb-item"><a href="<?php if (isset($b_id)) echo base_url().'index.php/bank/viewbank/'.$b_id; ?>">BANK VIEW</a></li><?php } ?>
            <li class="breadcrumb-item active"> BANK DETAILS</li>
			
			         
				  
        </ol>
        <div class="row">
            <div class="col-md-12">
                <div class="container-fluid p-t-20 container-fixed-lg bg-white">
                    <div class="card card-transparent">
                        <div class="a">
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label>Owner </label>
                                        <select id="owner_name_id" name="owner_name" class="form-control full-width" data-error="#err_owner_name" data-placeholder="Select " data-init-plugin="select2">
                                            <option value="">Select </option>
                                            <?php for ($k=0; $k < count($contact) ; $k++) { ?>
                                                <option value="<?php echo $contact[$k]->c_id; ?>" <?php if(isset($bankdetail[0]->b_ownerid)) { if($contact[$k]->c_id==$bankdetail[0]->b_ownerid) { echo 'selected'; } } ?>><?php echo $contact[$k]->contact_name; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div id="err_owner_name"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Reg Address</label>
                                        <input type="text" class="form-control" name="registered_address" placeholder="Enter here" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->registered_address; } ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Reg Phone</label>
                                        <input type="text" class="form-control" name="registered_phone" placeholder="Enter here" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->registered_phone; } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Reg Email </label>
                                        <input type="text" class="form-control" name="registered_email" placeholder="Enter here" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->registered_email; } ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="a">
                            <p class=""><b>Bank Details<b></p>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Bank Name</label>
                                        <input type="text" class="form-control" name="bank_name"placeholder="Enter here" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_name; } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Bank Branch  </label>
                                        <input type="text" class="form-control" name="bank_branch" placeholder="Enter here" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_branch; } ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Bank Address</label>
                                        <input type="text" class="form-control" name="bank_address" placeholder="Enter here" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_address; } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default ">
                                        <label>Bank Landmark </label>
                                        <input type="text" class="form-control" name="bank_landmark" placeholder="Enter here" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_landmark; } ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default ">
                                        <label>Bank City </label>
                                        <input type="hidden" name="bank_city_id" id="bank_add_city_id" /> 
                                        <input type="text" class="form-control autocompleteCity" name="bank_city" id ="bank_add_city" placeholder="Enter here" value="<?php if(isset($bankdetail)) { echo  $bankdetail[0]->b_city; } ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Bank Pincode </label>
                                        <input type="text" class="form-control" name="bank_pincode" id ="bank_add_pincode" placeholder="Enter here" value="<?php if(isset($bankdetail)) { echo  $bankdetail[0]->b_pincode; } ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default ">
                                        <label>Bank State </label>
                                        <input type="hidden" name="bank_state_id" id="bank_add_state_id" />
                                        <input type="text" class="form-control loadstatedropdown" name="bank_state" id ="bank_add_state" placeholder="Enter here" value="<?php if(isset($bankdetail)) { echo  $bankdetail[0]->b_state; } ?>"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default ">
                                        <label>Bank Country </label>
                                        <input type="hidden" name="bank_country_id" id="bank_add_country_id" />
                                        <input type="text" class="form-control loadcountrydropdown" name="bank_country" id ="bank_add_country" placeholder="Enter here" value="<?php if(isset($bankdetail)) { echo  $bankdetail[0]->b_country; } ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default form-group-default-select2 required">
                                        <label class="">Account Type </label>
                                        <select id="account_type" name="account_type" class="form-control full-width" data-error="#err_account_type" data-placeholder="Select " data-init-plugin="select2">
                                            <option value="">Select </option>
                                            <option value="Savings" <?php if(isset($bankdetail)) { if($bankdetail[0]->b_accounttype == 'Savings') echo 'selected'; } ?>>Savings</option>
                                            <option value="Current" <?php if(isset($bankdetail)) { if($bankdetail[0]->b_accounttype == 'Current') echo 'selected'; } ?>>Current</option>
                                            <option value="Overdraft" <?php if(isset($bankdetail)) { if($bankdetail[0]->b_accounttype == 'Overdraft') echo 'selected'; } ?>>Overdraft</option>
                                            <option value="Loan" <?php if(isset($bankdetail)) { if($bankdetail[0]->b_accounttype == 'Loan') echo 'selected'; } ?>>Loan</option>
                                        </select>
                                        <div id="err_account_type"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Account No.</label>
                                        <input type="text" class="form-control" name="account_no" placeholder="Enter here"value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_accountnumber; } ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>IFSC Code </label>
                                        <input type="text" class="form-control" name="ifsc" placeholder="Enter here" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_ifsc; } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default ">
                                        <label>Customer ID</label>
                                        <input type="text" class="form-control" name="customer_id" placeholder="Enter here" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_customerid; } ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Bank Phone No. </label>
                                        <input type="text" class="form-control" name="phone_no" placeholder="Enter here" value="<?php if(isset($bankdetail)) {echo $bankdetail[0]->b_phone_number; } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default form-group-default-select2">
                                        <label>Relationship Manager</label>
                                        <select id="relation_manager_id" name="relation_manager" class="form-control full-width" data-error="#err_relation_manager" " data-init-plugin="select2">
                                            <option value="">Select </option>
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
                                    <div class="form-group form-group-default required">
                                        <label>Opening Balance </label>
                                        <input type="text" class="form-control format_number" name="opening_balance" placeholder="Enter here" value="<?php if(isset($bankdetail)) {echo format_money($bankdetail[0]->b_openingbalance,2); } ?>" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default required">
                                        <label>Balance Ref Date</label>
                                        <input type="text" class="form-control datepicker" name="b_bal_ref_date" id="payment_date" placeholder="Enter here" value="<?php if (isset($bankdetail)) {if($bankdetail[0]->b_bal_ref_date!='') echo date("d/m/Y",strtotime($bankdetail[0]->b_bal_ref_date));}?>" placeholder=""/>
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
                                            <select id="auth_name_<?php echo $j+1; ?>" name="auth_name[]" class="form-control auth_name full-width" data-error="#err_auth_name_<?php echo $j+1; ?>" data-init-plugin="select2">
                                                <option value="">Select </option>
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
                                            <input type="text" class="form-control" name="auth_purpose[]" placeholder="Purpose of AS" value="<?php if(isset($bank_sign)) { echo $bank_sign[$j]->ath_purpose;  } ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Authorised Type</label>
                                            <select id="auth_type_<?php echo $j+1; ?>" name="auth_type[]" class="form-control auth_type full-width" data-error="#err_auth_type_<?php echo $j+1; ?>"  data-init-plugin="select2">
                                                <option value="">Select </option>
                                                <option <?php if(isset($bank_sign)) { if($bank_sign[$j]->ath_type=='Sole') echo 'selected';  } ?>>Sole</option>
                                                <option <?php if(isset($bank_sign)) { if($bank_sign[$j]->ath_type=='Joint') echo 'selected';  } ?>>Joint</option>
                                            </select>
                                            <div id="err_auth_type_<?php echo $j+1; ?>"></div>
                                        </div>
                                    </div>
                                    <div class="delete delete_row" id="repeat_bank_sign_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                </div>

                                <?php }} else { ?>

                                <div class="row clearfix" id="repeat_bank_sign_<?php echo $j+1; ?>">
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Authorised Signatory</label>
                                            <select id="auth_name_<?php echo $j+1; ?>" name="auth_name[]" class="form-control auth_name full-width" data-error="#err_auth_name_<?php echo $j+1; ?>" data-placeholder="Select " data-init-plugin="select2">
                                                <option value="">Select</option>
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
                                            <input type="text" class="form-control" name="auth_purpose[]" placeholder="Purpose of AS" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group form-group-default form-group-default-select2">
                                            <label class="">Authorised Type</label>
                                            <select id="auth_type_<?php echo $j+1; ?>" name="auth_type[]" class="form-control auth_type full-width" data-error="#err_auth_type_<?php echo $j+1; ?>" data-placeholder="Select " data-init-plugin="select2">
                                                <option value="">Select </option>
                                                <option>Sole</option>
                                                <option>Joint</option>
                                            </select>
                                            <div id="err_auth_type_<?php echo $j+1; ?>"></div>
                                        </div>
                                    </div>
                                    <div class="delete delete_row" id="repeat_bank_sign_<?php echo $j+1; ?>_delete"><i class="fa fa-trash" aria-hidden="true"></i></div>
                                </div>

                                <?php } ?>
                            </div>
                            <div class="optionBox" id="bank_signatory_box">
                                <div class="block" id="bank_signatory_block">
                                    <span class="add" id="add_bank_sign">+ Add Authorised Signatory</span>
                                </div>
                            </div>
                        </div>
                        <div class="a  m-b-20">
                            <div class="row clearfix">
                                <div class="col-md-12">
                                    <div class="form-group form-group-default required">
                                        <label>Remark</label>
                                        <input type="text" class="form-control" id="maker_remark" name="maker_remark" value="<?php if(isset($bankdetail)){ echo $bankdetail[0]->maker_remark;}?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-footer" style="padding-bottom: 60px;">
                            <input type="hidden" id="submitVal" value="1" />
                            <a href="<?php echo base_url(); ?>index.php/bank" class="btn btn-default-danger pull-left" >Cancel</a>
                            <input type="submit" class="btn btn-default pull-right submit-form" name="submit" value="<?php if($maker_checker=='yes') echo 'Submit For Approval'; else echo 'Submit'; ?>" style="margin-right: 10px;" />
                            <input formnovalidate="formnovalidate" type="submit" class="btn btn-default pull-right save-form m-r-10" name="submit" value="Save" style="<?php if($maker_checker!='yes' && isset($bankdetail)) echo 'display:none'; ?>" />
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

<script type="text/javascript">
    var BASE_URL="<?php echo base_url(); ?>";

    <?php
        $contact_details = '<option value="">Select</option>';
        if(isset($contact)) {
            for($i=0; $i<count($contact); $i++) {
                $contact_details = $contact_details . '<option value="'.$contact[$i]->c_id.'">'.str_replace("'","",$contact[$i]->contact_name).'</option>';
            }
        }
    ?>
    var contact_details = '<?php echo $contact_details; ?>';
</script>

<?php $this->load->view('templates/script');?>

<script type="text/javascript" src="<?php echo base_url(); ?>js/bank.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/validations.js"></script>

</body>
</html>