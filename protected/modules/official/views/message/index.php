<div class="content">
   <div class="title"><span class="icon icon3"></span>消息管理</div>
   <div class="content-center">
       <form id="search-form" action="" method="get">
		 <div class="search">
		      <select name="param[send]" class="input-small">
		      		<option value="">全部消息</option>
		      		<option value="2" <?php if(isset($param['send']) && $param['send'] === '2'): ?> selected <?php endif; ?>>已发布消息</option>
		      		<option value="1" <?php if(isset($param['send']) && $param['send'] === '1'): ?> selected <?php endif; ?>>未发布消息</option>
		      </select>
		 	 <input type="text" name="param[title]" class="input-xlarge" placeholder="文章标题" value="<?php if(isset($param['title']) && $param['title'] !== ''){ echo trim($param['title']); } ?>">
		 	 <a id="search" href="javascript:;" class="btn btn-radius btn-pale-green">搜&nbsp;&nbsp;索</a>
		 </div>
         </form>
		 <div class="list">
			 <table class="table table-hover" >
				  <tbody>
                  <?php if(count($message['model'])): ?>
                  <?php foreach($message['model'] as $v): ?>
					<tr>
					  <td class="publish">
					  		<div class="author-wrapper upload-tx">
						      	<div class="author clearfix"  id="container">
										<div class="author-img">
                                            <?php if(isset($v->cover) && $v->cover != ''): ?>
                                            <img id="uploadImg" src="<?php echo $v->cover."?imageView2/3/w/558|imageMogr2/crop/x310"; ?>" alt="logo" ><i style="display:inline-block;height:100%; vertical-align:middle;"></i>
                                            <?php else: ?>
                                            <img id="uploadImg" src="<?php echo Yii::app()->request->baseUrl; ?>/image/official/Tulips.jpg" alt="logo" ><i style="display:inline-block;height:100%; vertical-align:middle;"></i>
                                            <?php endif; ?>
										</div>
										<ul class="author-msg">
										    <li class="name"> <?php echo $v->title; ?>
										    <?php if($v->close === '2'): ?>
                                                <a class="btn btn-mini btn-danger published">已封贴</a>
                                            <?php elseif($v->send === '2'): ?>
                                                <a class="btn btn-mini btn-warning published">已发布</a>
                                            <?php elseif($v->send == '1' && isset($v->sendtime) && $v->sendtime != '2001-01-01 00:00:00'): ?>
                                                <a class="btn btn-mini btn-success published">定时发送</a>
					                        <?php endif; ?>
										    </li>
										    <li class="edit-img">公众号ID：<span><?php echo $v->offic->openid; ?></span>
                                                公众号名称：<span><?php echo $v->offic->openname; ?></span>
                                                <?php if($v->send === '2'): ?>
                                                    发布时间：<span><?php echo Message::formatTime($v->publishtime); ?></span>
                                                <?php else: ?>
                                                    <?php if($v->send === '1' && $v->sendtime != '2001-01-01 00:00:00'): ?>
                                                    </span>发布时间：<span><?php echo Message::formatTime($v->sendtime); ?></span>
                                                    <?php else: ?>
                                                    </span>创建时间：<span><?php echo Message::formatTime($v->creationtime); ?></span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </li>
										</ul>
								</div>
							</div>
					  </td>
					  <td class="operation"  style="width:360px;">
							<?php if ($v->send === '1' && isset($v->sendtime) && $v->sendtime == '2001-01-01 00:00:00'): ?>
					  		<a href="javascript:;" class="send send-btn" data-href="<?php echo Yii::app()->createUrl('/official/publish/publish', array('msgid'=>$v->msgid)); ?>"><i class="icon1"></i>发布</a>
							<?php else: ?>
						    <a></a>
							<?php endif; ?>
                            <?php if($v->close === '2'): ?>
					  		<a href="javascript:;" data-href="<?php echo Yii::app()->createUrl('/official/message/getclosereason').'?msgid='.$v->msgid; ?>" class="seal-btn"><i class="icon4"></i>封贴理由</a>
                            <?php else: ?>
                                <a href="<?php echo Yii::app()->createUrl('/official/message/editmsgform').'?eid='.$v->msgid; ?>"><i class="icon2"></i>编辑</a>
                            <?php endif; ?>
					  		<a href="javascript:;" class="last del-btn"  data-href="<?php echo Yii::app()->createUrl('/official/message/delete', array('did'=>$v->msgid)); ?>"><i class="icon3"></i>删除</a>
					  </td>
					</tr>
                  <?php endforeach; ?>
                  <?php else: ?>
					<tr>
                  	<td colspan="3" class="no-content" style="text-align:center;">
                  		<img  src="<?php echo Yii::app()->request->baseUrl; ?>/image/official/noContent.png" alt="" >
                  		<p>空空如也，没有任何消息</p>
                  	</td>
                  </tr>
				  <?php endif; ?>
				  </tbody>
			</table>
		</div>
       <div class="pager">
           <?php
           $this->widget('CLinkPager',array(
                   'header' => '',
                   'firstPageLabel' => '首页',
                   'lastPageLabel' => '末页',
                   'prevPageLabel' => '上一页',
                   'nextPageLabel' => '下一页',
                   'pages' => $message['pages'],
                   'maxButtonCount' => 9,
                   'htmlOptions'=>array(
                       'class'=>'what',   //包含分页链接的div的class
                   )
               )
           );
           ?>
       </div>
   </div>
</div>

<div id="publish" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
 	 <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3>提示</h3>
	  </div>
	  <div class="modal-body">
	  		<p>
	  			确定发布此条信息？
	  		</p>
	  </div>
		<div class="modal-footer">
			    <a href="javascript:;" class="btn btn-pale-green btn-mini btn-radius  comfirm" >确认</a>
			    <a href="javascript:;" class="btn btn-mini btn-radius"  data-dismiss="modal" aria-hidden="true">关闭</a>
		</div>
</div>

<!--del begin-->
<div id="delBox" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>提示</h3>
    </div>
    <div class="modal-body">
        <p >
            确定删除此条消息？
        </p>
    </div>
    <div class="modal-footer">
        <a href="javascript:;" class="btn btn-pale-green btn-mini btn-radius  comfirm">确认</a>
        <a href="javascript:;" class="btn btn-mini btn-radius"  data-dismiss="modal" aria-hidden="true">关闭</a>
    </div>
</div>
<!--del end-->
<div id="sealBox" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>封帖理由</h3>
    </div>
    <div class="modal-body">
        <p id="seal-season">

        </p>
    </div>
    <div class="modal-footer">
        <!--<a href="javascript:;" class="btn btn-pale-green btn-mini btn-radius" data-dismiss="modal" aria-hidden="true">确认</a> -->
        <a href="javascript:;" class="btn btn-mini btn-radius"  data-dismiss="modal" aria-hidden="true">关闭</a>
    </div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/bootstrap-transition.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/modal.js" type="text/javascript"></script>
<script>
	//发布信息
	var publish=function(){
		$('.send').on('click',function(event) {
			$('#publish').modal('show');
		});
	}

	//发布数据
	var sendConfirm=function(){
		var del=$('.operation .send-btn');
		del.on('click', function(event) {
			var href=$(this).data('href');
			$('#publish .comfirm').attr({
				href: href
			});
			$('#publish').modal('show');
		});
		$('#publish').on('click', '.comfirm', function(event) {
			$('#delBox').modal('hide');
		});
	}

    //删除数据
	var delConfirm=function(){
		var del=$('.operation .del-btn');
		del.on('click', function(event) {
			var href=$(this).data('href');
			$('#delBox .comfirm').attr({
				href: href
			});
			$('#delBox').modal('show');
		});
		$('#delBox').on('click', '.comfirm', function(event) {
			$('#delBox').modal('hide');
		});
	}

	//封帖理由
	var sealMsg=function(){
		var sealBtn=$('.operation .seal-btn'),
			sealSeason=$('#seal-season');
		    sealBtn.on('click', function(event) {
			var url=$(this).data('href');
			$.ajax({
				url: url,
				type: 'POST',
				dataType: 'JSON',
				data: {param1: 'value1'},
			}).done(function(data) {
				$('#sealBox').modal('show');
				sealSeason.html(data.reason);
			})
		});
	}
    $(function(){
    	publish();
    	sendConfirm();
      	delConfirm();
      	sealMsg();
      	$('#search').click(function(){
	        $('#search-form').submit();
	    });
    })
</script>