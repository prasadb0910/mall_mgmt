
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
						text:      '<b class="export_tab"><img src="http://localhost/eat_erp/img/icons/xls.png" width="24px;"> &nbsp XLS</i></b>',
						titleAttr: 'Excel'
					},
					{
						extend:    'csvHtml5',
						text:      '<b class="export_tab"><img src=http://localhost/eat_erp/img/icons/csv.png width="24px";> &nbsp CSV</i></b>',
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
						text:      '<b class="export_tab"><img src="http://localhost/eat_erp/img/icons/xls.png" width="24px;"> &nbsp XLS</i></b>',
						titleAttr: 'Excel'
					},
					{
						extend:    'csvHtml5',
						text:      '<b class="export_tab"><img src=http://localhost/eat_erp/img/icons/csv.png width="24px";> &nbsp CSV</i></b>',
						titleAttr: 'CSV'
					}
				]
      }
   ]
        });
 

	 $("#example3").DataTable({
            dom: 'Bfrtip',
            ordering: false,
            buttons: [
      {
         extend: 'collection',
         text: '<b class="export"><i class="fa export fa-download"></i> &nbsp Download</b>',
         buttons: [    
					{
						extend:    'excelHtml5',
						text:      '<b class="export_tab"><img src="http://localhost/eat_erp/img/icons/xls.png" width="24px;"> &nbsp XLS</i></b>',
						titleAttr: 'Excel'
					},
					{
						extend:    'csvHtml5',
						text:      '<b class="export_tab"><img src=http://localhost/eat_erp/img/icons/csv.png width="24px";> &nbsp CSV</i></b>',
						titleAttr: 'CSV'
					}
				]
      }
   ]
        });
  

	 $("#example4").DataTable({
            dom: 'Bfrtip',
            
             buttons: [
      {
         extend: 'collection',
         text: '<b class="export"><i class="fa export fa-download"></i> &nbsp Download</b>',
         buttons: [    
					{
						extend:    'excelHtml5',
						text:      '<b class="export_tab"><img src="http://localhost/eat_erp/img/icons/xls.png" width="24px;"> &nbsp XLS</i></b>',
						titleAttr: 'Excel'
					},
					{
						extend:    'csvHtml5',
						text:      '<b class="export_tab"><img src=http://localhost/eat_erp/img/icons/csv.png width="24px";> &nbsp CSV</i></b>',
						titleAttr: 'CSV'
					}
				]
      }
   ]
        });
 
	
		 $("#example5").DataTable({
		"ordering":false,
		
		dom: 'Bfrtip',

        buttons: [
            
            'csvHtml5',
			
			
           
        ]
    } );
	
	 $("#example6").DataTable({
		"ordering":false,
		
		dom: 'Bfrtip',
        buttons: [
            
            'csvHtml5'
           
        ]
    } );

	

    });
