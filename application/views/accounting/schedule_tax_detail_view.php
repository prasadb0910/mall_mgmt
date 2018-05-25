<table id="contacts" class="table group1 addschedule">
	<thead>
		<tr>
			<th >Taxes Applicable</th>
			<th   >Tax Amount</th>
			<th   >Paid Till Date</th>													
			<th  >Tax Amount Paid</th>
			<th  >Difference</th>													
		</tr>
	</thead>
	<tbody>

		<?php if(isset($property_details['schedule_tax_detail'])){
			$i=0;
			foreach ($property_details['schedule_tax_detail'] as $row) {
				if($property_details['schedule_tax_detail'][$i]['total_amount_paid'] == $property_details['schedule_tax_detail'][$i]['tax_amount'] ){
					$disabled='disabled';
				} else {
					$disabled='';
				}

				echo '<tr class="tax_num">
						<td>
							<input type="hidden" name="tax_id[]" id ="tax_id_'.($i+1).'" value="'.$property_details['schedule_tax_detail'][$i]['txn_id'].'">
							<input type="hidden" name="tax_applied[]" id ="tax_applied_'.($i+1).'" value="'.$property_details['schedule_tax_detail'][$i]['tax_applied'].'">
							'.$property_details['schedule_tax_detail'][$i]['tax_name'].'
						</td>
						<td >
							<input type="hidden" name="tax_net_amount[]" id ="tax_net_amount_'.($i+1).'" value="'.$property_details['schedule_tax_detail'][$i]['net_amount'].'">
							<input type="hidden" name="tax_amount[]" id ="tax_amount_'.($i+1).'" value="'.$property_details['schedule_tax_detail'][$i]['tax_amount'].'">
							<input type="hidden" name="tax_amount_actual[]" id ="tax_amount_actual_'.($i+1).'" value="'.$property_details['schedule_tax_detail'][$i]['tax_amount_actual'].'">
							'.format_money($property_details['schedule_tax_detail'][$i]['tax_amount'],2).'
						</td>
						<td >
							<input type="hidden" id="tax_paid_till_date_'.($i+1).'" name="tax_paid_amount[]" value="'.$property_details['schedule_tax_detail'][$i]['amount_paid'].'">
							<input type="hidden" id="tax_paid_till_date_actual_'.($i+1).'" name="tax_paid_amount_actual[]" value="'.$property_details['schedule_tax_detail'][$i]['total_amount_paid'].'">
							<a href="#" id="tax_paid_till_date_link_'.($i+1).'" onclick="getAllTaxpaidDetails(\''.$property_details['schedule_tax_detail'][$i]['tax_applied'].'\')">
							'.format_money($property_details['schedule_tax_detail'][$i]['total_amount_paid'],2).' </a>
						</td>
						<td >
							<input type="hidden" id="tax_actual_amount_'.($i+1).'" name="tax_actual_amount[]" class="form-control format_number" style="border: none; text-align:right;" onchange="getDifferneceTaxAmt();" value="'.$property_details['schedule_tax_detail'][$i]['amount_paid_pending'].'" '.$disabled.'/>
							'.$property_details['schedule_tax_detail'][$i]['amount_paid_pending'].'
						</td>
						<td >
							<input type="hidden" name="tax_balance[]" id="tax_balance_'.($i+1).'" value="'.$property_details['schedule_tax_detail'][$i]['balance_amount'].'">
							<span id="tax_difference_'.($i+1).'">'.format_money($property_details['schedule_tax_detail'][$i]['balance_amount'],2).'</span>
						</td>
					</tr>';
					
				$i++;
			}
		} ?>

		<!-- <tr>
			<td>Taxes<span id="tax_name"></span></td>
			<td><input type="text" id="taxAmount" name="taxAmount" style="border:none" value="<?php //if (isset($property_details['tax_amount'])) echo $property_details['tax_amount']?>" ></td>
			<td ><input type="text" id="paid_till_date" name="paid_till_date" style="border:none" value="<?php //if (isset($property_details['tax_paid_amount'])) echo $property_details['tax_paid_amount']?>" ></td>
			<td><input type="text" style="border : none" id="total_paid_tax" name="total_paid_tax" onchange="getDiffence(this.value)" /></td>
			<td id="differnce_tax"><?php //if (isset($property_details['tax_differnece'])) echo $property_details['tax_differnece'];?></td>
		</tr> -->
	</tbody>
</table>