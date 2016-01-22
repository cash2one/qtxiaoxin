/**
 * @authors H君 (qq:262281610)
 * @date    2014-11-11 10:41:03
 * @version $Id$
 */
;
(function($) {
	var thisWeek=$('#default-week');
	thisWeek.on('click', 'a', function(event) {
		var _left=$(this),
		    action=_left.data('action');
		if (action === 'prev') {

		}else if (action === 'next') {
			
		};

	});
})(Zepto)