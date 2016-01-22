<div class="content">
   <div class="title"><span class="icon icon1"></span>个人中心</div>
   <div class="content-center">
      <ul class="tag">
          <li ><a href="<?php echo Yii::app()->createUrl('official/center/index');?>">修改资料</a></li>
          <li class="active"><a href="<?php echo Yii::app()->createUrl('official/center/pwdform');?>" >修改密码</a></li>
     </ul>
      <div class="form-horizontal">
              <form action="<?php echo Yii::app()->createUrl('/official/center/Changepwd'); ?>" method="post" id="form-sub">
        <div class="control-group">
          <label class="control-label" for="">原始密码：</label>
          <div class="controls">
            <div class="inline">
              <input type="password" id="defaultPass" name="inputOldPassword" class="input-large" >
            </div>
            <span class="help-inline red" ><?php echo $model->getError( 'inputOldPassword'); ?></span>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="">新&nbsp;&nbsp;密&nbsp;&nbsp;码：</label>
          <div class="controls">
            <div class="inline">
              <input type="password" id="" name="newPassword" class="input-large" datatype="*6-16,pwd6-16"   nullmsg="请输入新密码！" errormsg="密码由6-16位不同数字和字母组合！">
            </div>
             <span class="ValidformTip Validform_checktip" ></span>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="">确认密码：</label>
          <div class="controls">
            <div class="inline">
              <input type="password" id="" name="passwordConfirmation" class="input-large"  recheck="newPassword" datatype="*" nullmsg="请再次输入您的密码！" errormsg="您两次输入的账号密码不一致！">
            </div>
             <span class="ValidformTip Validform_checktip" ></span>
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
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/official/Validform/validform.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/Validform/Validform_v5.3.2_min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/official/intValidform.js" type="text/javascript"></script>
<script>
    $(function(){
        Validform.int("#form-sub");//表单验证控件
        $('#sub-btn').click(function(){
            $('#form-sub').submit();
        })
        $('#defaultPass').focus(function(event) {
           var _left=$(this);
           _left.parent().next().hide();
        });
    })
</script>

