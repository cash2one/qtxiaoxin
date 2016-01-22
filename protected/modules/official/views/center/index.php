<div class="content">
	 <div class="title"><span class="icon icon1"></span>个人中心</div>
	 <div class="content-center">
	 	 <ul class="tag">
		 	 	<li class="active"><a href="<?php echo Yii::app()->createUrl('official/center/index');?>">修改资料</a></li>
		 	 	<li ><a href="<?php echo Yii::app()->createUrl('official/center/pwdform');?>" >修改密码</a></li>
		 </ul>
		  <div class="form-horizontal">
            <form action="<?php echo Yii::app()->createUrl('/official/center/index'); ?>" method="post" id="form-sub">
			  <div class="control-group">
			    <label class="control-label words" for="">公&nbsp;众&nbsp;号&nbsp;ID：</label>
			    <div class="controls ">
			      <span ><?php echo $model->openid;?></span>
			    </div>
			  </div>
			  <div class="control-group">
			    <label class="control-label" for="">公众号名称：</label>
			    <div class="controls">
			      <div class="inline">
			      		<input type="text" class="input-large" maxlength="10" name='openName' value="<?php echo $model->openname;?>" datatype="/^[\u4E00-\u9FA5A-Za-z0-9]{6,20}$/"   nullmsg="名称不能为空" >
			      </div>
			      <span class="help-inline">名称为6-10位字符(英文、数字、中文)组成</span>
			      <span class="ValidformTip Validform_checktip" ></span>
			    </div>
			  </div>
			  <div class="control-group">
			    <label class="control-label " for="">头&nbsp;&nbsp;&nbsp;&nbsp;像：</label>
			    <div class="controls ">
			        <div class="author-wrapper upload-tx">
				      	<div class="author clearfix"  id="container">
								<div class="author-img">
									<img  id="uploadImg" onerror="javascript:this.src='<?php echo Yii::app()->request->baseUrl; ?>/image/official/person-one.jpg';this.onerror=null;" src="<?php echo $model->logo.'?imageView2/1/w/50/h/50';?>" alt="" >
								</div>
								<input type="hidden" id="domain" value="<?php echo STORAGE_QINNIU_XIAOXIN_TX; ?>">
								<input type="hidden" id="uptoken_url"  value="<?php echo Yii::app()->createUrl('ajax/officialtoken').'?type=tx';?>">
								<ul class="author-msg">
								    <li class="name">你可以选择一张png/jpg图片（180*180）作为头像</li>
								    <li class="edit-img"><span id="pickfiles">修改头像</span></li>
								</ul>
								<input type="hidden" name="inputFileName" id="file_upload_tmp" value="<?php echo $model->logo;?>">
						</div>
					</div>
			  	</div>
			  </div>
			   <div class="control-group">
			    <label class="control-label" for="">介&nbsp;&nbsp;&nbsp;&nbsp;绍：</label>
			    <div class="controls">
			      <div class="inline">
			      	<textarea name='summary' id="introduction" rows="6" class="input-xxlarge" maxlength="150" datatype="*" nullmsg="介绍内容不能为空"><?php echo $model->summary;?></textarea>
			      </div>
			      
			       <span class="help-inline" style="vertical-align: bottom;">还剩下<span class="red" id="textNum">150</span>个字符</span>
			        <span class="ValidformTip Validform_checktip" style="vertical-align: bottom;"></span>
			    </div>
			  </div>
			 
			  <div class="control-group">
			    <div class="controls">
			   		<div class="double-btn">
                         <a href="javascript:;" class="btn btn-radius btn-pale-green" id="sub-btn">确&nbsp;&nbsp;定</a>
			       </div>
			    </div>
			  </div>
              
             </form>
		</div>
	 </div>

</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/qiniu/js/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/qiniu/js/plupload/i18n/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/qiniu/js/ui.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/qiniu/js/qiniu.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/qiniu/js/main.js"></script>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/official/Validform/validform.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/Validform/Validform_v5.3.2_min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/intValidform.js" type="text/javascript"></script>
<script>
	var introduction=function(){
	      	var introductionInput=$('#introduction'),
	      		introductionLen=introductionInput.val().length;
	      	$('#textNum').text(150-introductionLen);
	      	
	      	introductionInput.keyup(function(event) {
		      	var _left=$(this),
		      		len=_left.val().length;
		      	if (len <= 150) {
		      		$('#textNum').text(150-len);
		      	};
		     });
	      	introductionInput.keydown(function(event) {
		      	var _left=$(this),
		      		len=_left.val().length;
		      	if (len <= 150) {
		      		$('#textNum').text(150-len);
		      	};
		     });
     }
	$(function(){
	  introduction();//文本框字数控制
      updataLoadImg('center'); //上传图片
      Validform.int("#form-sub");//表单验证控件
      $('#sub-btn').click(function(){
            $('#form-sub').submit();
      })
     
    })
</script>