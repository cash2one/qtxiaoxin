 <!--[if lt IE 9]>
	<style type="text/css">
		#ie9-warning{ width:100%;position:absolute;display:none;top:0px;left:0;background:#ffffe1;padding:5px 0;font-size:21px}
		#ie9-warning p{width:960px;margin:0 auto;text-align:center;}
		#ie9-close{margin-top:10px;}
	</style>
	<script>
            $(document).ready(function(){
                var ieCookies =  getCookie("ieCookie");
                if(ieCookies=="hide") {
                    $("#ie9-warning").hide("slow"); 
                }else{
                    $("#ie9-warning").slideToggle("slow");
                }
                $("#ie9-close").click(function(){
                    $("#ie9-warning").hide("slow");
                    setCookie('ieCookie','hide',24*3600)
                });
                //取得cookie  
                function getCookie(name) {  
                    var nameEQ = name + "=";  
                    var ca = document.cookie.split(';');    //把cookie分割成组  
                    for(var i=0;i < ca.length;i++) {  
                    var c = ca[i];                      //取得字符串  
                    while (c.charAt(0)==' ') {          //判断一下字符串有没有前导空格  
                    c = c.substring(1,c.length);      //有的话，从第二位开始取  
                    }  
                    if (c.indexOf(nameEQ) == 0) {       //如果含有我们要的name  
                       return unescape(c.substring(nameEQ.length,c.length));    //解码并截取我们要值  
                       }  
                    }  
                       return false;  
                }   
                //清除cookie  
                function clearCookie(name) {  
                 setCookie(name, "", -1);  
                }  

                //设置cookie  
                function setCookie(name, value, seconds) {  
                    seconds = seconds || 0;   //seconds有值就直接赋值，没有为0，这个根php不一样。  
                    var expires = "";  
                    if (seconds != 0 ) {      //设置cookie生存时间  
                    var date = new Date();  
                    date.setTime(date.getTime()+(seconds*1000));  
                    expires = "; expires="+date.toGMTString();  
                    }  
                    document.cookie = name+"="+escape(value)+expires+"; path=/";   //转码并赋值  
                }  
            });
	</script>
	<div id="ie9-warning" style="z-index: 9999999999;">
		<p>您正在使用 Internet Explorer 浏览器，由于本页面不兼容Internet Explorer 9以下浏览器，在本页面的显示效果可能有差异。
		<br/> 建议您升级到 
		<a href="http://www.microsoft.com/china/windows/internet-explorer/" target="_blank">Internet Explorer 9</a> 
		或以下浏览器：<a href="http://www.mozillaonline.com/">Firefox</a> / 
		<a href="http://www.google.com/chrome/?hl=zh-CN">Chrome</a> / 
		<a href="http://www.apple.com.cn/safari/">Safari</a> / 
		<a href="http://www.operachina.com/">Opera</a> 
		诚心为给您带来的不便致歉！
		<a id="ie9-close" class="close" data-dismiss="alert" href="#">×</a>
		</p>
	</div>
<![endif]--> 