(function($){
    $.fn.message = function(settings) {

    	var $this = $(this),
    		config = {
            	'msg':'default message'
        	};
	    
	    if (settings){$.extend(config,settings);}
	    
	    return this.each(function() {
	    	$this.html(config.msg).show();
	    	setTimeout(
        		(function(){
        			$this.slideUp('slow');
        		}), 2000
    		);
	    });
	    
    };
})(jQuery);