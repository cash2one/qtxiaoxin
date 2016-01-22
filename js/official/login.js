/**
 * 
 * @authors H君 (26228161@qq.com)
 * @date    2014-11-26 14:38:19
 * @version $Id$
 */

			
var login=function(){
	//垂直居中
	var vertical=function(){
		var h=$(window).height(),b=$('body').height();h=(h-b)/2;
		$('body').css({'padding-top': (h-46)+'px'});
	};
	return{
		vertical:vertical
	}
}();

$(window).resize(function() {login.vertical();});

$(function(){
	login.vertical();
	
	$('.login-btn').on('click', function(event) {
		$('#login-submit').submit();
	
	});

	 $(document).keydown(function(event) {
      	var key=event.keyCode;
      	if (key==13) {
      		$('#login-submit').submit();
      	};
      });
});