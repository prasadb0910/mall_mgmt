<div class="panel-body">
										<div class="table-responsive">
										<table id="contacts" class="table group1 addschedule">
											<thead>
												<tr>
													<th>Paid Amount</th>
													<th>Paid Date</th>												
													<th>Payment Mode</th>
																										
												</tr>
											</thead>
											<tbody>
												<?php if(isset($actual_schedule)){
													$i=0;
													foreach($actual_schedule as $row){
														echo '<tr><td>'.$actual_schedule[$i]['paid_amount'].'</td>
														<td>'.$actual_schedule[$i]['payment_date'].'</td>
														<td>'.$actual_schedule[$i]['payment_mode'].'</td></tr>';
														$i++;
													}}?>
											</tbody>
											</div>
										</div>