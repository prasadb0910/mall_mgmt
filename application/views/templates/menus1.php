 

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
  /*.form-control { padding:6px!important;  }*/
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
	@media screen and (max-width:320px) {.vertical_nav .bottom-menu-fixed {  top: 79.2%!important;}	}
	@media only screen and (min-width:321px) and (max-width:360px) {.vertical_nav .bottom-menu-fixed {  top: 82.2%!important;}	}
	.vertical_nav__minify .menu--subitens__opened span {
		cursor:default;
	}
</style>    



<div class="header-fixed-style"  >
  <!-- START X-NAVIGATION VERTICAL -->
  <div class="logo-container">  
    <a class="gn-icon-menu " href="<?php echo base_url().'index.php/dashboard/home'; ?>"  > 
      <!-- <img height="50" style=" "   src="<?php //echo base_url().'img/logo-icon.png';?>"   /> 
      <img   src="<?php //echo base_url().'img/pecan-logo.png';?>"  height="45" style="margin-left:10px;"  />  -->               

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
      <!-- <span class="fa fa-edit edit-show" id="edit" style="display:none;"></span>  -->
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
 
    <ul id="js-menu" class="menu mCustomScrollbar">
    <?php if ($Groups==1) { ?>
   
    <li class="menu--item" <?php if ($Groups==0) echo 'style="display: none;"'; ?>>
      <a href="<?php echo base_url().'index.php/groups'; ?>" class="menu--link" title="">
         <i class="menu--icon  fa fa-fw fa-group"></i> 
         <span class="menu--label">Group</span>
      </a>
    </li> <?php } else { ?>
   
  
    <li class="menu--item">
        <a  class="menu--link" href="<?php echo base_url().'index.php/dashboard/'; ?>">  
         <i class="menu--icon  fa fa-fw fa-tachometer"></i>
        <span class="menu--label">REAMS</span>
       </a>
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
 
    <?php } ?>

    </ul>
  </nav>


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
 
 