<div class="panel-body">
	<div class="table-responsive">
		<table id="contacts" class="table group1 addschedule">
			<thead>
				<tr>
					<?php 
						echo '<th >Paid Amount</th>
							<th >Paid Date</th>
							<th >Payment Mode</th>';
					?>
				</tr>
			</thead>
			<tbody style="color:black;">
				<?php if(isset($actual_schedule)){
					$i=0;
					foreach($actual_schedule as $row){
						echo '<tr><td >'.format_money($actual_schedule[$i]['paid_amount'],2).'</td>
						<td >'.$actual_schedule[$i]['payment_date'].'</td>
						<td >'.$actual_schedule[$i]['payment_mode'].'</td></tr>';
						$i++;
					}
				}?>
			</tbody>
		</table>
	</div>
</div>