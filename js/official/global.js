/**
 * 
 * @authors H君 (26228161@qq.com)
 * @date    2014-11-26 14:38:19
 * @version $Id$
 */
var global={
	resizeH:function(){
		var c=$('.content'),
		h=$(window).height();
		c.css({'minHeight': (h)+'px'});
	},
	navStatus:function(){
		var	nav=$('#nav');
		nav.find('li').hover(function() {
			var _left=$(this);
			if (!_left.hasClass('active')) {
				_left.find('.border-icon').stop().animate({width:'72px'}, 300);
			};
		}, function() {
			var _left=$(this);
			if (!_left.hasClass('active')) {
				_left.find('.border-icon').stop().animate({width:'4px'}, 300);
			};
		});
	}
};
$(function(){
	global.resizeH();
	global.navStatus();
})
$(window).resize(function(event) {
    global.resizeH();
});