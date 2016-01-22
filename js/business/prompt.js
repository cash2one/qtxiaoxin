 /*!
 * 消息 预览弹框  
 *
 * Copyright 201405-201406, 何挺
 * 
 *调用 如下：  
<div id="popupBox" class="popupBox">
<div class="header">广告预览 <a href="javascript:;" class="close" onclick="hidePormptMask('popupBox')" > </a></div>
  <div id="popupInfo"> 
          <h3>文章标题</h3> 
     <div class="prompt">
          <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/1.jpg" width="365px">
      </div>
     <div class="centent">三楼酒吧间摆放壹张圆桌,铺上白布,上面摆放自制泡末梅花鹿一个,旁边摆放圣诞小屋。</div>
  </div> 
 </div>
 <a href="javascript:;" onclick="showPromptsIfon('#popupBox')"></a>
  <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/popupVeiw.js"></script> 
 */
 
 /*
  * 编辑预览弹框
  * @param {字符串} showbar 弹框的class
  * @param {字符串} title 标题框id
  * @param {字符串} text 内容框id  
  */
 function showPrompts(showbar,title,text){ 
    $("#popupInfo").html('');
    var titles = $("#"+title).val();  
    var img = $("#previewNew").html() ;
    var contentText = tinyMCE.getInstanceById(text).getBody().innerHTML;
    if(titles!=''){
        showMask(showbar);
        pormptPos(showbar);
        var str ='<h3>' + titles + '</h3><div class="prompt">' + img + '</div><div class="centent">' + contentText + '</div>';
        $("#popupInfo").html(str);
        $("." + showbar).show();
    }else{ 
    } 
} 
 
/* 
 * 详情预览弹框
 * @param {字符串} showbar 弹框的class  
 */
function showPromptsIfon(showbar){ 
     showMask(showbar);
     pormptPosBox(showbar);
     $("." + showbar).show();
}
 
/* 
 * 详情预览弹框
 * @param {字符串} showbar 弹框的#id 
 */ 
function showPromptsIfonWeb(showbar){ 
     showMaskWeb(showbar);
     pormptPosWeb(showbar);
     $(showbar).show();
}
 
/*
 * 显示蒙板 
 * @param {字符串} showbar 弹框的#id 
 */
function showMask(showbar){ 
    var Box = "hidePormptMask('"+showbar+"')"; 
    //maskCon = "<div class='promptMask' onclick="+Box+"></div>";
    maskCon = "<div class='promptMask'></div>";
    $(maskCon).appendTo($("body"));
    $(".promptMask").css({
            "height":$(document).height(),
            "opacity":"0.7",
            "width":"100%",
            "top":"0",
            "left":"0",
            "background":"#bababa",
            "position":"fixed",
            "z-index":"9999"
    });
}
/* 
 * 显示蒙板
 * @param {字符串} showbar 弹框的#id 
 */
function showMaskWeb(showbar){ 
    var Box = "hidePormptMaskWeb('"+showbar+"')"; 
    //maskCon = "<div class='promptMask' onclick="+Box+"></div>";
    maskCon = "<div class='promptMask'></div>";
    $(maskCon).appendTo($("body"));
    $(".promptMask").css({
            "height":$(document).height(),
            "opacity":"0.7",
            "width":"100%",
            "top":"0",
            "left":"0",
            "background":"#bababa",
            "position":"fixed",
            "z-index":"9999"
    });
} 

/*
 * 弹出框居中设置
 * @param {字符串} showbar 弹框的class  
 */
function pormptPos(showbar){ 
    scrollT = $('#mianOver').scrollTop();
    offX = ($(window).width()-$("." + showbar).width())/2;
    offY = ($(window).height()-$("." + showbar).height())/2 + scrollT;
     if(offY< 250 || offY > 250){
       offY = 250 + scrollT; 
    }
    $("." + showbar).css({
            "left":offX - 100 +  "px",
            "top":offY - 250 + "px"
    });
} 
/*
 * 根据设定框设置弹出框居中设置
 * @param {字符串} showbar 弹框的class 
 */
function pormptPosBox(showbar){ 
    scrollT = $('#mianOver').scrollTop();
    offX = ($('#mianOver').width()-$("." + showbar).width())/2;
    offY = ($('#mianOver').height()-$("." + showbar).height())/2 + scrollT;
    if(offY< 250 || offY > 250){
       offY = 250 + scrollT; 
    }
    $("." + showbar).css({
            "left":offX -50 +  "px",
            "top":offY - 250 + "px"
    }); 
}
 
/*
 * 弹出框居中设置
 * @param {字符串} showbar 弹框的#id  
 */
function pormptPosWeb(showbar){ 
    scrollT = $('#mianOver').scrollTop();
    offX = ($(window).width()-$(showbar).width())/2;
    offY = ($(window).height()-$(showbar).height())/2 + scrollT;
     if(offY< 250 || offY > 250){
       offY = 250 + scrollT; 
    }
    $(showbar).css({
            "left":offX - 100 +  "px",
            "top":offY - 250 + "px"
    });
}
/*
 * 移除弹出框与蒙板
 * @param {字符串} showbar 弹框的class 
 */
function hidePormptMask(showbar){  
    $("." + showbar).hide();
    $(".promptMask").remove(); 
} 

/*
 * 移除弹出框与蒙板
 * @param {字符串} showbar 弹框的#id 
 */
function hidePormptMaskWeb(showbar){ 
    $(showbar).hide();
    $(".promptMask").remove(); 
}
