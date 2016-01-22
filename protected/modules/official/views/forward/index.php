<div class="content">
   <div class="title"><span class="icon icon4"></span>消息转载</div>
   <div class="content-center">
   		<ul class="tag" style="margin-bottom:20px;">
		 	 	<li class="active"><a href="<?php echo Yii::app()->createUrl('official/forward/index');?>">未转发</a></li>
		 	 	<li ><a href="<?php echo Yii::app()->createUrl('official/forward/list');?>" >已转发</a></li>

		 </ul>
       <form id="search-form" action="" method="get">
		 <div class="search">
		 	 <input type="text" name="param[title]" value="<?php if(isset($param['title']) && $param['title'] !== ''){ echo trim($param['title']); } ?>" class="input-xxlarge" placeholder="文章标题" >
		 	 <a id="search" href="javascript:;" class="btn btn-radius btn-pale-green">搜&nbsp;&nbsp;索</a>
		 </div>
         </form>
		 <div class="list">
			 <table class="table table-hover" >
				  <tbody>
                    <?php if(count($forward['models'])): ?>
                    <?php foreach($forward['models'] as $k => $v): ?>
					<tr>
					  <td class="publish">
					  		<div class="author-wrapper upload-tx">
						      	<div class="author clearfix"  id="container">
										<div class="author-img">
                                            <?php if(isset($v['cover']) && $v['cover'] != ''): ?>
                                                <img id="uploadImg" src="<?php echo $v['cover']."?imageView2/3/w/558|imageMogr2/crop/x310"; ?>" alt="logo" ><i style="display:inline-block;height:100%; vertical-align:middle;"></i>
                                            <?php else: ?>
                                                <img id="uploadImg" src="<?php echo Yii::app()->request->baseUrl; ?>/image/official/Tulips.jpg" alt="logo" ><i style="display:inline-block;height:100%; vertical-align:middle;"></i>
                                            <?php endif; ?>
											
										</div>
										<ul class="author-msg">
										    <li class="name">
										  	 	<a class="tit-view" href="<?php echo Yii::app()->createUrl('/official/forward/view', array('eid'=>$v['msgid'])); ?>"><?php echo $v['title']; ?></a>
										    </li>
                                            <li class="edit-img">
                                                公众号ID：<span><?php if (isset($info[$v['infoid']])) echo $info[$v['infoid']]['openid']; ?></span>
                                                公众号名称：<span><?php if (isset($info[$v['infoid']])) echo $info[$v['infoid']]['openname']; ?></span>
                                                发布时间：<span><?php echo Message::formatTime($v['publishtime']); ?></span>
                                            </li>
										</ul>
								</div>
							</div>
					  </td>
					  <td class="operation">
					  	<a href="javascript:;" class="del-btn" data-href="<?php echo Yii::app()->createUrl('/official/forward/do', array('byinfoid'=>$v['infoid'],'msgid'=>$v['msgid'])); ?>"><i class="icon1"></i>转发</a>
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
                   'pages' => $forward['pages'],
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


<!--del begin-->
<div id="delBox" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
 	 <div class="modal-header">
	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	    <h3>提示</h3>
	  </div>
	  <div class="modal-body">
	  		<p>
	  			确定转发此条消息？
	  		</p>
	  </div>
		<div class="modal-footer">
			    <a href="javascript:;" class="btn btn-pale-green btn-mini btn-radius  comfirm">确认</a>
			    <a href="javascript:;" class="btn btn-mini btn-radius"  data-dismiss="modal" aria-hidden="true">关闭</a>
		</div>
</div>
<!--del end-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/bootstrap-transition.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/modal.js" type="text/javascript"></script>
<script>
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

    $(function(){
      	delConfirm();
      	$('#search').click(function(){
	        $('#search-form').submit();
	    });
    })
</script>