<div class="row">
  <div class="view_table" style="overflow: visible;">
    <table id="contacts" style="text-align:right; vertical-align:middle;">
			<thead>
				<tr>
          <th width="9%" style="text-align:center;"> Sr No. </th>
          <th width="23%" style="text-align:center;"> Type  </th>
          <!-- <th width="23%" style="text-align:center;"> Payment Type  </th>
          <th width="23%" style="text-align:center;"> Agreement Value </th> -->
          <th width="15%" style="text-align:center;">Cost </th>
          <?php 
            $total='total';
            $sales_consideration=0;
            if(isset($tax_name)){
              $key=0;
              foreach($tax_name as $row){
                echo '<th width="15%" style="text-align:center;">'.$row->tax_type.'</th>';
                $tax_array[$key]=$row->tax_type;
                $key++;
              }
            }
          ?>
          <th width="18%" style="text-align:center;"> Net Cost </th>
        </tr>
			</thead>
			<tbody>
        <?php 
        $j=0;
        $total_basic_cost=0;
        $total_net_amount=0;
        $total_tax_array=array();
        foreach($p_schedule as $row_tax){
          $sch_basiccost=format_number($p_schedule[$j]["basic_cost"],2);
          echo '<tr>
                <td style="text-align:left;">'.($j+1).'</td>
                <td style="text-align:left;">'.$p_schedule[$j]["event_type"].'</td>
                <td>'.$p_schedule[$j]["basic_cost"].'</td>';
                $total_basic_cost=$total_basic_cost+$sch_basiccost;
                $next_count=0;
                $td_count=0;
								if(isset($p_schedule[$j]['tax_type'])) {
                  for($tcnt=0;$tcnt<$key;$tcnt++){
                    for($nc=0;$nc<count($p_schedule[$j]['tax_type']);$nc++) {
                      $tax_amount='';
                      if($p_schedule[$j]['tax_type'][$nc]==$tax_array[$tcnt]) {
                        $tax_amount=format_number($p_schedule[$j]['tax_amount'][$nc],2);
                        $nc=count($p_schedule[$j]['tax_type']);
                      }
                    }
                    if($tax_amount !=''){
                      echo '<td>'.format_money($tax_amount,2).'</td>';
                      $td_count++;
                    } else {
                      echo '<td>'.format_money($tax_amount,2).'</td>';
                      $td_count++;
                    }
                  }
								}
                $inserttd=$key-$td_count;
                if($inserttd !=0) {
                  for($tdint=0;$tdint<$inserttd;$tdint++) {
                    echo "<td></td>";
                  }
                }
                echo'<td>'.format_money($p_schedule[$j]["net_amount"],2).'</td>
                </tr>';
          $total_net_amount=$total_net_amount+format_number($p_schedule[$j]["net_amount"],2);
          $j++;
        }?>

        <tr>
          <td colspan="2" style="text-align:center;"><b>Grand Total</b></td>
          <td><?php echo format_money($total_basic_cost,2);?></td>
          <?php  $k=0;if(isset($total_tax_amount)) {
            foreach($total_tax_amount as $row){
              echo '<td>'.format_money($total_tax_amount[$k],2).'</td>';
              $k++;
          } } ?>
          <td><?php echo format_money($total_net_amount); $sales_consideration=$total_net_amount;?></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>