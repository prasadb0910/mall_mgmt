<div class="panel-body">
	<div class="table-responsive">
		<table id="contacts" class="table group1 addschedule">
			<thead>
				<tr>
					<th>Event Type</th>
					<th>Event Name</th>
					<th>Event Date</th>
					<th>Budget</th>
					<th>Paid Till Date</th>
					<th>Paid Amount</th>
					<th>Outstanding</th>
					<th>Select Event</th>
				</tr>
			</thead>
			<tbody style="color:black;">
				<?php if(isset($other_sch)){
					$i=0;
					$options="";
					if(isset($total_sch)){
						foreach($total_sch as $row){
							$options=$options.'<option value="'.$total_sch[$i]->sch_id.'">'.$total_sch[$i]->temp_col.'</option>';
							$i++;
						}
					}

					$i=0;
					foreach($other_sch as $row){
						echo '<tr>
								<td><input type="hidden" name="sch_id[]" value="'.$other_sch[$i]->id.'">'.$other_sch[$i]->event_type.'</td>
								<td>'.$other_sch[$i]->event_name.'</td>
								<td>'.date("d/m/Y",strtotime($other_sch[$i]->event_date)).'</td>
								<td >'.format_money($other_sch[$i]->net_amount,2).'</td>
								<td >'.format_money($other_sch[$i]->total_amount_paid,2).'</td>
								<td >'.format_money($other_sch[$i]->paid_amount,2).'</td>
								<td >'.format_money($other_sch[$i]->balance,2).'</td>
								<td><select name="new_sch_id[]"><option value="0">Select Event</option>'.$options.'</select></td>
							  </tr>';
						$i++;
					}
					// foreach($other_sch as $row){
					// 	echo '<tr>
					// 			<td><input type="hidden" name="sch_id[]" value="'.$other_sch[$i]['id'].'">'.$other_sch[$i]['event_type'].'</td>
					// 			<td>'.$other_sch[$i]['event_name'].'</td>
					// 			<td>'.$other_sch[$i]['event_date'].'</td>
					// 			<td>'.$other_sch[$i]['net_amount'].'</td>
					// 			<td>'.$other_sch[$i]['paid_amount'].'</td>
					// 			<td>'.$other_sch[$i]['balance'].'</td>
					// 			<td><select name="new_sch_id[]">'.$options.'<select></td>
					// 		  </tr>';
					// 	$i++;
					// }
				}?>
			</tbody>
		</table>
	</div>
</div>