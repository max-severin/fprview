/**
 * fprview.frontend.js
 * Module fprviewFrontend
 */

/*global $, fprviewFrontend */

var fprviewFrontend = (function () { "use strict";
	//---------------- BEGIN MODULE SCOPE VARIABLES ---------------
	var
		initModule;
	//----------------- END MODULE SCOPE VARIABLES ----------------

	//------------------- BEGIN PUBLIC METHODS --------------------
	initModule = function () {

		$(document).on('click', '.fprview-more-info', function(event){
			event.preventDefault();

	        $.fancybox({
	            type     : 'ajax',
	            href     : $(this).attr('href'),
	        	autoSize : false,
			    width    : "60%",
			    height   : "auto"
	        });

	        {if isset($fprview_settings.button_hide) && $fprview_settings.button_hide === 'on'}
	        $(this).hide();
	        {/if}
	    });  

		{if isset($fprview_settings.button_hide) && $fprview_settings.button_hide === 'on'}
	    $('.fprview-more-info').parent().mouseenter(function () {
	    	$(this).find('.fprview-more-info').css('display', 'block');
	    });
	    $('.fprview-more-info').parent().mouseleave(function () {
	    	$(this).find('.fprview-more-info').css('display', 'none');
	    });
	    {/if}

	};

	return {
		initModule: initModule
	};
	//------------------- END PUBLIC METHODS ----------------------
}());