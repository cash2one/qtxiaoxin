<div class="box">
    <div class="form tableBox">
        <form action="" id="business-form" method="post">
            <table class="tableForm">
                <thead></thead>
                <tbody>
                <tr>
                    <td class="td_title_Long">部门名称* ：</td>
                    <td>
                        <div style="display: inline;">
                            <input name="Department[name]" value="<?php echo $model->name; ?>" class="input-large"  maxlength="25" datatype="*1-20" nullmsg="部门名称不能为空！" errormsg="部门名称长度不能大于20个字！"type="text">
                        </div>
                        <span class="Validform_checktip ">名称限制20个字符以内</span>
                        <span class="Validform_checktip "></span>
                    </td>
                </tr>

                <tr>
                    <td class="td_title_Long">学校* ：</td>
                    <td>
                        <div style="display: inline;">
                            <select  name="Department[sid]" style="width:250px;" datatype="*" nullmsg="请选择学校！" id="selectsid" url="<?php echo Yii::app()->createUrl('range/getschoolgrade' );?>">
                                <option  value="">全部</option>
                                <?php foreach($schools as $k=>$v):?>
                                    <option value="<?php echo $k;?>" <?php if($k==$model->sid) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <span class="Validform_checktip "></span>
                    </td>
                </tr>

                </tbody>
            </table>

            <table class="tableForm">
                <thead></thead>
                <tbody>
                <tr>
                    <td class="td_title_Long"></td>
                    <td>
                        <input type="submit" class="btn btn-primary" value="保 存">&nbsp;&nbsp;
                        <a rel="deleLink" class="btn btn-primary" href="javascript:void(0);" data-href="<?php echo Yii::app()->createUrl('part/delete/'.$model->did."?list=1");?>">删  除</a>&nbsp;&nbsp;
                        <a id="sub_cancel" href="<?php echo Yii::app()->createUrl('part/index');?>" class="btn btn-default">取消</a>
                    </td>

                </tr>
                </tbody>
                <tfoot></tfoot>
            </table>
        </form>
    </div>
</div>
<div id="popupBox" class="popupBox"> 
    <div id="popupInfo" style="padding: 30px;"> 
        <div class="centent">温馨提示：是否删除当前部门？</div>
  </div>
    <div style="text-align: center;">
        <a id="isOk" href="" class="btn btn-primary">确定</a> &nbsp;&nbsp;
        <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBox');" class="btn btn-default">取消</a>
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jqueryui/jquery-ui.js"></script> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/prompt.js" ></script>
<script>
    $(function(){
        $('#business-form').Validform({//表单验证
            tiptype:2,
            showAllError:true, 
            postonce:true
        });  

          $('[rel=deleLink] ').click(function(){
            var urls = $(this).data('href');
            $("#isOk").attr('href',urls);
            showPromptsIfonWeb('#popupBox');
        });
    })
</script>
