<style>
    #message{ font-size: 18px; min-width: 265px; *width: 265px; margin: 0px auto; position:absolute ; right: 45%; bottom:50px; display: none; z-index: 10000; border-radius: 5px;}
    #message .messageType{ padding:8px 15px; line-height: 30px; -webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;}
    #message .success{  border: 1px solid #fbeed5; background-color: #e95b5f; color: #fbe4e5; }
    #message .error{border: 1px solid #eed3d7; background-color: #e95b5f; color: #fbe4e5; }
   // #message .messageType span{  float: left;}
</style>
<div id="message">
    <?php if ($type=="success"){?>
        <div class="messageType success"><span id="icon-<?php echo $type; ?>">✔</span>&nbsp;&nbsp;<?php echo $msg; ?></div>
        <?php }else{ ?>
        <div class="messageType success" ><span id="icon-<?php echo $type; ?>">✘</span>&nbsp;&nbsp;<?php echo $msg; ?></div>   
    <?php } ?> 
</div>
<script>
    var mtypes ="<?php echo $type; ?>";
    safariMessage($("#icon-"+mtypes),mtypes);
    $('#message').show(); 
    setTimeout( function() {  
        $('#message').slideUp("slow"); 
    },3000);
    function safariMessage(obj,str){
            var Sys = {}; 
            var ua = navigator.userAgent.toLowerCase(); 
            var s;  
            (s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0; 
            if (Sys.safari){ 
                obj.css({
                    display:"inline-block", 
                    width: "20px",
                    height: "16px"
                });
                if(str=="success"){
                    obj.css("background","url('/image/xiaoxin/checkedIco1.png') no-repeat center");
                }else{
                   obj.css("background","url('/image/xiaoxin/checkedIco2.png') no-repeat center"); 
                } 
            } 
        }
        
</script>