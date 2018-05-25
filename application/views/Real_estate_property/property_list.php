<!DOCTYPE html>
<html>
<head>
    <?php  $this->load->view('templates/header.php');?>

    <link href="assets/plugins/datatables/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" />

     <link href="assets/css/prop_list.css" rel="stylesheet" />

    <style>
        <?php// if($maker_checker!='yes') { ?>
            // .approved {
                // display: none !important;
            // }
            // .pending {
                // display: none !important;
            // }
            // .rejected {
                // display: none !important;
            // }
        <?php //} ?>
    </style>
</head>
<body class="fixed-header">
<?php  $this->load->view('templates/sidebar.php');?>
<div class="page-container ">
<?php  $this->load->view('templates/main_header.php');?>
<div class="page-content-wrapper">
    <div class="content ">
        <div class=" container-fluid container-fixed-lg">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="#">Property List</a></li>
            </ol>

            <div id="rootwizard">
                <ul class="nav nav-tabs nav-tabs-linetriangle nav-tabs-separator nav-stack-sm" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item all">
                        <a class=""  href="index.php/purchase/checkstatus/All">All()</a>
                    </li>
                    <li class="nav-item approved">
                        <a class=""  href="index.php/purchase/checkstatus/Approved">Approved()</a>
                    </li>
                    <li class="nav-item pending">
                        <a class="" href="index.php/purchase/checkstatus/Pending">Pending()</a>
                    </li>
                    <li class="nav-item rejected">
                        <a class="" href="index.php/purchase/checkstatus/Rejected">Rejected()</a>
                    </li>
                    <li class="nav-item inprocess">
                        <a class=""  href="index.php/purchase/checkstatus/InProcess">Draft()</a>
                    </li>
                </ul>
                <br>
                <div class="tab-content"style="background:none;">
                    <div class="tab-pane sm-no-padding active slide-left" id="tab1">
                        <div class="row" >
                            <div class="col-md-12">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="all">
                                        <div id="myDIV">
                                            <button class="btn1 active1 grid_btn" id="grid_btn_1"><i class="fa fa-th" aria-hidden="true"></i></button>
                                            <button class="btn1 list_btn" id="list_btn_1"><i class="fa fa-list" aria-hidden="true"></i></button>

                                            <!--<a href="index.php/sale"><button class="btn btn-default pull-right m-r-10" type="submit"> <span>Sold List</span></button></a>
											<a href="index.php/sale/addnew"><button class="btn btn-default pull-right  m-r-10" type="submit"><i class="fa fa-minus tab-icon"></i> <span>Sell</span></button></a>-->
											<a href="property_details.php"><button class="btn btn-default pull-right  m-r-10" type="submit"><i class="fa fa-plus tab-icon"></i> <span>Add Property</span></button></a>
                                        </div>
                                        <br>
                                      
                                        <div class="row grid">
                                           
                                            <div class=" col-md-6">
                                                <div class="markup">
                                                    <div class="card card-transparent container-fixed-lg bg-white " style="background:#fff;">
                                                        <div class="row">
                                                            <div class=" col-md-4">
                                                                <img src="" alt="Paris" class="prop_img m-t-20 m-l-20" style="width:180px"onerror=" this.src='assets/img/demo/preview.jpg'">
                                                            </div>
                                                            <div class=" col-md-8">
                                                                <div class="card-header ">
																   <div class="building_name"><b></b></div>
                                                                    <div class="owner_name"><H4 class="m-t-0 m-b-0"></H4></div>
                                                                </div>
                                                                <div class="card-block">
                                                                    <p class=" flat_info m-t-0 m-b-0"></p>
																    <p class="avaibility m-t-0 m-b-0"></p>
                                                                    <div class="address"><i class="fa fa-map-marker"></i> </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row" style="padding-left:15px;padding-right:15px;">
                                                            <div class="col-md-3 rent">
                                                                 <a href=""><i style="font-size:22px;" class="fa fa-group"></i><br>
                                                                Tenants
																	</a>
                                                            </div>
                                                            <div class=" col-md-3 leases">
																 <a href="">
                                                                <i style="font-size:22px;" class="fa fa-inr "></i><br>
                                                                Accounting
																	</a>
                                                            </div>
                                                       
                                                            <div class=" col-md-3 leases" style="border-left: 2px solid #edf0f5;">
															 <a href="">
                                                                <i style="font-size:22px;" class="fa fa-file-text-o"></i><br>
                                                                Maintenance
																</a>
                                                            </div>
                                                            <div class=" col-md-3 leases" style="border-left: 2px solid #edf0f5;">
                                                                <a href="">
                                                                    <i style="font-size:22px;" class="fa fa-file-text-o"></i><br>
                                                                    Sub Property
                                                                </a>
                                                            </div>
                                                        </div> 
                                                        <div class="col-md-12">
                                                            <a href="property_view.php" class=" pull-right invoice p-b-5     p-t-5" style="color:#5cb85c;">View <i class="fa fa-angle-right tab-icon"></i> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                        </div>
                                        <div class="row list">
                                         
                                            <div class=" col-md-12">
                                                <div class="card card-transparent container-fixed-lg bg-white " style="background:#fff;">
                                                    <div class="row">
                                                        <img src="" alt="Paris" class="prop_img" style="max-width:100%;max-height:100%;height:100px; width:100px;border:none;padding: 8px;" onerror=" this.src='assets/img/demo/preview.jpg'">
                                                        <div class="info pull-left p-l-10" style="margin-top: 20px;text-align:left;width:35%">
															<div class="building_name"></div>
                                                            <div class="owner_name"><H4 class="m-t-0 m-b-0"></H4></div>
                                                         
                                                            <div class="address"><i class="fa fa-map-marker"></i>  </div>
                                                        </div>
                                                        <p class=" flat_info m-t-0 m-b-0 pull-left" style="margin-top: 45px;padding-left: 10px;width: 18%;"></p>
                                                     
														<p class="avaibility m-t-0 m-b-0 pull-left" style="margin-top: 45px;padding-left: 10px;"></p>
														
                                                        <div class="prop_btns">
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 15px;">
                                                                <a href="" data-toggle="tooltip" data-placement="bottom" title="Tenants"><i style="font-size:22px;" class="fa fa-group"></i></a>
                                                            </div>
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 15px;">
                                                                <a href="" data-toggle="tooltip" data-placement="bottom" title="Accounting"><i style="font-size:22px;" class="fa fa-inr"></i></a>
                                                            </div>
                                                           
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 15px;">
                                                                <a href="" data-toggle="tooltip" data-placement="bottom" title="Maintenance"><i style="font-size:22px;" class="fa fa-file-text-o"></i></a>
                                                            </div>
                                                            <div class="pull-left" style="margin-top: 40px;padding-left: 15px;">
                                                                <a href="" data-toggle="tooltip" data-placement="bottom" title="Sub Property"><i style="font-size:22px;" class="fa fa-building-o"></i></a>
                                                            </div>
                                                        </div>
                                                        <a href="property_view.php" class=" pull-right invoice" style="color:#5cb85c;margin-top: 37px;padding-left: 20px;">View <i class="   fa fa-angle-right tab-icon"></i> </a>
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
            </div>
        </div>
    </div>

    <?php  $this->load->view('templates/footer.php');?>
</div>
</div>

<?php  $this->load->view ('templates/script.php');?>

<script type="text/javascript" src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/buttons.html5.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/export.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/jszip.min.js"></script>

<script>
    $(document).ready(function() {
        $('.list').hide();
        $('.grid_btn').on('click', function () {
            $('.grid').show();
            $('.list').hide();
            set_active_button($(this), 'list_btn');
        });
        $('.list_btn').on('click', function () {
            $('.grid').hide();
            $('.list').show();
            set_active_button($(this), 'grid_btn');
        });
    });
    var set_active_button = function(elem, btn){
        var id = elem.attr('id');
        var index = id.substring(id.lastIndexOf('_'));
        elem.addClass(' active1');
        $('#'+btn+index).removeClass('active1')
    }
</script>
</body>
</html>