 

<link href="<?php echo base_url().'mobile-menu/vertical/demo.css'; ?>" rel="stylesheet">
<link href="<?php echo base_url().'mobile-menu/vertical/vertical-responsive-menu.min.css'; ?>" rel="stylesheet">
<link href="<?php echo base_url().'css/responsive.css'; ?>" rel="stylesheet">
<link href="<?php echo base_url().'css/logout/popModal.css'; ?>" rel="stylesheet">
<link href="<?php echo base_url().'css/logout/menu.css'; ?>" rel="stylesheet">
 <!--[if IE]>
  <link rel="stylesheet" type="text/css" href="all-ie-only.css" />
<![endif]-->
 <!--[if lt IE 9]>
<script src="dist/html5shiv.js"></script>
<![endif]-->

<style type="text/css">
  body {
    scrollbar-base-color: #222;
    scrollbar-3dlight-color: #222;
    scrollbar-highlight-color: #222;
    scrollbar-track-color: #3e3e42;
    scrollbar-arrow-color: #111;
    scrollbar-shadow-color: #222;
    scrollbar-dark-shadow-color: #222; 
    -ms-overflow-style: -ms-autohiding-scrollbar;  
  }
  .form-control { padding:6px!important;  }
  body{ overflow:initial; }
  .fonts {
    font-size:35px; 
    text-align: center;
    width: 60px;
    line-height: 48px;
  }
  .x-navigation {overflow-x: hidden;}
  .x-navigation li > a .fa, .x-navigation li > a .glyphicon  {font-size: 20px;}
  .left-menu {  }
  /*.left-menu li{ padding-left:25px!important; }*/
 
  .left-menu li .fa{ font-size: 16px!important; padding-right:15px; }
  .left-menu li .glyphicon { font-size: 16px!important; padding-right:15px;  }
  .left-menu li .glyphicon { font-size: 16px!important; }
  .left-menu li:hover{ background: #23303b!important;}
  .scroller .x-navigation ul li { display: inline-block!important; visibility: visible!important; }
  .x-navigation.x-navigation-horizontal { float:none!important; left: 0;  position: fixed; overflow:hidden; }
  .x-navigation { float: none!important }
  .menu-wrapper { top:61px;
    /* background-image: -webkit-linear-gradient(bottom, #008161 0%, #2F5F5B 23%, #343347 100%);
      background-image: linear-gradient(to top, #008161 0%, #2F5F5B 23%, #343347 100%);*/
    background-image: linear-gradient(to top, #05131f 0%, #13202c 23%, #33414e 100%);
  }
  .menu-wrapper ul { background: none!important }
  .menu { background: none!important }
   .menu 
   {
     max-height:800px!important;
   }
  #ng-toggle {
    position: fixed;
  }
  .menu-wrapper ul li a span {opacity: 1;}
  .menu-wrapper .menu--faq {
    position: absolute;  
    left: 0;     text-shadow: 0px 1px 1px #000;
    bottom: 0;  line-height: 50px;
    z-index: 99999;
    width: 240px; }
  .menu--faq  li { font-size: 1rem; }
  .gn-icon .icon-fontello:before {
    font-size: 20px;
    line-height: 50px;
    width: 50px;
  }
  .fa-sign-out {   }
  #edit{  display: inline-block; padding: 0 5px; cursor:pointer;    }
  .text-info { color:#fff!important; display: inline-block; line-height: 20px; }
  .grp_change{ display: none; }
  .menu-wrapper .scroller {
    position: absolute;
    overflow-y: scroll;
    width: 240px;
    height:80%;
  }

  .header-fixed-style {  width: 100%;  height: 61px; left:0;   position: fixed;  /*background: #33414e!important;*/ background:#245478!important;   z-index: 999; display:block;   }
  .logo-container { width:200px;  float:left; background:#fff; text-align:center; padding:6px 0;}
 
  .useremail-container {width:300px; float:left;}
  .useremail-container a { font-size:18px; color:#fff; padding:15px 10px; display: block;}
  .dropdown-selector { width:35%; float:right;   display:block; tex-align:right;}
  .dropdown-selector-left    { font-size:18px; color:#fff; padding:10px 19px;  display: block; float:right;     text-align: right;}
  .useremail-login { font-size:12px; color:#fff; display: block;}
  .useremail-login:hover{color:#fff; } 
  .logout-section { float:right; display:block;  }
  .logout-section a { color:#fff; font-size:25px;  padding:13px 15px;  display: block;  float:left; border-left:1px solid #0d3553;  }
  .logout-section a:hover { background:#0d3553!important; color:#fff;}

  ::-webkit-scrollbar {
    width: 0.5em;
    height: 0.5em;
  }
  ::-webkit-scrollbar-button:start:decrement,
  ::-webkit-scrollbar-button:end:increment  {
    display: none;
  }
  ::-webkit-scrollbar-track-piece  {
    background-color: #ccc;
    -webkit-border-radius: 6px;
  }
  ::-webkit-scrollbar-thumb:vertical {
    -webkit-border-radius: 6px;
    background: #072c48 url("<?php echo base_url().'img/scrollbar_thumb_bg.png';?>") no-repeat center;
  }
  ::-webkit-scrollbar-thumb:horizontal {
    -webkit-border-radius: 6px;
    background: #072c48 url("<?php echo base_url().'img/scrollbar_thumb_bg.png';?>") no-repeat center;
  } 
  ::-webkit-scrollbar-track, 
  ::-moz-scrollbar-track, 
  ::-o-scrollbar-track{
    box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    -moz-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    -o-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    border-radius: 10px;
    background-color: #F5F5F5;
  } 
  .vertical_nav .bottom-menu-fixed {
    /*bottom: 0!important;*/
    position: absolute;
    /* top: initial!important; */background:#245478!important;      border-top: 1px solid #0d3553;
    top:84.2%!important;
    width: 100%;
    margin: 0;
    padding: 0;
    list-style-type: none;
    /* max-height: 329px; */
    z-index: 0;
  }
  .toggle_menu {
    display: none;
  }
  @media only screen and (max-width: 991px){
    .toggle_menu {
      display: block;
      float: left;
      padding:16px 10px; 
      color: #fff; cursor:pointer;
    }
  }
  @media screen and (max-width:320px) {.vertical_nav .bottom-menu-fixed {  top: 79.2%!important;} }
  @media only screen and (min-width:321px) and (max-width:360px) {.vertical_nav .bottom-menu-fixed {  top: 82.2%!important;}  }
  .vertical_nav__minify .menu--subitens__opened span {
    cursor:default;
  }
</style>    



<div class="header-fixed-style"  >
  <!-- START X-NAVIGATION VERTICAL -->
  <div class="logo-container">  
    <a class="gn-icon-menu " href="<?php echo base_url().'index.php/dashboard/home'; ?>"  > 
      <!-- <img height="50" style=" "   src="<?php //echo base_url().'img/logo-icon.png';?>"   /> 
      <img   src="<?php //echo base_url().'img/pecan-logo.png';?>"  height="45" style="margin-left:10px;"  /> -->                

      <img height="50" style=" "   src="<?php echo base_url().'img/main-logo.png';?>"   />
    </a>  
    <button id="collapse_menu" class="collapse_menu">
      <i class="collapse_menu--icon  fa fa-fw"> </i>
    </button> 
  </div>
  <div class="toggle_menu"  id="toggleMenu">  <i class="fa fa-arrows-alt" aria-hidden="true"></i> </div>

  <!--<div class="useremail-container">
     <a class="useremail-login" href="" style=""><span class="xn-text"><?php //if (isset($userdata['username'])) {echo $userdata['username'];} ?> </span></a>
  </div> -->
  <div class="dropdown-selector">
    <div class="logout-section">
      <a class="fa-edit-btn " id="mbl-grp_change" href="javascript:void(0);"> <i class="fa fa-edit" aria-hidden="true"></i><span class="xn-text"> </span></a>
    <a class="dropdown-toggle" id="toggleMenu1"  data-toggle="dropdown" href="#"><i class="fa fa-cog" aria-hidden="true"></i><span class="xn-text"> </span></a>
        <ul class="dropdown-menu menus "  id="menu">
          <li style="<?php if ($userdata['groupid']=='0') echo 'display: none;';?>"><a href="<?php echo base_url().'index.php/dashboard/home'; ?>">Dashboard</a></li>
          <li style="<?php if ($userdata['groupid']=='0') echo 'display: none;';?>"><a href="<?php echo base_url().'index.php/profile'; ?>">User Profile</a></li>
          <li <?php if ($User==0) echo 'style="display: none;"'; ?>><a href="<?php if ($userdata['groupid']!='0') echo base_url().'index.php/assign'; else echo base_url().'index.php/assign/adminuser'; ?>">User</a></li>
          <li <?php if ($UserRoles==0 || $userdata['maker_checker']=='no') echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/manage'; ?>">User Roles</a></li>
          <li><a href="#">Help</a></li>
          <li><a href="#">Support</a></li>
          <!-- <li>
            <a href="<?php //echo base_url().'index.php/login/assure'; ?>" target="_blank">Test</a>
          </li> -->
          <li style="<?php if ($userdata['groupid']=='0') echo 'display: none;';?>">
            <!-- <a class=" " id="confirmModal_ex2"  data-confirmmodal-bind="#confirm_content" data-topoffset="0" href="#"> 
              Change Password<span class="xn-text"> </span>
            </a> -->
            <!-- <a class="" data-box="#message-box-success" href="#"> 
              Change Password<span class="xn-text"> </span>
            </a> -->

            <a class="mb-control" data-box="#message-box-success" href="#"> 
              Change Password<span class="xn-text"> </span>
            </a>
          </li>
        </ul>
   
    
      <a href="#"  id="confirmModal_ex2" class="  top-sign" data-confirmmodal-bind="#confirm_content1"><span class="fa fa-sign-out"></span></a> 

  
    </div>
    <div class="dropdown-selector-left">
      <span class="xn-text  text-info">
        <?php //if (isset($userdata['groupname'])) {if ($userdata['groupid']!='0') echo $userdata['groupname']; else echo 'Software Developer';} else echo 'Software Developer';?>
        <?php echo $userdata['loginname']; ?>
      </span>
      <select class="form-control grp_change" name="group" style="height:40px; font-weight:bolder; font-size:14px;">
        <?php if(isset($groups)) { for ($i=0; $i < count($groups) ; $i++) { ?>
        <option value="<?php echo $groups[$i]->gu_gid; ?>" <?php if($groups[$i]->gu_gid==$this->session->userdata('groupid')) echo 'selected'; ?>><?php echo $groups[$i]->group_name; ?></option>
        <?php }} ?>
      </select>
      
      <?php if(isset($groups)) {
        if(count($groups)>1) { 
          echo '<span class="fa fa-edit edit-show" id="edit" style="display:none;"></span>';
        } 
      } ?>

      <span class="useremail-login" href="" style="">
        <span class="xn-text"><?php if (isset($userdata['username'])) {echo $userdata['username'];} ?></span>
      </span>
    </div>
  </div>
</div>

<!--<button type="button" id="toggleMenu" class="toggle_menu">
      <i class="fa fa-bars"></i>
     <nav class="vertical_nav vertical_nav__minify">
    </button>-->
  <nav class="vertical_nav vertical_nav__minify">
 
    <ul id="js-menu" class="menu mCustomScrollbar" style="">
   <!-- <li class="menu--item">
        <a  class="menu--link" href="<?php //echo base_url().'index.php/dashboard/home'; ?>">  
         <i class="menu--icon  fa fa-fw fa-home"></i>
        <span class="menu--label">Home</span>
       </a>
    </li> -->
   <li class="menu--item  menu--item__has_sub_menu"  style="background:#0d3553!important;">

        <label class="menu--link" title="">
          <i class="menu--icon  fa fa-fw fa-tachometer"></i>
          <span class="menu--label">REAMS</span>
        </label>
   <?php if ($Groups==1) { ?>
   
    <li class="menu--item" <?php if ($Groups==0) echo 'style="display: none;"'; ?>>
      <a href="<?php echo base_url().'index.php/groups'; ?>" class="menu--link" title="">
         <i class="menu--icon  fa fa-fw fa-group"></i> 
         <span class="menu--label">Group</span>
      </a>
    </li> <?php } else { ?>
   

    <li class="menu--item">
        <a  class="menu--link" href="<?php echo base_url().'index.php/dashboard'; ?>">  
         <i class="menu--icon  fa fa-fw fa-tachometer"></i>
        <span class="menu--label">Dashboard</span>
       </a>
    </li>
   
    <li class="menu--item  menu--item__has_sub_menu" <?php if ($Association==0) echo 'style="display: none;"'; ?>>           
            <label class="menu--link" title="">
          <i class="menu--icon  fa fa-fw fa-indent"></i>
          <span class="menu--label">Masters</span>
        </label>   
  <ul class="sub_menu">
          <li class="sub_menu--item" <?php if ($Contacts==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/contacts'; ?>"   class="sub_menu--link">Contact</a>
          </li>
          <li class="sub_menu--item" <?php if ($Owner==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/owners'; ?>" class="sub_menu--link">Owner</a>
          </li>
          <li class="sub_menu--item" <?php if ($Bank==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/bank'; ?>" class="sub_menu--link">Bank</a>
          </li>
       <li class="sub_menu--item" <?php //if ($Contact_type==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/Contact_type'; ?>" class="sub_menu--link">Contact Type</a>
          </li>
        <li class="sub_menu--item" <?php //if ($Expense_category==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/Expense_category'; ?>" class="sub_menu--link">Expense Category</a>
          </li>
      <li class="sub_menu--item" <?php //if ($City_master==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/City_master'; ?>" class="sub_menu--link">City Master</a>
          </li> 
     
        </ul> 
   
        </li>
      <?php } ?>
   
   
   
      <li class="menu--item  menu--item__has_sub_menu" <?php if ($Properties==0) echo 'style="display: none;"'; ?>>

        <label class="menu--link" title="">
          <i class="menu--icon  fa fa-fw fa-rupee"></i>
          <span class="menu--label">Transaction</span>
        </label>

        <ul class="sub_menu">
          <li class="sub_menu--item"  <?php if ($Purchase==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/purchase'; ?>"   class="sub_menu--link">Purchase</a>
          </li>
           <li class="sub_menu--item"  <?php if ($Allocation==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/allocation'; ?>"   class="sub_menu--link"> Sub-Property</a>
          </li>
          <li class="sub_menu--item"  <?php if ($Sale==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/sale'; ?>"   class="sub_menu--link">Sale</a>
          </li>
      <li class="sub_menu--item"  <?php if ($Rent==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/rent'; ?>"   class="sub_menu--link">Rent</a>
          </li>
        <li class="sub_menu--item"  <?php if ($BankEntry==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/bank_entry'; ?>"   class="sub_menu--link">Bank Entry</a>
          </li>
        <li class="sub_menu--item"  <?php if ($Loan==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/loan'; ?>"   class="sub_menu--link">Loan</a>
          </li>
        <li class="sub_menu--item"  <?php if ($Loan==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/loan_disbursement'; ?>"   class="sub_menu--link">Loan Disbursement</a>
          </li>
      
        <li class="sub_menu--item" <?php if ($Expense==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/expense'; ?>"   class="sub_menu--link">Expense</a>
          </li>
      
       <li class="sub_menu--item" <?php if ($Maintenance==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/maintenance'; ?>"   class="sub_menu--link">Maintenance</a>
          </li>
      
       <li class="sub_menu--item" <?php if ($Payments==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/payment/list1'; ?>"   class="sub_menu--link">Payment</a>
          </li>
      
        </ul>
      </li>
    

      <li class="menu--item"  <?php if ($Task==0) echo 'style="display: none;"'; ?>>
        <a href="<?php echo base_url().'index.php/task'; ?>" class="menu--link" title="">
          <i class="menu--icon  fa fa-fw fa-pencil-square-o"></i>
          <span class="menu--label">Task</span>
        </a>
      </li>
    
      <li class="menu--item  menu--item__has_sub_menu" <?php if ($Documents==0) echo 'style="display: none;"'; ?>>

        <label class="menu--link" title="">
          <i class="menu--icon  fa fa-fw fa-file-text"></i>
          <span class="menu--label">Document</span>
        </label>

        <ul class="sub_menu">
          <li class="sub_menu--item" <?php if ($DocumentMaster==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/documents'; ?>" class="sub_menu--link">Document Master</a>
          </li>
          <li class="sub_menu--item" <?php if ($DocumentTypeMaster==0) echo 'style="display: none;"'; ?>>
            <a href="<?php echo base_url().'index.php/document_type_master'; ?>" class="sub_menu--link">Document Type Master</a>
          </li>           
        </ul>
      </li>
       
        <!-- <li class="menu--item menu--item__has_sub_menu" <?php //if ($Settings==0) echo 'style="display: none;"'; ?>>
                        <label class="menu--link" title="">
          <i class="menu--icon  fa fa-fw fa-gear"></i>
          <span class="menu--label">Users</span>
        </label>
                        <ul class="sub_menu">
                            <li class="sub_menu--item" <?php //if ($User==0) echo 'style="display: none;"'; ?>>
        <a href="<?php //if ($userdata['groupid']!='0') echo base_url().'index.php/assign'; else echo base_url().'index.php/assign/adminuser'; ?>" class="sub_menu--link"> User</a>
       </li>
                            <li class="sub_menu--item" <?php //if ($UserRoles==0) echo 'style="display: none;"'; ?>>
        <a href="<?php //echo base_url().'index.php/manage'; ?>" class="sub_menu--link"> User Roles</a>
       </li>
                        </ul>
                    </li> -->
   

      <li class="menu--item" <?php if ($Reports==0) echo 'style="display: none;"'; ?>>
        <a href="<?php if ($userdata['groupid']=='0') echo  base_url().'index.php/reports'; else echo  base_url().'index.php/reports/view_reports'; ?>" class="menu--link" title="">
          <i class="menu--icon  fa fa-fw fa-bar-chart-o"></i>
          <span class="menu--label">Report</span>
        </a>
      </li>
    
                       
    <li class="menu--item" <?php if ($Indexation==0) echo 'style="display: none;"'; ?>>
        <a href="<?php echo base_url();?>index.php/Indexation" class="menu--link" title="">
          <i class="menu--icon  fa fa-fw fa-signal"></i>
          <span class="menu--label">Indexation</span>
        </a>
      </li>
    
    
     <li class="menu--item"  <?php if ($Tax==0) echo 'style="display: none;"'; ?>>
        <a href="<?php echo base_url();?>index.php/tax_master" class="menu--link" title="">
          <i class="menu--icon  fa fa-fw fa-gavel"></i>
          <span class="menu--label">Tax</span>
        </a>
      </li>   
   
    
     <li class="menu--item" <?php if ($Valuation==0) echo 'style="display: none;"'; ?>>
        <a href="<?php echo base_url();?>index.php/property_projection" class="menu--link" title="">
          <i class="menu--icon  fa fa-fw fa-money"></i>
          <span class="menu--label">Valuation</span>
        </a>
      </li>
  
      <li class="menu--item" <?php if ($Log==0) echo 'style="display: none;"'; ?>>
        <a href="<?php echo base_url();?>index.php/Log" class="menu--link" title="">
          <i class="menu--icon  fa fa-fw fa-pencil-square-o"></i>
          <span class="menu--label">Log</span>
        </a>
      </li>
      </li>
    
           <li class="menu--item" style="background:#0d3553!important;border-bottom:1px solid #245478">
        <a  class="menu--link" href="<?php echo base_url().'index.php/login/idata'; ?>">  
         <i class="menu--icon  fa fa-fw fa-tachometer"></i>
        <span class="menu--label">iDATA</span>
       </a>
    </li>
   
   
   <li class="menu--item" style="background:#0d3553!important">
        <a  class="menu--link" href="<?php echo base_url().'index.php/login/assure'; ?>">  
         <i class="menu--icon  fa fa-fw fa-tachometer"></i>
        <span class="menu--label">Assure</span>
       </a>
    </li>
   

    </ul>
   
   
   
   
   
  <!-- <ul id=" " class="menu bottom-menu bottom-menu-fixed" >
    <li class="menu--item">
        <a href="javascript:void(0);" class="menu--link" title="">
          <i class="menu--icon  fa fa-fw fa-question-circle"></i>
          <span class="menu--label">Help</span>
        </a>
      </li>
    
      <li class="menu--item">
        <a href="javascript:void(0);" class="menu--link" title="">
          <i class="menu--icon  fa fa-fw fa-bullhorn"></i>
          <span class="menu--label">Support</span>
        </a>
      </li>
     </ul> -->
  </nav>
  
  


   
     
       
  
<div class="wrapperrrrr" style="display:none;" >

 <i id="ng-toggle">
 
</i> 
<nav id="menu" class="menu-wrapper" style="border-top: none;">

    <div class="scroller" id="style-1">
      <div class="scrollbar">
    <div class="force-overflow">
   <ul class="menu x-navigation">
       <!--      <li class="active" style="background:#33414e; border-top:none;">
         <a class="gn-icon-menu" href="<?php //if ($Groups==1) echo base_url().'index.php/groups'; else echo base_url().'index.php/dashboard'; ?>">
             
                    <h2><img src="<?php //echo base_url().'img/logo-1.png';?>" style="height: 32px; margin-left: 10px; margin-top: -5px;" /></h2>
                </a>
            </li> -->

             <li class="menu--item  menu--item__has_sub_menu" style="background:#33414e!important;" >

        <label class="menu--link" title="">
          <i class="menu--icon  fa fa-fw fa-tachometer"></i>
          <span class="menu--label">REAMS</span>
        </label>
            <?php if ($Groups==1) { ?>
                          <a href="#" class=""></a>

                            

                        <li <?php if ($Groups==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/groups'; ?>">  <i class="gn-icon gn-icon-rent">   <div class="fonts fa fa-group"></div>  </i>
                                 <span>Group</span></a></li>

                    <?php } else { ?>
                        <li ><a href="<?php echo base_url().'index.php/dashboard'; ?>">  <i class="gn-icon gn-icon-rent">   <div class="fonts fa fa-tachometer"></div>  </i>
                                 <span>Dashboard</span></a></li>
                 
                        <li class="" <?php if ($Association==0) echo 'style="display: none;"'; ?>>
                            <a href="#"> 
                            <i class="gn-icon gn-icon-rent">   <div class="fonts fa fa-indent"></div>  </i>
                                 <span>Masters</span></a>
                  
                            <ul class="animated slideIn left-menu ">
                                <li <?php if ($Contacts==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/contacts'; ?>"><span class="fa fa-user"></span> Contact</a></li>
                                <li <?php if ($Owner==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/owners'; ?>"><span class="glyphicon glyphicon-briefcase"></span> Owner</a></li>
                                <li <?php if ($Bank==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/bank'; ?>"><span class="fa fa-bank"></span> Bank</a></li>
                                <li <?php //if ($Contact_type==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/Contact_type'; ?>"><span class="fa fa-crop"></span> Contact Type</a></li>
                                <li <?php //if ($Expense_category==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/Expense_category'; ?>"><span class="fa fa-leaf"></span> Expense Category</a></li>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="" <?php if ($Properties==0) echo 'style="display: none;"'; ?>>
                        <a href="#"><i class="gn-icon gn-icon-tenant"><div class="fonts fa fa-rupee"></div>   </i><span>Transaction</span></a>
                        <ul class="animated zoomIn  left-menu">
                            <li <?php if ($Purchase==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/purchase'; ?>"><span class="fa fa-key"></span> Purchase</a></li>
                            <li <?php if ($Allocation==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/allocation'; ?>"><span class="fa fa-hdd-o"></span> Sub-Property</a></li>
                            <li <?php if ($Sale==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/sale'; ?>"><span class="glyphicon glyphicon-chevron-up"></span> Sale</a></li>
                            <li <?php if ($Rent==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/rent'; ?>"><span class="fa fa-road"></span> Rent</a></li>
                            <li <?php if ($BankEntry==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/bank_entry'; ?>"><span class="fa fa-rss"></span> Bank Entry</a></li>
                            <li <?php if ($Loan==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/loan'; ?>"><span class="fa fa-money"></span> Loan</a></li>
                            <li <?php if ($Loan==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/loan_disbursement'; ?>"><span class="fa fa-money"></span> Loan Disbursement</a></li>
                            <li <?php if ($Expense==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/expense'; ?>"><span class="fa fa-credit-card"></span> Expense</a></li>
                            <li <?php if ($Maintenance==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/maintenance'; ?>"><span class="fa fa-wrench"></span> Maintenance</a></li>
                            <li <?php if ($Payments==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/payment/list1'; ?>"><span class="fa fa-wrench"></span> Payment</a></li>
                        </ul>
                    </li>
                    
                    <li class="" <?php if ($Task==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url().'index.php/task'; ?>"> <i class="gn-icon gn-icon-prof"><div class="fonts fa fa-pencil-square-o"></div> </i><span>Task</span></a>                        
                       
                    </li>                    
                  
                    <li class="" <?php if ($Documents==0) echo 'style="display: none;"'; ?>>
                        <a href="#"> <i class="gn-icon gn-icon-prof"><div class="fonts fa fa-file-text"></div> </i><span>Document</span></a>
                        <ul class="animated zoomIn">
                            <li <?php if ($DocumentMaster==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/documents'; ?>"><span class="fa fa-cogs"></span> Document Master</a></li>
                            <li <?php if ($DocumentTypeMaster==0) echo 'style="display: none;"'; ?>><a href="<?php echo base_url().'index.php/document_type_master'; ?>"><span class="fa fa-square-o"></span> Document Type Master</a></li>
                        </ul>

                    </li>

                    <!-- <li class="" <?php //if ($Settings==0) echo 'style="display: none;"'; ?>>
                        <a href="#"><i class="gn-icon gn-icon-prof"><div class="fonts fa fa fa-gear"></div> </i><span>User</span></a>
                        <ul class="animated zoomIn  left-menu">
                            <li <?php //if ($User==0) echo 'style="display: none;"'; ?>><a href="<?php //if ($userdata['groupid']!='0') echo base_url().'index.php/assign'; else echo base_url().'index.php/assign/adminuser'; ?>"><span class="fa fa-cogs"></span> User</a></li>
                            <li <?php //if ($UserRoles==0) echo 'style="display: none;"'; ?>><a href="<?php //echo base_url().'index.php/manage'; ?>"><span class="fa fa-square-o"></span> User Roles</a></li>
                        </ul>
                    </li> -->

                 <!--    <li class="" <?php //if ($Settings==0) echo 'style="display: none;"'; ?>>
                        <a href="#"> <i class="gn-icon gn-icon-about"><div class="fonts fa fa-gear"></div></i>
                    <span>Valuation</span></a>
                        <ul class="animated zoomIn  left-menu">
                            <li <?php //if ($User==0) echo 'style="display: none;"'; ?>><a href="<?php //if ($userdata['groupid']!='0') echo base_url().'index.php/assign'; else echo base_url().'index.php/assign/adminuser'; ?>"><span class="fa fa-cogs"></span> User</a></li>
                            <li <?php //if ($UserRoles==0) echo 'style="display: none;"'; ?>><a href="<?php //echo base_url().'index.php/manage'; ?>"><span class="fa fa-square-o"></span> User Roles</a></li>
                        </ul>
                    </li>
 -->

                    <li class="" <?php if ($Reports==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php if ($userdata['groupid']=='0') echo  base_url().'index.php/reports'; else echo  base_url().'index.php/reports/view_reports'; ?>"> <i class="gn-icon gn-icon-rep">
                        <div class="fonts fa fa-bar-chart-o"></div> 
                    </i>
                    <span>Report</span></a>
                    </li>

                    <li class="" <?php if ($Indexation==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url();?>index.php/Indexation">
                         <i class="gn-icon gn-icon-news-blog">
                         <div class="fonts fa  fa-signal" ></div> 
                    </i><span class="xn-text">Indexation</span></a>
                    </li>


                    <li class="" <?php if ($Tax==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url();?>index.php/tax_master"> <i class="gn-icon gn-icon-news-blog">
                         <div class="fonts fa fa-gavel"></div> 
                    </i><span>Tax</span></a>
                    </li>

                     <li class="" <?php if ($Valuation==0) echo 'style="display: none;"'; ?>>
                        <a href="<?php echo base_url();?>index.php/property_projection"> <i class="gn-icon gn-icon-about">
                          <div class="fonts fa fa-money"></div> 
                    </i>
                    <span>Valuation</span></a>
                    </li>

                    <li <?php if ($Log==0) echo 'style="display: none;"'; ?>>
                    <a href="<?php echo base_url();?>index.php/Log"> <i class="gn-icon gn-icon-about">
                          <div class="fonts fa fa-pencil-square-o"></div> 
                    </i>
                    <span>Log</span></a>
                    </li>
          
          
              <li class="menu--item">
        <a  class="menu--link" href="<?php echo base_url().'index.php/login/idata'; ?>">  
         <i class="menu--icon  fa fa-fw fa-tachometer"></i>
        <span class="menu--label">iDATA</span>
       </a>
    </li>
   
   
   <li class="menu--item">
        <a  class="menu--link" href="<?php echo base_url().'index.php/login/assure'; ?>">  
         <i class="menu--icon  fa fa-fw fa-tachometer"></i>
        <span class="menu--label">Assure</span>
       </a>
    </li>
    </li>

        </ul>
    </div><!-- /scroller -->
  </div>
  </div>
    <!-- <ul class="menu--faq">
        <li class="">
            <a href="faq/landlord.html">
                <i class="gn-icon gn-icon-about">
                    <div class=""><span class="icon-fontello fontello- fa fa-question-circle"></span></div>
                </i>
                <span>Help</span></a>
        </li>
         <li class="" style="box-shadow: inset 0 1px #1d242c;">
            <a href="faq/landlord.html">
                <i class="gn-icon gn-icon-about">
                    <div class=""><span class="icon-fontello fontello- fa fa-bullhorn"></span></div>
                </i>
                <span>Support</span></a>
        </li>
    </ul> -->
</nav>

</div>


 <script type="text/javascript" src="<?php echo base_url().'mobile-menu/vertical/jquery-3.1.0.min.js';?>"></script>                 
 <script type="text/javascript" src="<?php echo base_url().'mobile-menu/vertical/vertical-responsive-menu.min.js';?>"></script>  
 
 
 


 <script type="text/javascript">
   $('#edit').click(function() {
    $('.text-info').hide();
  $('#edit').hide();
  $('.useremail-login').hide();
    $('.grp_change').show();
 
 });
   $('#mbl-grp_change').click(function() {
  
    $('.grp_change').show();
 
 });
 $('.grp_change').mouseleave(function() {
setTimeout(function(){
    $('.text-info').show();
  $('#edit').show();
  $('.useremail-login').show();
    $('.grp_change').hide();
 }, 3000);
 
 });
 
 
 


 </script>
 <script>
 
 function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

 </script>
 
 