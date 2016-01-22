/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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

//textarea长度验证
function checktext(text) {
    allValid = true;
    for (i = 0; i < text.length; i++) {
        if (text.charAt(i) != " ") {
            allValid = false;
            break;
        }
    }
    return allValid;
} 
 
//输入框字数提示
function gbcount(messages, totals, useds, remains) {
    var max, reg=/^\s+$/; 
    max = totals.value;  
    //alert(reg.test(messages.value));
    if(!reg.test(messages.value)){ 
        if (messages.value.length > max) {
             
            messages.value = messages.value.substring(0, max);
            useds.value = max;
            remains.value = 0;
            $("#remains_text").text(remains.value); 
            //alert('抱歉，你输入的内容已超过'+max+'个字!'); 
        }else {
            
            useds.value = messages.value.length;
            remains.value = max - useds.value;
            $("#remains_text").text(remains.value);
            
        }
    }else{
        
        messages.value=messages.value.replace(/^\s+$/gi,""); 
    } 
} 

//快捷评论输入框提示
function kbcount(messages,kid){
    var reg=/^\s+$/; 
    //alert(reg.test(messages.value));
    if(!reg.test(messages.value)){
        if(messages.value.length>100){ 
            $("#"+kid).parents(".commentsBox").find('.kbcountRedinfo').text('评论不能大于100个字').show(); 
        }else{ 
            $("#"+kid).parents(".commentsBox").find('.kbcountRedinfo').text('评论不能为空').hide();
        }
      }else{ 
        messages.value =messages.value.replace(/^\s+$/gi,"");
    }
}

//详情评论输入框提示
function kbcountInfo(messages,kid){ 
    var reg=/^\s+$/;
    //alert(reg.test(messages.value));
    if(!reg.test(messages.value)){ 
        if(messages.value.length>100){ 
            $("#"+kid).show(); 
        }else{  
           $("#"+kid).hide();
        }
    }else{  
        messages.value=messages.value.replace(/^\s+$/gi,"");  
    }
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
    //alert(reg.test(messages.value));
    if(!reg.test(messages.value)){ 
      }else{ 
        messages.value =messages.value.replace(/\D/g,"");
    }
} 