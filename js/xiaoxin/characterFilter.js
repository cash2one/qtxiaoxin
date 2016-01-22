/**
 * 
 * @authors H君 (you@example.org)
 * @date    2014-10-28 14:49:30
 * @version $Id$
 */
 var timeCallbcak=function(callbcak){

    if (callbcak.status == 1) {
       
        var url=$('#delayBtn').data('url');
      
        $.ajax({  
            url:url,   
            type : 'POST', 
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : false,  
            success : function(mydata) {   
                var show_data =mydata; 
                $("#setTime").empty();
                $("#setTime").append(show_data); 
                showPromptsRemind('#delayedTxBox');


            },  
            error : function() {  
                    // alert("calc failed");  
            }  
        }); 
       
    }else{

         showPromptsRemind('#sensitiveWordsBox');
         $('#sensitiveTip').text('注：含有“'+callbcak.word+'”敏感词！').show();

    }
}
var callbcak=function(callbcak){
    var box = $("#memberList");
    var cunt =box.find('li').length-1;
    var content =$.trim($("#textareaCont").val()); 
    var nameS = '';
   
             if(parseInt(cunt)>0){
                if(parseInt(content.length)>0&&parseInt(content.length)<=500){
                     box.find('span').each(function(i,e){
                         if(i==parseInt(cunt)-1){
                             nameS +=e.innerHTML;
                         }else{
                             nameS +=e.innerHTML+',';
                         } 
                     });
                      if (callbcak.status == 1) {
                         $("#textareaContVal").val(content);
                         $('#receiveName').val(nameS); 
                         $('#formBoxRegister').submit(); 
                      }else{
                          showPromptsRemind('#sensitiveWordsBox');
                          $('#sensitiveTip').text('注：含有“'+callbcak.word+'”敏感词！').show();
                     };
                 }else{
                    $("#textareaTip").text('内容不能为空！').show(); 
                 } 
            }else{
                if(parseInt(content.length)>0&&parseInt(content.length)<=500){  
                }else{
                    $("#textareaTip").text('内容不能为空！').show(); 
                }
                $('#cuntTip').show();
            }
    

};
 //输入框优化
$('#textareaCont').keydown(function(){
     $("#textareaTip").hide();
});
 function characterFilter(url,val,callbcak){
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'JSON',
        data: {content:val}
    }).done(callbcak) 
}

//发送网络信息
$('#sensitiveWordsBtn').on('click', function(event) {
    var type=$(this).attr('data-val');
    if (type === 'send') {
        var box = $("#memberList");
        var cunt =box.find('li').length;
        var content =$.trim($("#textareaCont").val()); 
        var nameS = '';
         if(parseInt(cunt)>0){
            if(parseInt(content.length)>0&&parseInt(content.length)<=500){
                 box.find('span').each(function(i,e){
                     if(i==parseInt(cunt)-1){
                         nameS +=e.innerHTML;
                     }else{
                         nameS +=e.innerHTML+',';
                     } 
                 });
                 $("#textareaContVal").val(content);
                 $('#receiveName').val(nameS); 
                 $('#formBoxRegister').submit(); 

             }else{
                $("#textareaTip").text('内容不能为空！').show(); 
             } 
        }else{
            if(parseInt(content.length)>0&&parseInt(content.length)<=500){  
            }else{
                $("#textareaTip").text('内容不能为空！').show(); 
            }
            $('#cuntTip').show();
        }
    }else if (type === 'time') {
        var url=$('#delayBtn').data('url');
        $.ajax({  
            url:url,   
            type : 'POST', 
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : false,  
            success : function(mydata) {   
                var show_data =mydata; 
                $("#setTime").empty();
                $("#setTime").append(show_data); 
                showPromptsRemind('#delayedTxBox');

            },  
            error : function() {  
                    // alert("calc failed");  
            }  
        }); 
       
    };
    
    hidePormptMaskWeb('#sensitiveWordsBox');
});