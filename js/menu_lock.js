
 $("document").ready(function() {
 // alert("hasclass");
 
  
        if( localStorage.getItem('hasmenu'))
        {
            // alert("true");
            $("body").addClass("menu-pin");
            $("body").addClass("sidebar-visible");
      
            console.log("setmenu");

        }

 

    });


     $("body").on("click",function(){
        
         if($(this).hasClass("menu-pin"))
         {
            // alert("menu-pin");
           localStorage.setItem('hasmenu', 'true');
		      // $( ".rent_field" ).css('width','100%');
			   //  $( "#form_rent fieldset" ).css({'width':'85%','margin':'0 8%'});
			
			
         }
		 else
		 {
			  localStorage.removeItem('hasmenu', 'true');
			     $("body").removeClass("menu-pin");
				    $("body").removeClass("sidebar-visible");
			  // $( "#form_rent fieldset" ).css({'width':'100%','margin':'0 auto'});
		 }
        

     });
	 
	   
	 
	  
		  