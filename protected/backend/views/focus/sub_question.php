<div class="box" style="<?php if($qnum%2){ echo 'background-color: #f1f1f1;'; } ?> margin-bottom: 20px;"  >
    <table rel="<?php echo $qnum; ?>" class="tableForm" >
        <tbody> 
            <tr>
                <td class="td_label">问题<?php echo $qnum; ?></td>
                <td>
                    <div style="display: inline;">
                        <input rel="title" size="80" maxlength="80" name="FocusQuestion[<?php echo $qnum; ?>][title]" type="text" datatype='*1-50' nullmsg='问题不能为空！' errormsg='问题不得多于50个字！'>
                    </div>
                    <span class="Validform_checktip">问题限制50字以内</span>
                    <span style="display: none;"  class="tipB Validform_checktip Validform_wrong">不能为空！</span>
                    <span style="display: none;" class="tipWrong Validform_checktip Validform_wrong">&nbsp;只能输入50字以内！</span> 
                    <?php if($qnum==1){ ?>
                    <?php }else{ ?>
                        <a class="delequestion" href="javascript:void(0);" style="display: inline-block;">删除当前问题</a>
                    <?php } ?>
                </td> 
            </tr>
            <tr>
                <td>问题类型：</td>
                <td class="typeOption">
                    <label><input type="radio" checked="checked" name="FocusQuestion[<?php echo $qnum; ?>][type]" value="0" /> 单选</label>
                    &nbsp;&nbsp;
                    <label><input type="radio" name="FocusQuestion[<?php echo $qnum; ?>][type]" value="1" /> 多选</label>
                    &nbsp;&nbsp;
                    <label><input type="radio" name="FocusQuestion[<?php echo $qnum; ?>][type]" value="2" /> 问答</label>
                    &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="new_option" >增加选项</a>
                    <span class="newOptionTip " style=" color:#999999;">每个问题最多只有10个选项</span>
                </td>
            </tr>
            <tr class="inputBox">
                <td>A选项</td> 
                <td>
                    <div style="display: inline;">
                        <input rel="t" size="80" maxlength="80" type="text" value="" name="FocusQuestion[<?php echo $qnum; ?>][item][1]" datatype="*1-50" nullmsg="不能为空！" errormsg="不得多于50个字！"> 
                    </div>
                    <span class="Validform_checktip">选项限制50字以内</span>
                    <span style="display: none;"  class="tipB Validform_checktip Validform_wrong">不能为空！</span>
                    <span style="display: none;" class="tipWrong Validform_checktip Validform_wrong">&nbsp;只能输入50字以内！</span> 
                </td>
            </tr>
            <tr class="inputBox">
                <td>B选项</td> 
                <td>
                    <div style="display: inline;">
                        <input rel="t" size="80" maxlength="80" type="text" value="" name="FocusQuestion[<?php echo $qnum; ?>][item][2]" datatype="*1-50" nullmsg="不能为空！" errormsg="不得多于50个字">
                    </div>
                    <span class="Validform_checktip">选项限制50字以内</span>
                    <span style="display: none;"  class="tipB Validform_checktip Validform_wrong">不能为空！</span>
                    <span style="display: none;" class="tipWrong Validform_checktip Validform_wrong">&nbsp;只能输入50字以内！</span> 
                </td>
            </tr>
            <tr class="textareaBox" style="display: none;">
                <td class="td_label"> </td>
                <td>
                    <!--<textarea style="width: 400px; height: 60px;"></textarea>-->
                </td>
            </tr>
        </tbody> 
    </table>
</div> 