<div class="header">
    <div class="titleText"><em class="inIco21"></em>花名册 <span> </span></div>
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
            <div class="box" style="padding: 15px 0;">
                提供学校人员花名册查询
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
        <div class="box">
            <div class="headBox ">
                <div class="headNav">
                    <ul>
                        <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/phonebook/index');?>">老师</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/phonebook/studentlist');?>" class="focus">学生</a></li> 
                    </ul>
                </div>  
            </div> 
            <div class="classMemberBox" >
                <div style=" padding-bottom: 10px;">
                    <form  action="" method="get">
                        <select id="phonebookSelect" name="Phonebook[schoolid]" url="<?php echo Yii::app()->createUrl('xiaoxin/phonebook/getgrade');?>">
                           <?php foreach($schoollist as $key=>$val):?> 
                               <option value="<?php echo $key?>" <?php if($schoolid==$key){ echo "selected";} ?>><?php echo $val;?></option>
                           <?php endforeach;?>
                        </select>
                        &nbsp;&nbsp;&nbsp;
                        <select id="phonebookClassHid" name="Phonebook[grade]" url="<?php echo Yii::app()->createUrl('xiaoxin/phonebook/getclassbygrade');?>"> 
                            <option value="">全部年级</option>
                            <?php foreach($allGrade as $key=>$val):?>
                               <option value="<?php echo $key?>" <?php if($grade==$key){ echo "selected";} ?>><?php echo $val;?></option>
                           <?php endforeach;?>
                        </select>
                         &nbsp;&nbsp;&nbsp;
                         <select id="phonebookClassCid" name="Phonebook[class]">
                               <option value="">全部班级</option>
                               <?php foreach($allClass as $key=>$val):?>

                                   <option value="<?php echo $val['cid']?>" <?php if($class==$val['cid']){ echo "selected";} ?>><?php echo $val['name']?></option>
                             <?php endforeach;?>
                        </select>
                        &nbsp;&nbsp;&nbsp; 
                        <input style=" *padding: 0px 3px;" placeholder="输入姓名" name="Phonebook[name]" type="text" value="">
                        &nbsp;&nbsp;&nbsp;
                        <input style=" *padding: 3px 10px;" type="submit" class="btn btn-raed" value="搜索">
                    </form>
                </div>
                <table class="table"> 
                    <tbody>
                        <tr class="tableHead">
                            <th width="15%"><div class="name" style="width: 120px;" >姓名</div></th> 
                            <th>班级</th>
                            <th width="20%"><div class="name" style="width: 140px; padding-left: 10px;">联系电话</div></th>
                            <th width="22%">进班时间</th> 
                        </tr>
                        <?php  foreach($allData as $key => $val):?>
                        <tr  >
                            <td><div class="name"><?php echo $val['name']?></div></td>
                            <td><?php echo $val['class'];?></td>
                            <td class="operation">
                                <?php $mobile=""; $client="";  foreach($val['mobilephone'] as $k=>$v):?>
                                    <?php $mobile = $v['mobilephone'];  $client=$v['client']; break;?>
                                <?php endforeach;?>
                                <div class="<?php if($client==1):?> mobileIoc <?php endif;?>" style=" position: relative; width: 145px;*width: 120px; padding-left: 25px;">
                                    <?php if( count($val['mobilephone'])>1): ?>
                                        <div class="mobileBox fright"  style="position: relative;">
                                            <a href="javascript:void(0);" title="手机号" class="mobileHovrer" rel="updateLinkBtn" >&nbsp;</a> 
                                            <div class="courseBox">
                                                <ul>
                                                    <?php foreach($val['mobilephone'] as $k=>$v):?>
                                                    <li><a href="javascript:void(0);" rel="updateLink" data-url="" data-type="1" ><?php if($v['client']):?><em class="mobile mobileIoc"  ></em><?php endif;?><?php echo $v['role']?$v['role']:'家长';?>：<?php echo $v['mobilephone'];?></a></li>
                                                    <?php endforeach;?>
                                             </ul>
                                            </div> 
                                        </div>
                                    <?php endif;?>
                                    <?php  echo $mobile;?> 
                                </div>
                            </td> 
                            <td><?php echo substr($val['time'],0,4)."年".substr($val['time'],5,2)."月".substr($val['time'],8,2)."日";?></td>
                        </tr>
                    <?php endforeach;?>
                        <?php if(empty($allData)):?>
                            <tr class="remindBox">
                                <td colspan="4" style=" padding: 0;">
                                    <div class="noContent" style="background: #FFF; padding-bottom: 20px;"> 
                                        <span ><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>
                                        <p>空空如也，没有任何数据</p>
                                    </div>
                                </td>
                            </tr>
                         <?php endif;?>
                    </tbody>
                </table>
                <?php if($data&& $data['count']>0):?>
                <div id="pager">
                    <span class="fleft"> 共 <?php echo $data['count']?> 人</span>
                    <?php
                    $this->widget('CLinkPager',array(
                            'header'=>'',
                            'firstPageLabel' => '首页',
                            'lastPageLabel' => '末页',
                            'prevPageLabel' => '上一页',
                            'nextPageLabel' => '下一页',
                            'pages' => $data['pages'],
                            'maxButtonCount'=>9
                        )
                    );
                    ?>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        //显示设置弹框
        $('[rel=updateLinkBtn]').click(function(e){  
            clickTarget('[rel=updateLinkBtn]','.courseBox');
            $('.courseBox').hide();
            var hst = '-5px'; 
            var boxs =$(this).siblings('.courseBox');
            if(boxs.height()>200){ 
                hst =-(boxs.height()/2)+'px'; 
            }else{ 
            }
            boxs.css({top:hst}); 
            boxs.show(); 
        });
        
        // 学校联动年级               
        $("#phonebookSelect").change(function(){
           var schoolId = $(this).find("option:selected").val();
           var option='<option value="">全部年级</option>';
           var option1='<option value="">全部班级</option>';
           if(schoolId!=""){
                var url = $(this).attr('url'); 
                 $.getJSON(url, {schoolid: schoolId}, function (mydata) { 
                     var jsonval = $.parseJSON(mydata.allGrade);
                     $.each(jsonval, function (i, v) {
                         option = option + '<option value="' + i + '">' + v + '</option>';
                     });
                     $("#phonebookClassHid").html(option);  
                 });
            }else{
                $("#phonebookClassHid").html(option);
                $("#phonebookClassCid").html(option1);
            }
       }); 
       // 年级联动班级               
        $("#phonebookClassHid").change(function(){
           var schoolId = $("#phonebookSelect").find("option:selected").val();
           var gradeid = $(this).find("option:selected").val();
           var option='<option value="">全部班级</option>';
           if(gradeid!=""&&schoolId!==""){
                var url = $(this).attr('url'); 
                 $.getJSON(url, {schoolid: schoolId,grade_id:gradeid}, function (mydata) { 
                     if(mydata.allGrade){
                        var jsonval = $.parseJSON(mydata.allGrade);
                        $.each(jsonval, function (i, v) { 
                            option = option + '<option value="' + v.cid + '">' + v.name + '</option>';
                        }); 
                        $("#phonebookClassCid").html(option);
                     }else{
                        $("#phonebookClassCid").html(option);
                     }
                      
                 });
            }else{
                $("#phonebookClassCid").html(option);
            }
       }); 
    }); 
</script>