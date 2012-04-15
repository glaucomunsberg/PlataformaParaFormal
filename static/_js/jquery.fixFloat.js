(function($){$.fn.fixFloat = function(options){/**We have named our plugin 'fixFloat'**/

        var defaults = {enabled: true};
        var options = $.extend(defaults, options);
 
        var offsetTop;      /**Distance of the element from the top of window**/
        var s;              /**Scrolled distance from the top of window through which we have moved**/
        var fixMe = true;
        var repositionMe = true;
 
        var tbh = $(this);
        var originalOffset = tbh.offset().top;    /**Get the actual distance of the element from the top**/
 
        if(options.enabled){
            $(window).scroll(function(){
                var offsetTop = tbh.offset().top;   /**Get the current distance of the element from the top**/
                var s = parseInt($(window).scrollTop(), 10);    /**Get distance from the top of window through which we have scrolled**/
                var fixMe = true;

                if(s > offsetTop)
                    fixMe = true;
                else
                    fixMe = false;

                if(s < parseInt(originalOffset, 10))
                    repositionMe = true;
                else
                    repositionMe = false;

                if(fixMe){
                	tbh.after('<div id="toolbartemp"></div>');
                	$('#toolbartemp').css({'width': tbh.width(), 'height': tbh.height() + 2});
                	tbh.css({'position' : 'fixed', 'top' : '1px', 'z-index': 4, 'width': tbh.width()});                	
                }

                if(repositionMe){
                	$('#toolbartemp').remove();
                	tbh.css({'position' : '', 'top' : '', 'z-index': '', 'width': ''});
                }

            });
        }
    };
})(jQuery);