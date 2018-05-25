<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Tax Invoice</title>
    <link href="<?php echo base_url(); ?>css/fontawesome/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <style>
        @font-face {
            font-family: "OpenSans-Regular";
            src: url("<?php echo base_url(); ?>css/invoice/OpenSans-Regular.ttf") format("truetype");
        }

        @media print{@page {size: portrait;}}

        .invoice { font-family: "verdana"; font-size:10px; font-weight:500; margin:0; line-height:11px;}

        body { font-family: "verdana"; font-size:10px; font-weight:500; margin:0; line-height:11px;}

        /*@media print {
        .page-break { display: block; page-break-after: always; }
        }*/
    </style>
</head>

<body style="margin: 1px;">
    <div class="invoice">
        <center style="width:100%;display:inline-block;margin:0 auto;">
            <?php echo $data['issuer_name']; ?>
            <p style="font-size:12px;line-height:18px;margin:0;margin-bottom:10px;">
                <?php echo $data['issuer_address']; ?><br /> 
                <!-- 022 6143 1777<br />
                <a href="mailto:cs@eatanytime.in">info@pecanreams.com</a><br /> -->
                GSTIN: <?php echo $data['issuer_gst']; ?>
            </p>
        </center>
        <table cellspacing="0" cellpadding="5" border="1" style="border-collapse: collapse; width:100%; margin:auto; font-family:Arcon-Regular, OpenSans-Regular, Arcon, Verdana, Geneva, sans-serif; font-size:10px; font-weight:400; border:1px solid #666;"    >

            <col width="43" />
            <col width="115" />
            <col width="110" />
            <col width="112" />
            <col width="83" />
            <col width="92" />
            <col width="95" />
            <col width="64" />
            <tr>
                <td colspan="6" align="left" valign="top" style="padding:0;border-spacing: 0;">
                    <table width="100%" border="0" style="border-spacing: 0;">
                        <tr>

                            <td width="60%" style="color:#808080;margin:0 auto;text-align:center;"   ><h1 style="padding:0; margin:0; font-size:20px;">Invoice</h1></td>
                            <td width="2%">
                                <table style="width:115%;border-collapse: collapse;height: 30px;border-spacing: 0;">
                                    <tr><td>&nbsp;<td></tr>
                                    <tr><td>&nbsp;<td></tr>
                                    <tr><td >&nbsp;<td></tr>
                                </table>
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>



            <tr>
                <td colspan="6" valign="top" style="line-height:12px; padding:0;border-bottom:none;"> 
                    <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                        <tr style="border-bottom:0px solid #666; height: 20px;"  >
                            <td width="50%" rowspan="3" style="line-height:12px; border-bottom:0px solid #666; text-align:center;border-right:1px solid #666;font-weight:bolder;">

                            </td>
                            <td width="50%" rowspan="3" style="line-height:12px; border-bottom:0px solid #666;text-align:center; font-weight:bolder;">
                                Details of Receiver | Billed to:
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="6" valign="top" style="line-height:12px; padding:0; border-bottom:none; padding-bottom: 0px; margin-bottom: 0px;"> 
                    <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    ">
                        <tr style="border-bottom:0px solid #666; padding-bottom: 0px; margin-bottom: 0px;">
                            <td width="50%" rowspan="3" style="border-bottom:0px solid #666; padding-bottom: 0px; margin-bottom: 0px;">

                                <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse; padding-bottom: 0px; margin-bottom: 0px;">
                                    <tr>
                                        <td>Invoice No: </td><td><?php echo $data['invoice_no']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Invoice Date: </td><td><?php if(isset($data['invoice_date'])) echo date('d/m/Y',strtotime($data['invoice_date'])); ?></td>
                                    </tr>
                                    <tr style="padding-bottom: 0px; margin-bottom: 0px;">
                                        <td style="padding-bottom: 0px; margin-bottom: 0px;">State: </td>
                                        <td style="padding-bottom: 0px; margin-bottom: 0px;"><?php echo $data['issuer_state']; ?>
                                            <table style="float: right;border-collapse:collapse;margin-right:10px; padding-bottom: 0px; margin-bottom: 0px;">
                                                <tr style="border-top:1px solid #666; padding-bottom: 0px; margin-bottom: 0px;">
                                                    <td style="border-left:1px solid #666;border-right:1px solid #666;width:80px; padding-bottom: 0px; margin-bottom: 0px;" align="right">State Code: &nbsp;</td>
                                                    <td style="border-right:1px solid #666;width:20px;text-align:center; padding-bottom: 0px; margin-bottom: 0px;"><?php echo $data['issuer_state_code']; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="50%" valign="top" style="line-height:12px;  border-right:1px solid #666; border-left:1px solid #666; border-bottom:1px solid #666; border-right:none; padding-bottom: 0px; margin-bottom: 0px;">
                                <table width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse; padding-bottom: 0px; margin-bottom: 0px;">
                                    <tr>
                                        <td width="30%">Name:</td><td><?php echo $data['tenant_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Address: </td><td><?php echo $data['tenant_address']; ?></td>
                                    </tr>
                                    <!-- <tr>
                                    <td>GSTIN: </td><td> </td>
                                    </tr> -->
                                    <tr style="padding-bottom: 0px; margin-bottom: 0px;">
                                        <td style="padding-bottom: 0px; margin-bottom: 0px;">State: </td>
                                        <td style="padding-bottom: 0px; margin-bottom: 0px;"><?php echo $data['tenant_state']; ?>
                                            <table style="float: right; border-collapse:collapse; margin-right:10px; padding-bottom: 0px; margin-bottom: 0px;">
                                                <tr style="border-top:1px solid #666; padding-bottom: 0px; margin-bottom: 0px;">
                                                    <td style="border-left:1px solid #666;border-right:1px solid #666;width:80px; padding-bottom: 0px; margin-bottom: 0px;" align="right">State Code: &nbsp;</td>
                                                    <td style="border-right:1px solid #666;width:20px;text-align:center; padding-bottom: 0px; margin-bottom: 0px;"><?php echo $data['tenant_state_code']; ?></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>  
                </td>
            </tr>
            
<tr>
    <td colspan="6">&nbsp;</td></tr>


    <tr style="font-size:10px; font-weight:500;">
        <td colspan="6" style="padding: 0;">

            <table style="width:100%;" width="100%"  border="0" cellspacing="0" cellpadding="2"  style="border-collapse: collapse;    "><tr style="background:#ececec;">

                <td width="600" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Name of Product / Service</td>
                <td width="50" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Price (Rs.)</td>
                <td width="50" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Discount (Rs.)</td>
                <td width="50" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;">Amount</td>

                <td width="150" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0;height: 36px;"><tr><td colspan="2" style="text-align: center;">CGST</td></tr><tr><td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Rate</td><td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Amount</td></tr></table>
                </td>
                <td width="150" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0;height: 36px;"><tr><td colspan="2" style="text-align: center;">SGST</td></tr><tr><td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Rate</td><td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Amount</td></tr></table>
                </td>
                <td width="150" align="center" valign="middle" style="border-right:1px solid #666;border-bottom:1px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0;height: 36px;"><tr><td colspan="2" style="text-align: center;">IGST</td></tr><tr><td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Rate</td><td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 1px solid #666;text-align: center;" width="50%">Amount</td></tr></table>
                </td>
                <td width="60" align="center" valign="middle" style="border-right:none;border-bottom:1px solid #666;">Total</td>
            </tr>

            <tr valign="top" style="border: none;">

                <td valign="top" align="left" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;">Property Subscription - <?php echo $data['plan_name']; ?></td>
                <td width="130" valign="top" align="right" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $data['price']; ?></p></td>
                <td width="130" valign="top" align="right" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $data['discount']; ?></p></td>
                <td width="130" valign="top" align="right" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "><?php echo $data['amount']; ?></p></td>


                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;"><tr><td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $data['cgst_rate']; ?></td><td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $data['cgst']; ?></td></tr></table>
                </td>
                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;"><tr><td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $data['sgst_rate']; ?></td><td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $data['sgst']; ?></td></tr></table>
                </td>
                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;"><tr><td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $data['igst_rate']; ?></td><td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"><?php echo $data['igst']; ?></td></tr></table>
                </td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;"><p style="margin:0; "><?php echo $data['total_amount']; ?></p></td>
            </tr>



            <tr valign="top" style="border: none;">

                <td valign="top" align="left" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"></td>
                <td width="130" valign="top" align="right" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "></p></td>
                <td width="130" valign="top" align="right" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "></p></td>
                <td width="130" valign="top" align="right" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "></p></td>

                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;"><tr><td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"></td><td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"></td></tr></table>
                </td>
                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;"><tr><td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"></td><td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"></td></tr></table>
                </td>
                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;"><tr><td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"></td><td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"></td></tr></table>
                </td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;"><p style="margin:0; "></p></td>
            </tr>


            <tr valign="top" style="border: none;">

                <td valign="top" align="left" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"></td>
                <td width="130" valign="top" align="right" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "></p></td>
                <td width="130" valign="top" align="right" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "></p></td>

                <td width="130" valign="top" align="right" style="border-left:1px solid #666;  border-top: none; border-bottom:none;border:none;border-right:1px solid #666;"><p style="margin:0; "></p></td>

                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;"><tr><td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"></td><td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"></td></tr></table>
                </td>
                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;"><tr><td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"></td><td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"></td></tr></table>
                </td>
                <td align="center" valign="middle" style="border-right:1px solid #666;border-bottom:0px solid #666;padding:0;">
                    <table style="width: 100%;border-spacing: 0; height: 17px;"><tr><td style="border-right:1px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"></td><td style="border-right:0px solid #666;border-bottom:0px solid #666;border-top: 0px solid #666;text-align: right;" width="50%"></td></tr></table>
                </td>
                <td valign="top" align="right" style="border-left:1px solid #666; border-top: none; border-bottom:none;border:none;"><p style="margin:0; "></p></td>
            </tr>



        </table></td>
    </tr>



    <tr>
        <td colspan="6"></td></tr>


<!-- <tr valign="top" style="border: none;">
<td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">&nbsp;</td>
<td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">&nbsp;</td>
<td width="130" valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
<td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
<td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
<td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
</tr>
<tr valign="top" style="border: none;">
<td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">&nbsp;</td>
<td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">&nbsp;</td>
<td width="130" valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
<td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
<td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
<td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
</tr>
<tr valign="top" style="border: none;">
<td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">&nbsp;</td>
<td valign="top" align="center" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;">&nbsp;</td>
<td width="130" valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
<td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
<td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
<td valign="top" align="right" style="border-left:1px solid #666; border-right:1px solid #666; border-top: none; border-bottom:none;"><p style="margin:0; ">  </p></td>
</tr> -->
<tr style="border-top: 1px solid #666;">
    <td width="50%" colspan="3" rowspan="8" valign="top" style="padding:0;">

        <p style="margin:0;text-align:center;line-height:22px;font-size:18px;"><span style="  font-size:18px; font-weight:500;    margin-top: 5px;display: block;" >Amount in words: <br/><br><br><br></span><?php echo $data['total_amount_in_words']; ?></p> 

    </td>

    <td width="25%" colspan="2" valign="middle" style="font-size:10px; font-weight:900;background:#ececec;">Total amount before Tax</td>
    <td width="25%" valign="middle" style=" font-size:10px; font-weight:900;background:#ececec;">  
        <span style="text-align:left; float:left"> &#8377; </span> 
        <span style="text-align:right; float:right"><?php echo $data['amount']; ?></span> 
    </td>
</tr>
<tr>
    <td colspan="2" valign="middle" style="font-size:10px; font-weight:500;">Add: CGST</td>
    <td valign="middle" style=" font-size:10px; font-weight:500;" >  
        <span style="text-align:left; float:left"> &#8377; </span> 
        <span style="text-align:right; float:right"><?php echo $data['cgst']; ?></span> 
    </td>
</tr>
<tr>
    <td colspan="2" valign="middle" style="font-size:10px; font-weight:500;">Add: SGST</td>
    <td valign="middle" style=" font-size:10px; font-weight:500;"  >  
        <span style="text-align:left; float:left"> &#8377; </span> 
        <span style="text-align:right; float:right"><?php echo $data['sgst']; ?></span> 
    </td>
</tr>
<tr>
    <td colspan="2" valign="middle" style="font-size:10px; font-weight:500;">Add: IGST</td>
    <td valign="middle" style=" font-size:10px; font-weight:500;"  >  
        <span style="text-align:left; float:left"> &#8377; </span> 
        <span style="text-align:right; float:right"><?php echo $data['igst']; ?></span> 
    </td>
</tr>
<tr style="background:#ececec;"> 
    <td colspan="2" valign="middle" style="font-size:10px; font-weight:900;">
        <p style="margin:0;"><span style="  font-size:10px; font-weight:900;" >Total Amount: GST</span></p>
    </td>
    <td valign="middle" style=" font-size:10px; font-weight:900;" >  
        <span style="text-align:left; float:left"> &#8377; </span> 
        <span style="text-align:right; float:right"><?php echo $data['gst']; ?></span> 
    </td>
</tr>
<tr style="background:#ececec;"> 
    <td colspan="2" valign="middle" style="font-size:10px; font-weight:900;">
        <p style="margin:0;"><span style="  font-size:10px; font-weight:900;" >Round Off Amount</span></p>
    </td>
    <td valign="middle" style=" font-size:10px; font-weight:900;" >  
        <span style="text-align:left; float:left"> &#8377; </span> 
        <span style="text-align:right; float:right"><?php echo $data['round_off_amount']; ?></span> 
    </td>
</tr>
<tr style="background:#ececec;"> 
    <td colspan="2" valign="middle" style="font-size:10px; font-weight:900;">
        <p style="margin:0;"><span style="  font-size:10px; font-weight:900;" >Total Amount After Tax</span></p>
    </td>
    <td valign="middle" style=" font-size:10px; font-weight:900;" >  
        <span style="text-align:left; float:left"> &#8377; </span> 
        <span style="text-align:right; float:right"><?php echo $data['value']; ?></span> 
    </td>
</tr>
<tr> 
    <td colspan="2" valign="middle" style="font-size:10px; font-weight:900;">
        <p style="margin:0;"><span style="  font-size:10px; font-weight:900;" >GST Payable on Reverse Charge</span></p>
    </td>
    <td valign="middle" style=" font-size:10px; font-weight:900; background:#ececec;" >  
        <span style="text-align:left; float:left"> &#8377; </span> 
        <span style="text-align:right; float:right">0</span> 
    </td>
</tr>
<tr>
    <td width="65%" colspan="3" valign="middle" style="padding:0;">
        <table width="100%" border="0" cellpadding="5" cellspacing="0">

            <tr>
                <td width="42%"><p style="margin:0;"><span style="  font-size:10px; font-weight:500;" >Bank Name </span></td>
                <td width="58%"><span style=" font-size:10px; font-weight:500;" >: HDFC Bank </span></td>
            </tr>
            <tr>
                <td><p style="margin:0;"><span style="  font-size:10px; font-weight:500;" >Branch  </span></p></td>
                <td><span style=" font-size:10px; font-weight:500;" >: Kandivali(w)</span></td>
            </tr>
            <tr>
                <td><p style="margin:0;"><span style="  font-size:10px; font-weight:500;" >A/C No. </span></p></td>
                <td><span style=" font-size:10px; font-weight:500;" >: 50200018195231</span></td>
            </tr>
            <tr>
                <td><p style="margin:0;"><span style="  font-size:10px; font-weight:500;" > IFSC Code </span></p></td>
                <td><span style=" font-size:10px; font-weight:500;" >: HDFC0000288</span></td>
            </tr>
        </table>




    </td>
    <td width="35%" colspan="3" align="center" valign="top" style=" font-size:10px; font-weight:500;"> For Pecan Reams Private Limited <br/> <img src="" height="50"  alt="Sign Rohit" /> <br/>Authorised Signatory</td>
</tr>
<tr>
    <td colspan="6" valign="top"><p style="line-height:11px; text-align:justify;   margin: 0; "> <span style="  font-size:10px; font-weight:500;" >Declaration:</span><br />
        I /We hereby certify that Registration Certificate under Maharashtra VAT    Act 2002(Act No. IX of 2005) (as amended by Maharashtra Ordinance no.1 of    2005 dated 09-03-2005) is in force on the date on which the sale of goods    specified in this bill/cash Memorandum has been effected by Me/Us in the    regular course of our business. It shall be accounted for in the turnover of    sales while filing return and the due tax, if any Payable on the sales has    been paid or shall be paid. I /We hereby certify that Registration    Certificate under Maharashtra VAT Act 2002(Act No. IX of 2005) (as amended by    Maharashtra Ordinance no.1 of 2005 dated 09-03-2005) is in force on the date    on which the sale of goods specified in this bill/cash Memorandum has been    effected by Me/Us in the regular course of our business. It shall be    accounted for in the turnover of sales while filing return and the due tax,    if any Payable on the sales has been paid or shall be paid. </p></td>
    </tr>
</table>
<p style="text-align:center; font-family:OpenSans-Regular, Arcon,Verdana, Geneva, sans-serif; font-size:10px; line-height:11px; margin-top:3px; margin-bottom:0;  ">SUBJECT TO MUMBAI JURISDICTION <br />
    This is a Computer Generated Invoice</p>
</div>

</body>
</html>