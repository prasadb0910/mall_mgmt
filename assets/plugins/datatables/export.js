
    $(document).ready(function(){
        $("#example1").DataTable({
		
			responsive: true,
            dom: 'Blfrtip',
            
             buttons: [
      {
         extend: 'collection',
         text: '<b class="export"><i class="fa export fa-download"></i> &nbsp Download</b>',
         buttons: [    
					{
						extend:    'excelHtml5',
						text:      '<b class="export_tab"><img src="http://ec2-52-221-118-107.ap-southeast-1.compute.amazonaws.com/app/img/icons/xls.png" width="24px;"> &nbsp XLS</i></b>',
						titleAttr: 'Excel'
					},
					{
						extend:    'csvHtml5',
						text:      '<b class="export_tab"><img src=http://ec2-52-221-118-107.ap-southeast-1.compute.amazonaws.com/app/img/icons/csv.png width="24px";> &nbsp CSV</i></b>',
						titleAttr: 'CSV'
					}
				]
      }
	
   ]
   
        });


	 $("#example2").DataTable({
            dom: 'Bfrtip',
            
             buttons: [
      {
         extend: 'collection',
         text: '<b class="export"><i class="fa export fa-download"></i> &nbsp Download</b>',
         buttons: [    
					{
						extend:    'excelHtml5',
						text:      '<b class="export_tab"><img src="http://ec2-52-221-118-107.ap-southeast-1.compute.amazonaws.com/app/img/icons/xls.png" width="24px;"> &nbsp XLS</i></b>',
						titleAttr: 'Excel'
					},
					{
						extend:    'csvHtml5',
						text:      '<b class="export_tab"><img src=http://ec2-52-221-118-107.ap-southeast-1.compute.amazonaws.com/app/img/icons/csv.png width="24px";> &nbsp CSV</i></b>',
						titleAttr: 'CSV'
					}
				]
      }
   ]
        });
 

	 $("#example3").DataTable({
        
        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]]

        });
  

	 $("#example4").DataTable({
		 "scrollY":        "190px",
        "scrollCollapse": true,
        "paging":         false,
      "ordering": false
           
        });
		
		
		
		
	 $("#example7").DataTable({
		
       
      "ordering": false
           
        });
 
 	 $("#example8").DataTable({
		 
        
      "ordering": false
           
        });
 
 
	
		 $("#example5").DataTable({
		"ordering":false,
		
		dom: 'Bfrtip',

                 buttons: [
      {
         extend: 'collection',
         text: '<b class="export"><i class="fa export fa-download"></i> &nbsp Download</b>',
         buttons: [    
					{
						extend:    'excelHtml5',
						text:      '<b class="export_tab"><img src="http://ec2-52-221-118-107.ap-southeast-1.compute.amazonaws.com/app/img/icons/xls.png" width="24px;"> &nbsp XLS</i></b>',
						titleAttr: 'Excel'
					},
					{
						extend:    'csvHtml5',
						text:      '<b class="export_tab"><img src=http://ec2-52-221-118-107.ap-southeast-1.compute.amazonaws.com/app/img/icons/csv.png width="24px";> &nbsp CSV</i></b>',
						titleAttr: 'CSV'
					}
				]
      }
   ]
    } );
	
	 $("#example6").DataTable({
		"ordering":false,
		
		dom: 'Bfrtip',
                buttons: [
      {
         extend: 'collection',
         text: '<b class="export"><i class="fa export fa-download"></i> &nbsp Download</b>',
         buttons: [    
					{
						extend:    'excelHtml5',
						text:      '<b class="export_tab"><img src="http://ec2-52-221-118-107.ap-southeast-1.compute.amazonaws.com/app/img/icons/xls.png" width="24px;"> &nbsp XLS</i></b>',
						titleAttr: 'Excel'
					},
					{
						extend:    'csvHtml5',
						text:      '<b class="export_tab"><img src=http://ec2-52-221-118-107.ap-southeast-1.compute.amazonaws.com/app/img/icons/csv.png width="24px";> &nbsp CSV</i></b>',
						titleAttr: 'CSV'
					}
				]
      }
   ]
    } );

	

    });
