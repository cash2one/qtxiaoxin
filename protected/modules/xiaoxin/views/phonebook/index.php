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
                        <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/phonebook/index');?>" class="focus">老师</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/phonebook/studentlist');?>">学生</a></li> 
                    </ul>
                </div>  
            </div> 
            <div class="classMemberBox" >
                <div style=" padding-bottom: 10px;">
                    <form action="" method="get">
                        <select id="phonebookSelect"  name="Phonebook[schoolid]" url="<?php echo Yii::app()->createUrl('xiaoxin/phonebook/getdepartment');?>">
                            <?php foreach($schoollist as $key=>$val):?>
                               <option value="<?php echo $key?>"  <?php if($schoolid==$key){echo "selected";}?>><?php echo $val;?></option>
                           <?php endforeach;?>
                        </select>
                        &nbsp;&nbsp;&nbsp; 
                        <select id="phonebookDepartment" name="Phonebook[did]">
                            <option value="">全部部门</option>
                           <?php   foreach($allDepartment as $key=>$val):?>
                               <option value="<?php echo $key?>"<?php if($did==$key){echo "selected";}?>><?php echo $val;?></option>
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
                            <th width="20%"><div class="name">姓名</div></th>
                            <th width="15%">部门</th>
                            <th width="20%">联系电话</th>
                        </tr>  
                        <?php if(!empty($allData)):?>
                            <?php  foreach($allData as $key=>$val):?>
                                 <tr>
                                    <td width="20%"><div class="name <?php if( $val['client']==1):?>mobileIoc<?php endif;?>"><?php echo $val['name']?></div></td>
                                    <td width="15%"> <?php foreach($val['department'] as $k=>$v):?><?php echo $v."&nbsp;&nbsp;"?> <?php endforeach;?></td>
                                    <td width="20%"><?php echo $val['mobilephone']?></td>
                                </tr>
                            <?php  endforeach;?>
                        <?php else:?> 
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
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
       $("#phonebookSelect").change(function(){
           var schoolId = $(this).find("option:selected").val();
           var option='<option value="">全部部门</option>';
           if(schoolId!=""){
                var url = $(this).attr('url'); 
                 $.getJSON(url, {schoolid: schoolId}, function (mydata) { 
                     var jsonval = $.parseJSON(mydata.allGrade);
                     $.each(jsonval, function (i, v) {
                         option = option + '<option value="' + i + '">' + v + '</option>';
                     });
                     $("#phonebookDepartment").html(option);  
                 });
            }else{
                $("#phonebookDepartment").html(option);
            }
       }); 
    });
</script>