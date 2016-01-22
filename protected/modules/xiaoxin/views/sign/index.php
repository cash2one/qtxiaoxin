<!--我的应用 -->
<div class="header">
 
<div class="titleText"><em class="inIco23"></em>日常工作 > 自定义标签</div>  

</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
            <div class="box" style="padding: 15px 0;">
                设置个性化的签名，以不同的身份发布信息，更方便您发送通知。
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox"> 
        <div class="box" style="padding-top: 10px;"> 
        	  <div class="listTopTite bBottom">标签列表</div>
        	  <div class="signature" id="sign">
        	  		<ul class="default">
                        <?php foreach($arr as $val):?>
        	  			<li>
        	  				<i class="icon"></i><?php echo $val;?>
        	  			</li>
                        <?php endforeach;?>

        	  		</ul>
        	  		<ul class="default diySign">
                        <?php foreach($signs as $val):?>
        	  			<li>
        	  				<i class="icon"></i><?php echo $val->name;?><a href="javascript:;" class="del" data-id="<?php echo $val->id;?>" data-action="del"></a>
        	  			</li>
                        <?php endforeach;?>

        	  		</ul>
        	  		<div class="add">
        	  			
        	  			<input type="text" class="sg" name="name" maxlength="10"><a href="javascript:;" class="add-btn"  data-action="insert"></a>
        	  			<span id="msgTip" style="display:none;margin-top:10px;"> <span class="Validform_checktip Validform_wrong " style="margin:0"></span> </span>
        	  		</div>
        	  		
        	  </div>
        </div>
    </div>
</div>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/validform.css" rel="stylesheet" type="text/css"/> 
 <script>

 	var signFun=function(){
 		var sign=$('#sign');
 		sign.on('click', 'a', function(event) {
 			var _left=$(this),
 			    action=_left.data('action');
 			var url='<?php echo Yii::app()->createUrl("xiaoxin/sign/");?>';
 			
 			if (action === 'del') {
 				url=url+'/'+action;
 				var delId=_left.data('id');
 				$.ajax({
 					url: url,
 					type: 'POST',
 					dataType: 'JSON',
 					data: {id:delId}
 				}).done(function(data) {
 					if (data.status == 1) {
 						_left.parent().remove();
                        AutoHeight(); 
 					}
 				});
                
 			}else if (action === 'insert') {
 				var val=$.trim(_left.prev().val()),
 				url=url+'/'+action;
 				if (val!='') {
 					$.ajax({
	 					url: url,
	 					type: 'POST',
	 					dataType: 'JSON',
	 					data: {name:val}
	 				}).done(function(data) {
	 					if (data.status == 1) {
	 						_html='<li><i class="icon"></i>'+val+'<a href="javascript:;" class="del" data-action="del" data-id="'+data.id+'"></a></li>';
			 				$('.diySign').append(_html);
			 				_left.prev().val('');
                            AutoHeight(); 
	 					}else if (data.status == 0) {
	 						$('#msgTip').css('display','block').find('span').text('保存失败,已存在相同签名').end().animate({opacity: 0}, 2000,function(){
                                 $('#msgTip').hide().css({
                                     'opacity': '1'
                                 });;
                            })  
	 					AutoHeight(); 
	 					};
	 				});
 				}
 				
 			}
 		});
 	}
 	$(function(){
 		signFun();
 	});
 
 </script>