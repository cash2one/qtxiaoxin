/*!
 * 表格行，鼠标放上去变色， ie6,7下拉框美化
 *
 * Copyright 201405-201406, 何挺
 * 
 *调用 如下： 
 */
$(function(){
	//表格行，鼠标放上去变色
	$(".tr:odd").css("background", "#FFFCEA");
	$(".tr:odd").each(function(){
		$(this).hover(function(){
			$(this).css("background-color", "#FFE1FF");
		}, function(){
			$(this).css("background-color", "#FFFCEA");
		});
	});
	$(".tr:even").each(function(){
		$(this).hover(function(){
			$(this).css("background-color", "#FFE1FF");
		}, function(){
			$(this).css("background-color", "#fff");
		});
	}); 
        
    /*ie6,7下拉框美化*/
    if ( $.browser.msie ){
    	if($.browser.version == '7.0' || $.browser.version == '6.0'){
    		$('.select').each(function(i){
			   $(this).parents('.select_border,.select_containers').width($(this).width()+5); 
			 });
    		
    	}
    } 
});

//用户体验优化 
function clickTarget(obj,str){
    $(document).click(function(e){ 
        if($(e.target).eq(0).is(obj)){  
        }else{
            if($(str).is(":visible")){ 
                $(str).hide();
            }else{  
            } 
        }
    }); 
}

//用户体验优化 2
function clickTarget1(obj,str){
    $(document).click(function(e){ 
        if($(e.target).eq(0).is(obj)){  
        }else{
            if(str.is(":visible")){ 
               str.hide();
            }else{  
            } 
        }
    }); 
}

//输入框输入空格判断
function inputBlank(messages){
    var reg=/^\s+$/; 
    //alert(reg.test(messages.value));
    if(!reg.test(messages.value)){ 
      }else{ 
        messages.value =messages.value.replace(/^\s+$/gi,"");
    }
}

//输入框输入数字判断
function inputNumber(messages){
    var reg=/\D/; 
    alert(reg.test(messages.value));
    if(!reg.test(messages.value)){ 
      }else{ 
        messages.value =messages.value.replace(/\D/g,"");
    }
}