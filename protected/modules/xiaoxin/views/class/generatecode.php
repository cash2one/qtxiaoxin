<div class="header">
<!--    <div class="headBox fright">
        <div class="headNav">
            <ul>
                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/class/view/'.$class->cid);?>">首页</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/xiaoxin/class/teachers/'.$class->cid);?>" class="focus">成员</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/xiaoxin/class/update/'.$class->cid);?>">设置</a></li>
            </ul>
        </div>  
    </div>-->
    <div class="titleText"><em class="inIco17"></em>我的班级 > <span><?php echo $class->name; ?></span></div>
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
    <div id="contentBox" class="contentBox">
        <div class="box">
            <div class="listTopTite bBottom">生成邀请码</div> 
            <div class="classTableBox ">
                <div class="box">
                    <div class="classInfoTitle">
                        〓 已生成的邀请码
                    </div> 
                    <div class="classMemberBox" style="padding:10px 0; ">
                        <table class="table">

                            <tr class="tableHead">
                            <th width="15%"><div class="name" style="width: 110px; " >邀请码</div></th> 
                                <th width="10%">密码</th>
                                <th width="10%">类型</th>
                                <th width="12%">状态</th>
                                <th width="22%">使用时间</th> 
                                <th width="15%">使用者</th>
                                <th>使用者手机</th>
                            </tr>
                            <?php foreach($data['datas'] as $d): ?>
                            <tr>
                                <td><div style="width: 130px; padding-left: 0px;"><?php echo $d['cdkey']; ?></div></td>
                                 <td><?php echo $d['password']; ?></td>
                                 <td><?php echo $d['useType']; ?></td>
                                 <td><?php echo $d['useState']; ?></td>
                                 <td><?php echo $d['updatetime']?date('Y年m月d日',strtotime($d['updatetime'])):''; ?></td>
                                 <td><?php echo $d['name']; ?></td>
                                 <td><?php echo $d['mobilephone']; ?></td>
                             </tr>
                            <?php endforeach; ?>
                        </table>
                        <div id="pager">
                            <div class="fleft">
                                <a href="<?php echo Yii::app()->createUrl('xiaoxin/class/downloadxls/'.$class->cid);?>" class="btn btn-default">导出</a>
                            </div> &nbsp;
                            <?php    
                                $this->widget('CLinkPager',array(    
                                    'header'=>'',    
                                    'firstPageLabel' => '首页',    
                                    'lastPageLabel' => '末页',    
                                    'prevPageLabel' => '上一页',    
                                    'nextPageLabel' => '下一页',    
                                    'pages' => $data['pager'],    
                                    'maxButtonCount'=>9    
                                    )    
                                );    
                            ?>    
                        </div> 
                    </div>
                </div>
                <div class="formBox" style="padding-bottom: 50px; margin-top: 0">
                    <div class="box" style="padding-top: 0;">
                        <div class="classInfoTitle">
                            〓 生成邀请码
                        </div>
                        <form id="formBoxRegister" action="" method="post">
                            <table class="tableForm">
                                <tbody> 
                                    <tr>
                                        <td>
                                            <span class="inputTitle">数 量：</span>
                                            <div class="inputBox"><input name="Generatecode[number]"  onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')"  placeholder=" " value="" class="medium" type="text" datatype="nS" nullmsg="不能为空！" errormsg="单次最大生成数量为100!"></div>
                                            <span class="Validform_checktip" ></span>  
                                            <div class="info" style="display: none;">单次最大生成数量为100!<span class="dec"><s class="dec1">◆</s><s class="dec2">◆</s></span></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="inputTitle" style="*float: left; *margin-top: 8px;">类 型：</span>
                                            <div class="btn-group" style=" ">
                                                <button rel="btnRadioSex" type="button" class="btn <?php echo $type==1?'btn-raed':'btn-default'; ?> " uid="1">学生</button>
                                                <button rel="btnRadioSex" type="button" class="btn <?php echo $type==0?'btn-raed':'btn-default'; ?>" uid="0">老师</button>
                                            </div>
                                            <input rel="radioSex" type="hidden" name="Generatecode[type]" value="<?php echo $type;?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a rel="formSubmit" href="javascript:void(0);" class="btn btn-raed">生成</a>
                                            &nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="btn btn-default">取消</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/validform.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/Validform_v5.3.2_min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/intValidform.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
        //表单验证控件
        Validform.int("#formBoxRegister");
        //类型选择
        $('[rel=btnRadioSex]').click(function(){
            $("#memberList").find('.userCheck').remove();
            var uid =$(this).attr('uid');
            $('[rel=btnRadioSex]').removeClass('btn-raed').addClass('btn-default');
            $(this).addClass('btn-raed');
            $('input[rel=radioSex]').val(uid); 
        });
        $("[rel=formSubmit]").on("click",function(){
            $("#formBoxRegister").submit();
        })
    }); 
</script>