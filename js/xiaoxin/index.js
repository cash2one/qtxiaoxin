$(function(){
    /* gotop */
   $(".gotop").live("click",function(){
       $("body,html").animate({scrollTop:0},"slow");
   });
   STO = setInterval(scroll_slide,5);
    function scroll_slide(){
        var t;
        if(document.documentElement && document.documentElement.scrollTop){
            t = document.documentElement.scrollTop;
        }else if(document.body){
            t = document.body.scrollTop;
        }
        if(t > 0){$(".gotop").fadeIn(300);}else{ $(".gotop").fadeOut(300)}
    }

   /* 手机图片切换 */
   $(function(){
        var aSlideCon = $('.slideImg li');
        var iSize = aSlideCon.size();
        var iNow = 0;
        var timer = null;
        function slideRun(){
            aSlideCon.stop();
            aSlideCon.eq(iNow).animate({"opacity":1},600).siblings().animate({opacity:0},600);
        }
        autoRun();
        function autoRun(){
            timer = setInterval(function(){
                iNow++;
                if(iNow>iSize-1){ iNow=0;}
                slideRun();
            },3000)
        };
    })

    /* 了解更多 */
    $(".more a, li.function a").click(function(){
        var offset = $("#main2").offset().top;
        $('body,html').animate({scrollTop: offset},800)
    });
    $(".blueBtn").click(function(){
        var offsetDown = $(".downloadBar").offset().top;
        $('body,html').animate({scrollTop: offsetDown},800)
    });
});