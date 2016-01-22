
 <div id="msgTmpBox" class="popupBox" style="width: 650px;">
    <div class="header">模板库<a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#msgTmpBox')" > </a></div>
    <div   style=" padding: 0 15px;">
  		<div class="headBox ">
	        <div class="headNav noticeType_select">
	            <ul>
	                <li><a  href="javascript:;" class="focus" data-action="diy">自定义模板</a></li>
	                <li><a  href="javascript:;" data-action="system"> 系统模板</a></li>
	            </ul>
	        </div>  
	    </div>
		<div class="msgContent" >
		    <div class="msgUl msgGiy" >
		    	<ul >
						<?php if(count($myselfs)):?>
						    <?php foreach($myselfs as $val):?>
						        
						        <li class="msgLi">
						         <div style="margin-bottom:10px;"><?php echo $val->content;?> </div>
						         <div style="text-align:right;">
						       	 	<a   style="margin-right:10px;" href="javascript:;"   sid='<?php echo $val->tid ?>' data-url="<?php echo Yii::app()->createUrl('xiaoxin/notice/deltemplate');?>" class="btn btn-raed useBtn">使用</a>
						       		 <a   href="javascript:;"   sid='<?php echo $val->tid ?>' data-url="<?php echo Yii::app()->createUrl('xiaoxin/notice/deltemplate');?>" class="btn btn-default delBtn">删除</a>
						        </div>
						        </li>
						    <?php endforeach;?>
						<?php else: ?>
						    <li>还没有模板呢</li>
						<?php endif;?>
						<li class="noMsg" style="display:none;">还没有模板呢</li>
		    	</ul>
		    	<div class="counts">
		    		共&nbsp;<span><?php echo count($myselfs) ;?></span>&nbsp;条
		    	</div>
		    </div>
		    <div class="msgUl msgSystem" style="display:none;">
		    	<ul>

		    		<?php  if(count($systems)):?>
					 <?php foreach($systems as $val):?>
					     <li class="msgLi">
					         <div style="margin-bottom:10px;"><?php echo $val->content;?> </div>
					         <div style="text-align:right;">
					       	 	<a href="javascript:;"   sid='<?php echo $val->tid ?>' data-url="<?php echo Yii::app()->createUrl('xiaoxin/notice/deltemplate');?>" class="btn btn-raed useBtn">使用</a>
					        </div>
				        </li>
					<?php endforeach;?>
					<?php else: ?>
					  <li> 还没有模板呢</li>
					<?php endif;?>
		    	</ul>
		    	<div class="counts">
		    		共&nbsp;<span><?php echo count($systems) ;?></span>&nbsp;条
		    	</div>
		    </div>
	    </div>
    </div>

</div>

