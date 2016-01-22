<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/update'). '/' . $model->eid; ?>" class="focus">首页</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/edit') . '/' . $model->eid; ?>">成绩</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/edit'). '/' . $model->eid.'?isEdit=1'; ?>">录入</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/send'). '?eid=' . $model->eid; ?>">发送</a></li> 
            </ul>
        </div>
    </div>
    <div class="titleText"><em class="inIco13"></em>日常工作 > <span> 成绩管理 ></span><span> <?php echo $model->name; ?></span></div>
</div>
<div class="mianBox">
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
        </div>
    </div>
    <div id="contentBox" class="contentBox ">
        <div class="box">
            <div class="exitExam">
                <form id="formBoxRegister" action="" method="post">
                    <div class="classTableBox ">
                        <div class="classInfoTitle">
                            〓 基本信息
                        </div>
                        <table class="table table-bordered table-exit">
                            <tbody>
                            <tr>
                                <td class="classTitleTd">考试类型</td>
                                <td>
                                    <div class="inputBox">
                                         <?php echo Exam::getExamType()[$model->type]; ?>
                                    </div>
                                    <div class="inputBox hidden">
                                        <select name="Exam[type]" id="class_school" datatype="*"
                                                nullmsg="请选择考试类型！" errormsg="" rel=" ">
                                            <option value=''>--考试类型--</option>
                                            <?php foreach ($types as $tk => $tv): ?>
                                                <option
                                                    value="<?php echo $tk; ?>" <?php if ($model->type == $tk) echo 'selected="selected"'; ?>><?php echo $tv; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <span class="Validform_checktip" ></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="classTitleTd">学期</td>
                                <td>
                                    <div class="inputBox"> 
                                        <?php echo $model->term; ?> 
                                    </div>
                                    <div class="inputBox hidden">
                                        <select name="Exam[term]" id="class_school" datatype="*" 
                                                nullmsg="请选择学期！" errormsg="" rel=" ">
                                            <option value=''>--选择学期--</option>
                                            <?php foreach ($terms as $tk => $tv): ?>
                                                <option value="<?php echo $tk; ?>" <?php if ($model->term == $tv) echo 'selected="selected"'; ?>> <?php echo $tv; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <span class="Validform_checktip" ></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="classTitleTd">考试名称</td>
                                <td>
                                    <div class="inputBox" style="display: inline;">
                                        <input id="examNames" name="Exam[name]" disabled="disabled" value="<?php echo $model->name; ?>" class="lg editExamInput" placeholder="请输入考试名称" type="text" datatype="*1-20" nullmsg="请输入考试名称！" style="width: 320px;" errormsg="考试名称不能大于20个字!">
                                    </div>
                                    <span class="Validform_checktip" ></span>  
                                    <div class="info" style="display: none;">考试名称不能大于20个字!<span class="dec"><s class="dec1">◆</s><s class="dec2">◆</s></span></div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="Exam[eid]" value="<?php echo $model->eid; ?>">
                        <input type="button" tip="0" class="btn btn-raed" value="修改信息" style="margin-bottom:20px;" id="editExam">
                </form>
                <div class="classInfoTitle">
                    〓 学校
                </div>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td class="classTitleTd">所在学校</td>
                        <td>
                            <?php $school = School::model()->findByPk($model->schoolid);
                            echo $school->name; ?>
                        </td>
                    </tr>

                    </tbody>
                </table>
                <div class="classInfoTitle">
                    〓 班级
                </div>
                <table class="table table-bordered">
                    <tbody>
                    <?php foreach ($gcinfo as $k => $v): ?>
                        <tr>
                            <td class="classTitleTd"><?php echo $v['gname']; ?></td>

                            <td> <?php $class_str = ''; ?>
                                <?php foreach ($v['classes'] as $ck => $cv): ?>
                                    <?php $class_str = $class_str . $cv . "，"; ?>
                                <?php endforeach; ?>
                                <?php echo rtrim($class_str, "，"); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
                <div class="classInfoTitle">
                    〓 考试科目
                </div>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td class="classTitleTd">科目</td>
                        <td>
                            <?php echo implode("，", $subs); ?>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
</div>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/validform.css" rel="stylesheet" type="text/css"/> 
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/Validform_v5.3.2_min.js"type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/intValidform.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        //表单验证控件
        Validform.int("#formBoxRegister"); 
        // $('#editExam').click(function(event) {
        //     $(this).parent().find('input').removeAttr('disabled');
        // });
        //保存
        $("#editExam").click(function () {
            var s = $(this).attr('tip'); 
            if (s =='0') {
                $('.table-exit').find('input').removeAttr('disabled').addClass('editExamInputHiht');
                $('.table-exit').find('select').parent('.inputBox').removeClass('hidden');
                $('.table-exit').find('select').parent('.inputBox').siblings('.inputBox').hide();
                $(this).val('保存');
                $(this).attr('tip','1');
            }else{ 
                $("#formBoxRegister").submit(); 
            }
        });

    });
</script>