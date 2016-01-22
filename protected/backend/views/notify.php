<style>
    #message{ font-size: 18px; width: 265px; margin: 0px auto; position:absolute ; right: 20px; bottom:50px; display: none; z-index: 10000; border-radius: 5px;}
    #message .messageType{ padding:8px 15px; line-height: 30px; -webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;}
    #message .success{  border: 1px solid #fbeed5; background-color: #335ea0; color: #ffffff; }
    #message .error{border: 1px solid #eed3d7; background-color: #eeeeee; color: red; }
</style>
<div id="message">
    <?php if ($type=="success"){?>
        <div class="messageType success" id="type-<?php echo $type; ?>"><span id="icon-'.$type.'">✔</span>&nbsp;&nbsp;<?php echo $msg; ?></div>
        <?php }else{ ?>
        <div class="messageType error" id="type-<?php echo $type; ?>"><span id="icon-'.$type.'">✘</span>&nbsp;&nbsp;<?php echo $msg; ?></div>   
       <?php } ?> 
</div>
<script> 
    $('#message').slideDown(); 
    setTimeout( function() { $('#message').slideUp("slow");},3000); 
</script>