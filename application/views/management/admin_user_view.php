<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Pecan Reams</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url(); ?>css/theme-blue.css"/>
        <link href="<?php echo base_url() . 'js/jquery-ui-1.11.2/jquery-ui.min.css'; ?>" rel="stylesheet" type="text/css" />
        <!-- EOF CSS INCLUDE -->                                      
    <style >
            /*.lable-box { padding:8px ; font-weight:500; background:#f9f9f9; width:100%;  } */
        /*  .control-label { padding:8px 0;  }*/
            /*.form-group { border:1px solid #f9f9f9; border-bottom:none; background:#fcfcfc; margin-bottom:1px;}*/
            .form-group { /*border-top:1px dotted #ddd; margin-bottom: 15px;*/ border-radius:0px; }
        </style>
            <style type="text/css">
            
.page-container .page-content .page-content-wrap {  margin:0px; width: auto!important; float: none;   }
.dataTables_filter { border-bottom:0!important; }
.heading-h2 { background:#eee; line-height: 25px; padding:7px 22px;   text-transform: uppercase; font-weight: 600; display: flex;  margin-top: 61px; /*padding-bottom: 0;*/      border-bottom: 1px solid #ddd;}
.heading-h2 a{  color: #444;     }
/*.top-band { background:#eee; padding: 5px; clear: both; display: inline-table; 
font-family: Montserrat-Black; font-weight: 100;float: left;     width: 45%;  
  border-bottom: 1px solid rgba(0,0,0,0.1);                   }*/
.nav-contacts {/* float: right; width: 55%;*/ }
.main-wrapper { background: #E0E0E7; padding: 0; margin: 0; }
.main-container {margin:0 12px; margin-bottom: 20px; } 
h2 { font-weight:100!important;  font-size:18px!important; padding:0; }
.box-shadow {margin: 20px 0; width:100%;  
background: #fff;

box-shadow: rgba(0, 0, 0, 0.2) 0px 6px 32px -4px; display: inline-block;}
.full-width  { padding: 10px; }
.page-overflow { overflow:auto; }
#approved{ font-weight: 800;/* border:1px solid #ccc; padding:2px 8px; border-radius:0px; background: #fff; */ color: #888;    }
.table thead tr th { padding:8px 5px!important; font-weight:600; }
b, strong { font-weight:500;}
.panel-body {padding: 0!important;}
.btn-container {  }
.btn-top { margin-top: 10px!important; }
.box-shadow-inside { padding:0px;     display: flex; }
.panel-footer { background: #f5f5f5!important; clear: both; margin-top:10px; }
.panel { margin: 0; border-radius: 0!important; box-shadow: none; border: 1px dotted #ddd!important }
.panel-heading {border-radius: 0; }

.form-control {
    display: block;
    width: 100%;
    padding: 10px 6px!important;
    height: 35px;
    font-size: 12px;
    line-height: 1.42857143;
    font-weight: 500;
    color: #0b385f;
    background-color: white;
    background-image: none;
    border: 1px solid #cccccc;
    border-radius: 0px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.03);
    -webkit-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
    -o-transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
    transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
}

.btn-primary { padding:6px 10px; }
.table-responsive {  min-height: .01%; overflow-x: auto;  margin: 15px;}
.remark-container {padding: 10px;}
.form-group:nth-child(even) { }
.form-group { padding: 10px 0; }
.panel-heading-bnt { margin: 10px!important; display: flex; }
.panel  span { margin:0!important; }
.btn-margin { margin-left: 5px!important; display: inline-block; }
.btn-top-margin { margin-top:-36px!important; margin-right: 15px; }
        </style>
    </head>
    <body>								
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
             <div class="page-content1 page-overflow wrapper wrapper__minify" style="height:auto!important;">
                
                <?php $this->load->view('templates/menus');?>
                   <div class="heading-h2"><a href="<?php echo base_url().'index.php/dashboard'; ?>" >  Dashboard  </a> &nbsp; &#10095; &nbsp; <a href="<?php echo base_url().'index.php/Assign/adminuser'; ?>" > User List </a>  &nbsp; &#10095; &nbsp; User View</div>

                    <div class="pull-right btn-top-margin">
                                  <!--   <h3 class="panel-title"><strong>Contact Details</strong></h3> -->
      
                                    <a class="btn-margin" href="<?php echo base_url()?>index.php/Assign/adminuser" > <span class="btn btn-danger pull-right btn-font"> Cancel </span>  </a>

                                    <a  class="btn-margin" href="<?php echo base_url().'index.php/Assign/editadminuser/'.$user[0]->c_id; ?>"><span class="btn btn-success pull-right btn-font"> Edit </span>  </a>
                             
                                </div>
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                
                    <div class="row   main-wrapper">
                           <div class="main-container">           
                            <div class="box-shadow">   
                              <div class="box-shadow-inside">
					
					 
						
                        <div class="col-md-12 full-width">
						<div class="panel panel-default">
							
                            <form id="form_admin_user_assign_details" role="form" class="form-horizontal" method="post" action="<?php if (isset($user)) echo base_url(). 'index.php/Assign/updateadminuser/' . $user[0]->c_id; else echo base_url().'index.php/Assign/saveadminuser'; ?>">
                              
								<div class="panel-body">
                                    <div class="form-group" style="border-top:1px dotted #f9f9f9;">
                                        <div class="col-md-12" >
                                            <label class="col-md-2 control-label"><strong>Full Name: </strong></label>
                                            <div class="col-md-10">
                                                <label class="control-label" style="text-align:left;">  <?php if(isset($user)) echo $user[0]->c_name . ' ' . $user[0]->c_middle_name . ' ' . $user[0]->c_last_name;?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label"><strong>Email: </strong></label>
                                            <div class="col-md-10">
                                                <label class="control-label" style="text-align:left;"> <?php if(isset($user)) echo $user[0]->c_emailid1;?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label"><strong>Mobile No.: </strong></label>
                                            <div class="col-md-10">
                                                <label class="control-label" style="text-align:left;"> <?php if(isset($user)) echo $user[0]->c_mobile1;?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label"><strong>Status: </strong></label>
                                            <div class="col-md-10">
                                                <label class="control-label" style="text-align:left;"> <?php if(isset($user)){ if($user[0]->c_status=="Approved") echo "Active"; else echo "InActive";}?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="col-md-2 control-label"><strong>Remarks: </strong></label>
                                            <div class="col-md-10" >
                                                <label class="control-label" style="text-align:justify;"> <?php if(isset($user)) echo $user[0]->txn_remarks;?></label>
                                            </div>
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
                <!-- END PAGE CONTENT WRAPPER -->
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
						
        <?php $this->load->view('templates/footer');?>

		<script type="text/javascript">
      //       var jvalidate = $("#jvalidate").validate({
      //           ignore: [],
      //           rules: {                                            
      //                   group_name: {
      //                           required: true
      //                   },
						// status: {
      //                           required: true
      //                   },
						// contact: {
      //                           required: true
      //                   },
						// designation: {
      //                           required: true
      //                   }
      //               }                                        
      //           });
			$('#reset').click(function(){
				$('#jvalidate')[0].reset();
			 });
        </script>

        <script>
            $(function() {
                //autocomplete
                $(".auto_client").autocomplete({

                        source: "<?php echo base_url() . 'index.php/owners/loadcontacts';?>",
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
        </script>
    <!-- END SCRIPTS -->      
    </body>
</html>