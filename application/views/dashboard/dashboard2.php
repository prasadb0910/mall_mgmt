<!DOCTYPE html>
<html>
<head>
    <?php $this->load->view('templates/header');?>
<link href="https://rawgit.com/masayuki0812/c3/master/c3.css" rel="stylesheet" type="text/css" />
<script src="https://rawgit.com/masayuki0812/c3/master/c3.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
<style>
    a{color: #41a541 ;}a:hover, a:active {
    color: #2b6e2b;
}
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: white;
  font-weight: bold;
  font-size: 20px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

img {
  margin-bottom: -4px;
}

.caption-container {
  text-align: center;
  background-color: black;
  padding: 2px 16px;
  color: white;
}

.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}

img.hover-shadow {
  transition: 0.3s
}

.hover-shadow:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
}
.column
{
	width:25%;
}
.list_units p
{
	font-size:14px!important;
}
</style>

</style>
<style>
.edit
{
	
	color:#41a541!important;
}
.delete
{
	color:#da5050!important;
}
.print
{
	color:#fe970a!important;
}

.a
{
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
.info
{
	text-align:center;
   
}
.invoice
{
    margin: 10px;
    padding: 0 27px;
    border-radius: 30px;
    font-size: 13px;
}
.btn-group-justified
{
	margin-left:2px;
}
.email
{
	font-size:13px!important;
		display: block;
		text-align:center;
	
}
.title_1
{
	
	font-size: 15px!important;
    font-family: inherit!important;
    font-weight: 500!important;
    letter-spacing: 0.02em!important;
    text-transform: capitalize!important;
	text-align:center;
	display: block;
}

.rent
{


	border-right:2px solid #f6f9fc;
	padding:15px;
		text-align:center;
		color:#40434b;
	border-color: #f6f9fc !important;	
	    font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
    font-size: 12px;
    text-transform: uppercase;
}
.rent i
{
	color:#41a541 !important;	
	
}
.rent:hover
{
	background-color: #f6f9fc !important;
}
.leases
{
	color:#40434b;
border-top: 2px solid #f6f9fc;
padding:15px;
text-align:center;
color:#40434b;
border-right:2px solid #f6f9fc;
border-color: #f6f9fc) !important;
  font-family: "Montserrat", "tenantcloud", Avenir, sans-serif;
    font-size: 12px;
    text-transform: uppercase;
}
.leases i
{
	color:#41a541 !important;	
}
.leases:hover
{
	background-color: #f6f9fc !important;
}


#money.fa 
{
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
.form-group-default
{
	border:none!important;
}

.form-group-default label
{
	font-weight:1000!important;
}

.thumbnail-wrapper.d32>* {
    line-height: 110px!important;
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
p{
    font-weight: 200px!important;
}

.month 
{
	background:#f6f9fc;
}

.prop_sq li
{
	list-style-type:none!important;
}

</style>


<style>
.dot {
		height: 115px;
		width: 115px;
		border: 1px solid #0facf352;
		border-radius: 50%;
		display: block;
		font-size: 15px;
		text-align: center;
		  line-height: 115px;
		  margin:0 auto;
	}
.unit
{
	font-weight:400!important;
	font-size:18px!important;
	    padding-left: 40px;
}	
.sq
{
	font-weight:300;
	font-size:14px;
	padding-left: 40px;
}
.view_prop
{
	
    width: 100%!important;
    max-width: 100%!important;
	border:1px solid rgba(0,0,0,0.07)!important;
}
.m-panel__footer {
    background: transparent;
    border-radius: 0;
    border-bottom: 0;
    padding: 7px 15px;
    position: relative;
    z-index: 3;
    height: 44px;
  -webkit-box-pack: center;
    -webkit-justify-content: center;
    -ms-flex-pack: center;
    justify-content: center;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
	  
}
.card{
	font-variant-numeric: proportional-nums!important;
    font-family: "tenantcloud", Avenir, sans-serif!important;
    line-height: 1.42857!important;
    letter-spacing: 0.02em!important;
    text-rendering: optimizelegibility!important;
	font-size:15px!important;
	

	}
.m-panel__body {
    position: relative;
    padding: 15px;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-flex: 1;
    -webkit-flex: 1 0 auto;
    -ms-flex: 1 0 auto;
    flex: 1 0 auto;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
		
}
.middle-xs {
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
}
.outstanding-price {
    text-align: center!important;
}
.outstanding-price p {
    color: #da5050;
    margin: 0;
    font-size: 1.71429em;
}
.payments-price.received {
    text-align: right;
    padding-right: 25px;
	    position: relative;
    max-width: 50%;
    word-break: break-all;
}
.body-price {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.payments-price.received p {
    font-size: 1.71429em;
    line-height: 23px;
}

 .body-price .payments-price.received:after {
    content: '';
    position: absolute;
    right: 0;
    top: 0;
    width: 1px;
    height: 100%;
    background: #6dc56d;
    -webkit-transform: rotate(25deg);
    transform: rotate(25deg);
}
.payments-price.pending {
    text-align: left;
    padding-left: 25px;
}
.payments-price.pending p {
   
        font-size: 1.14286em;
}
.u-textTruncate {
    max-width: 100%;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
    word-wrap: normal !important;
}
.list-inner ul li
{
	border-bottom: 1px dashed #edf0f5;
}
.list-footer {
    height: 35px;
    padding: 6px 20px 6px 25px;
    border-top: 1px solid #edf0f5;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: end;
    -webkit-justify-content: flex-end;
    -ms-flex-pack: end;
    justify-content: flex-end;
}

.m-panel__heading {
    border-radius: 0;
    padding: 7px 15px;
    position: relative;
    height: 48px;
    min-height: 48px;
    border-bottom: 2px solid #edf0f5;
    background-color: #f6f9fc;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
	font-weight:700;
	}


.between-xs {
    -webkit-box-pack: justify;
    -webkit-justify-content: space-between;
    -ms-flex-pack: justify;
    justify-content: space-between;
}
.rent a,.leases a
{
	color:#626262!important;
}
</style>





</head>
<body class="fixed-header">
<?php $this->load->view('templates/sidebar');?>
<div class="page-container ">
<?php $this->load->view('templates/main_header');?>


<div class="page-content-wrapper ">

<div class="content ">

<div class=" container-fluid   container-fixed-lg">

<ol class="breadcrumb">
<li class="breadcrumb-item"><a href="#">Dashboard</a></li>


</ol>


<div class=" container-fluid   container-fixed-lg">

<div class="a">
<div class="row">
<div class="col-md-12">
<div class="row">
<div class="col-lg-6">
<div class="card card-default ">
<div class="m-panel__heading between-xs">
		<div class="heading-title">
			Quick buttons
		</div>
</div>
<div class="card card-transparent container-fixed-lg bg-white contact_card m-t-30" id="pricing_box">

<div class="row" style="padding-left:30px;padding-right:30px;">
<div class="col-md-6 rent">
  <a href="<?php echo base_url(); ?>index.php/purchase/addnew"><i style="font-size:24px;" class="fa fa-building-o"></i><br>
Add new Property</a>

</div>

<div class="col-md-6 rent" style="border-right:none;">
 <a href="<?php echo base_url(); ?>index.php/maintenance/addnew"><i style="font-size:24px;" class="fa fa-recycle"></i><br>
Add new request</a>

</div>
<div class=" col-md-6 leases">
 <a href="<?php echo base_url(); ?>index.php/rent/addnew"><i style="font-size:24px;" class="fa fa-group "></i><br>
Add new Tenant</a>

</div>


<div class=" col-md-6 leases" style="border-right:none;">
<a href="#"><i style="font-size:24px;" class="fa fa-file-text-o "></i><br>
Add new reminder

</div>

<div class=" col-md-6 leases">
<a href="<?php echo base_url(); ?>index.php/accounting/addnew/expense"><i style="font-size:24px;" class="fa fa-rupee "></i><br>
Add Expense</a>

</div>


<div class=" col-md-6 leases" style="border-right:none;">
<a href="<?php echo base_url(); ?>index.php/accounting/addnew/income"><i style="font-size:24px;" class="fa fa-money"></i><br>
Add new Income</a>

</div>
</div> 
</div> 

</div>
</div>




<div class="col-lg-6">
<div class="card card-default ">
<div class="m-panel__heading between-xs">
		<div class="heading-title">
			Units		
		</div>

	
	</div>
<div class="card-block">
<div class="m-panel__body">
  <div id="chartMessages"></div>

</div>
<div class="m-panel__footer">
				<a href="/transactions?status=with_balance">view all</a>
			</div>
</div>
</div>




</div>
<div class="col-lg-6">
<div class="card card-default ">
<div class="m-panel__heading between-xs">
		<div class="heading-title">
		Last 30 days			

		</div>

	
	</div>
<div class="card-block">
<div class="m-panel__body">
				<div class="body-price">
					<div class="payments-price received">
						<a ui-sref="transactions.list({status: 1, category: 'income', date_from: $ctrl.last30DayFilter.from, date_to: $ctrl.last30DayFilter.to })" href="/transactions?status=1&amp;category=income">
							<p>₹0</p>
							<span>paid invoices</span>
						</a>
					</div>
					<div class="payments-price pending">
						<p class="u-textTruncate">₹12,000</p>
						<span>open invoices</span>
					</div>
				</div>
			</div>
			<div class="m-panel__footer">
				<a  href="/transactions">view all</a>
			</div>
</div>
</div>




</div>


<div class="col-lg-6">
<div class="card card-default " style="padding-bottom: 33px;">
<div class="m-panel__heading between-xs">
		<div class="heading-title">
			Outstanding			

		</div>

	
	</div>
<div class="card-block">
<div class="m-panel__body">
				
						<div class="outstanding-price">
							<p>₹132,000</p>
						</div>
				
			</div>
<div class="m-panel__footer">
				<a href="/transactions?status=with_balance">view all</a>
			</div>
</div>
</div>

</div>


<div class="col-lg-6">
<div class="card card-default">
<div class="m-panel__heading between-xs">
		<div class="heading-title">
		To do List			

		</div>

	
	</div>
<div class="card-block">
<div class="m-panel__body">
				<div class="list-inner">
						<ul>
							<!----><li>
								<!---->

								test
							</li><!----><li>
								<!---->

							ffff
							</li><!---->
							<li>
								

								rrr
							</li>
							<li>
								

								rrr
							</li>
							<li>
								

								rrr
							</li>
							
						</ul>
					</div>
			</div>
			<div class="list-footer">
					<a class="ng-binding" href="">view all</a>
				</div>
</div>
</div>




</div>

<div class="col-lg-6">
<div class="card card-default">
<div class="m-panel__heading between-xs">
		<div class="heading-title">
			Maintenance			

		</div>

	
	</div>
<div class="card-block">
<div class="m-panel__body">
  <div id="chartMessages1"></div>

</div>
<div class="m-panel__footer">
				<a  href="/transactions?status=with_balance">view all</a>
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
</div>

<?php $this->load->view('templates/footer');?>
</div>
</div>


<?php $this->load->view('templates/script');?>
		
<script>
var chart = c3.generate({
    bindto: '#chartMessages',
    data: {
        columns: [
            ['vacant', <?php if(isset($property_cnt[0]->vacant_cnt)) echo $property_cnt[0]->vacant_cnt; ?>],
            ['occupied', <?php if(isset($property_cnt[0]->rent_cnt)) echo $property_cnt[0]->rent_cnt; ?>],
            ['sold', <?php if(isset($property_cnt[0]->sale_cnt)) echo $property_cnt[0]->sale_cnt; ?>],
      
        ],
        type: 'donut',
        onclick: function (d, i) { console.log("onclick", d, i); },
        onmouseover: function (d, i) { console.log("onmouseover", d, i); },
        onmouseout: function (d, i) { console.log("onmouseout", d, i); }
    },
	
   donut: {
       label: {
           format: function(value) {
               return value;
           },
           show: true, // to turn off the min/max labels.
       },
      min: 0,
      max: 100, // 100 is default
      // units: 'Remaining',
      width: 4, // for adjusting arc thickness
	  opacity:0.2,
    },
   
	legend: {
  position: 'right'
},
    size: {
        height: 150
    }
});


</script>
<script>
var chart = c3.generate({
    bindto: '#chartMessages1',
    data: {
        columns: [
            ['new', 0],['in progress', 0],[' resolved', 2],[' deferred', 0]
      
        ],
        type: 'donut',
        onclick: function (d, i) { console.log("onclick", d, i); },
        onmouseover: function (d, i) { console.log("onmouseover", d, i); },
        onmouseout: function (d, i) { console.log("onmouseout", d, i); }
    },
	
    donut: {
       label: {
           format: function(value) {
               return value;
           },
           show: true, // to turn off the min/max labels.
       },
      min: 0,
      max: 100, // 100 is default
      // units: 'Remaining',
      width: 4, // for adjusting arc thickness
    },
 
	legend: {
  position: 'right'
},
    size: {
        height: 150
    }
});


</script>


		
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/xt5z6ibr';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
</body>
</html>
