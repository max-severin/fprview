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

		$(document).on('click', '.more-info', function(event){
			event.preventDefault();

	        $.fancybox({
	            width: '50%',
	            height: '50%',
	            href: $(this).attr('href'),
	            type: 'ajax'
	        });
	    });  
	};

	return {
		initModule: initModule
	};
	//------------------- END PUBLIC METHODS ----------------------
}());