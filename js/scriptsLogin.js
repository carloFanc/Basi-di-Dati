
jQuery(document).ready(function() {
    
    /*
        Login form validation
    */
    $('.login-form input[type="text"], .login-form input[type="password"], .login-form textarea').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    $('.login-form').on('submit', function(e) {
    	
    	$(this).find('input[type="text"], input[type="password"], textarea').each(function(){
    		if( $(this).val() == "" ) {
    			e.preventDefault();
    			$(this).addClass('input-error');
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    	
    });
    
    /*
        Registration form validation
    */
    $('.registration-form input[type="text"], .registration-form textarea').on('focus', function() {
    	$(this).removeClass('input-error');
    });
        $('.registration-form input[type="email"], .registration-form email').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    $('.registration-form').on('submit', function(e) {
    	
    	$(this).find('input[type="text"], textarea').each(function(){
    		if( $(this).val() == "" ) {
    			e.preventDefault();
    			$(this).addClass('input-error');
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    	$(this).find('input[type="email"], email').each(function(){
    		if( $(this).val() == "" ) {
    			e.preventDefault();
    			$(this).addClass('input-error');
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    	
    });
    
    
   $( ".datepicker" ).datepicker({ 
   	changeMonth: true,
        changeYear: true,
        pick12HourFormat: true,
        showButtonPanel: true,
   	yearRange: "-100:+0",
   	dateFormat: 'yy-mm-dd' }); 

$( ".datepicker2" ).datepicker({ 
   	    changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        use24hours: true,
   	yearRange: "-100:+0",
   	dateFormat: 'yy-mm-dd',
    timeFormat:  "hh:mm:ss" }); 
   });
