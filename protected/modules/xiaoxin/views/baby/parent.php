<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <ul>
               <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/baby/account/'.$child->userid);?>">首页</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/xiaoxin/baby/group/'.$child->userid);?>">班级</a></li>
                <li><a href="<?php echo Yii::app()->createUrl('/xiaoxin/baby/parent/'.$child->userid);?>" class="focus">家长</a></li>
            </ul>
        </div>  
    </div>
    <div class="titleText"><em class="inIco17"></em>我的孩子 > <span><?php echo $child->name; ?></span></div>
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
            <div class="classTableBox classMemberBox">
                <div class=" classInfoTitle ">
                    〓 当前家长
                </div>
                <table class="table"> 
                    <tbody>
                        <tr class="tableHead">
                            <th width="20%"><div class="name" style="width: 140px;">姓名</div></th>
                            <th width="10%">称谓</th>
                            <th width="15%">手机号码</th>
                            <th width="22%">创建时间</th>
                            <th>操作</th>
                        </tr> 
                        <?php if(count($guradians)): ?>
                            <?php foreach($guradians as $data): ?>
                                <tr>
                                    <td><div class="name mobileIoc"><?php echo $data['name']; ?></div></td>
                                    <td><?php echo $data['role']; ?></td>
                                    <td><?php echo $data['mobilephone']; ?></td>
                                    <td><?php echo  date('Y年m月d日',strtotime($data['creationtime'])); ?></td>
                                    <td><a rel="dele" href="javascript:void(0);" data-href="<?php echo Yii::app()->createUrl('/xiaoxin/baby/removeparent/'.$data['id']) ?>?child=<?php echo $child->userid; ?>">移除</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                                <tr class="remindBox">
                                    <td colspan="5" style=" padding: 0;">
                                        <div class="noContent" style="background: #FFF; padding-bottom: 20px;"> 
                                            <span ><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>
                                            <p>空空如也，没有任何数据</p>
                                        </div>
                                    </td>
                                </tr>
                        <?php endif; ?>
                          <tr>
                                <td colspan="5"><a  href="javascript:;"  rel="publicGradeBox" class="btn btn-raed">添加</a></td>
                          </tr>
                    </tbody>
                </table>
                <div class=" classInfoTitle ">
                    〓  已删除
                </div>
                <table class="table"> 
                    <tbody>
                        <tr class="tableHead">
                            <th width="20%"><div class="name" style="width: 140px;">姓名</div></th>
                            <th width="10%">称谓</th>
                            <th width="15%">手机号码</th>
                            <th width="22%">删除时间</th> 
                            <th></th>
                        </tr>
                        <?php if(count($deleted)): ?>
                            <?php foreach($deleted as $data): ?>
                                <tr>
                                    <td><div class="name mobileIoc"><?php echo $data['name']; ?></div></td>
                                    <td><?php echo $data['role']; ?></td>
                                    <td><?php echo $data['mobilephone']; ?></td>
                                    <td><?php echo  date('Y年m月d日',strtotime($data['updatetime'])); ?></td>
                                    <td></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                                <tr class="remindBox">
                                <td colspan="5" style=" padding: 0;">
                                    <div class="noContent" style="background: #FFF; padding-bottom: 20px;"> 
                                        <span ><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>
                                        <p>空空如也，没有任何数据</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="remindBox" class="popupBox"> 
    <div class="remindInfo"> 
        <div id="remindText" class="centent">是否取消当前家长接受信息功能？取消后将接收不到当前班级发的任何信息！</div>
    </div>
    <div class="popupBtn">
        <a id="deleLink" href=""  class="btn btn-raed">确 定</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="hidePormptMaskWeb('#remindBox')" class="btn btn-default">取 消</a>
    </div>
</div>
<div id="publicGradeBox" class="popupBox" style="width:900px;">
    <div class="header">添加家长<a href="javascript:void(0);" class="close" onclick="hidePormptMaskGred('#publicGradeBox')" > </a></div>
    <div class="remindInfo" style="overflow-y: auto;max-height:450px;">
            <div class="gradeTable " style="overflow-x: auto; overflow-y:hidden; width:850px; ">
                <form id="formBoxGrade" action="" method="post">
                    <table class="formBoxGradeTable">
                        <thead>
                            <tr  >
                                <th style="width: 190px;"><div style="width:70px;">姓名</div></th>
                                 <th><div style="width:210px;">称谓</div></th>
                                 <th><div style="width:170px;">手机号码</div></th>
                                 <th><div style="width:170px;">操作</div></th>
                            </tr>
                        </thead>
                        <tbody  id="parentBody">
                                <tr >
                                    <td ><input type="text"  name="name[]" placeholder="请输入家长姓名" maxlength="8"></td>
                                    <td ><input type="text"  name="role[]" placeholder="请输入与孩子的关系"  style="width: 210px;"  maxlength="10"></td>
                                    <td ><input type="text"  class="p-phone" name="mobilephone[]" placeholder="请输入手机号码" style="width: 210px;" onkeyup="inputNumber(this)" onafterpaste="inputNumber(this)"  minlength="11" maxlength="11"></td>
                                    <td > <a  href="javascript:;" data-action="del">移除</td>
                                </tr>
                        </tbody>
                    </table>
                   
                </form>
                <div class="gradeTable-edit">
                    <a href="javascript:;" data-action="add">添加</a>
                </div>
            </div>
    </div>
    <div class="popupBtn"> 
        <a  href="javascript:void(0);"  data-action="confirm" id="parentBtn" class="btn btn-raed">确 定</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="hidePormptMaskGred('#publicGradeBox')" class="btn btn-default">取 消</a>
        <span class="Validform_checktip "><span class="Validform_checktip " id="classValidform"></span> </span>
    </div>
</div> 
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/Validform/validform.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/prompt.js" type="text/javascript"></script>
<script type="text/javascript">
    //删除操作
    $('[rel=dele]').click(function(){ 
        var url = $(this).data('href'); 
        $('#deleLink').attr('href',url);
        showPromptsRemind('#remindBox');
    });
    // $("#parentBtn").click(function(){
    //     $("#formBoxGrade").submit();
    // })

    //添加家长
    $(document).on('click','[rel=publicGradeBox]',function(){ 
        showPromptsRemind('#publicGradeBox');
    });
    $('#publicGradeBox').on('click','a',function(event) {
        var _left=$(this),
            parentBody=$('#parentBody'),
            action=_left.data('action');
        if (action === 'del') {
            _left.parent().parent().remove();
        }else if (action === 'add') {
            var keyUpVal="''";
            var _html=['<tr >',
                       '<td ><input type="text" placeholder="请输入家长姓名" maxlength="10"></td>',
                       '<td ><input type="text" placeholder="请输入与孩子的关系" style="width: 210px;" maxlength="3"></td>',
                       '<td ><input type="text" class="p-phone" placeholder="请输入手机号码" style="width: 210px;"  onkeyup="inputNumber(this)" onafterpaste="inputNumber(this)" maxlength="11"></td>',
                       '<td > <a  href="javascript:;" data-action="del">移除</td>',
                       '</tr>'].join('');
            parentBody.append(_html);
        }else if(action === 'confirm'){
            var tel=parentBody.find('.p-phone'),
                num=0,
                phone=/^1[\d]{10}$/;

            tel.each(function(index, el) {
                var val=$(el).val();

                if (val == '') {
                   $('#classValidform').addClass('Validform_wrong').removeClass('Validform_right').text('请填写联系电话！');
                   return false;
                }else if (!phone.test(val)) {
                   $('#classValidform').addClass('Validform_wrong').removeClass('Validform_right').text('请输入正确的手机号码！');
                   return false;
                }else{
                    num++;
                };
            });
            if (tel.length == 0) {
                  $('#classValidform').addClass('Validform_wrong').removeClass('Validform_right').text('请添加信息！');
                 return false;
            };
            if(num == tel.length){
                 $("#formBoxGrade").submit();
            }
        };
    });

</script>
