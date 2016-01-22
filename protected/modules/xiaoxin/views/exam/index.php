<!--接收箱消息,通知列表 -->
<div class="header">
    <div class="headBox fright">
        <div class="headNav">
            <ul>
               <li><a href="#"  onclick="location.href.reload();" class="focus">考试列表</a></li>

                <li><a href="<?php echo Yii::app()->createUrl('xiaoxin/exam/create'); ?>" >创建考试</a></li> 

            </ul>
        </div>  
    </div>
    <div class="titleText"><em class="inIco13"></em>日常工作 > <span> 成绩管理</span></div>
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show">
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox">
            <div class="pheader"><em></em>功能说明</div>
            <div class="box" style="padding: 15px;">编辑学生考试成绩，并且可发布给学生家长。</div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
        <div class="box">
            <form id="query_form" method="get" action="" style="overflow: hidden;"> 
                <table class="tableForm searchForm" style="border: none;">
                    <tbody>
                        <tr>
                            <td width="100px">
                                <div class="inputBox">
                                    <select name="Exam[sid]" class="sx" id="selectSchool">
                                        <option value=''>--选择学校--</option>
                                        <?php foreach($schools as $sk=>$sv): ?>
                                            <option value="<?php echo $sk; ?>" <?php if($sk==$query['sid']){echo 'selected="selected"';} ?>><?php echo $sv; ?></option>
                                        <?php endforeach; ?>
                                     </select>
                                </div> 
                            </td>
                            <td width="100px">
                                <div class="inputBox">
                                    <select name="Exam[type]" class="sx" rel="<?php echo $query['type']; ?>">
                                        <option value=''>--考试类型--</option>
                                        <?php foreach($types as $tk=>$tv): ?>
                                            <option value="<?php echo $tk; ?>" <?php if($tk==$query['type']){echo 'selected="selected"';} ?>><?php echo $tv; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                            <td width="100px">
                                <div class="inputBox">
                                    <select name="Exam[cid]" class="sx" rel="<?php echo $query['cid']; ?>" id="selectClass">
                                        <option value=''>--选择班级--</option>
                                    </select>
                                </div>
                            </td>
                            <td width="100px">
                                 <div class="inputBox">
                                    <select name="Exam[subject]" class="sx" id="selectSubject" rel="<?php echo $query['subject']; ?>">
                                        <option value=''>--选择科目--</option>
                                    </select>
                                 </div>
                            </td>
                            <td width="100px" >
                                <div class="inputBox">
                                    <input name="Exam[name]" type="text" value="<?php echo $query['name']; ?>" placeholder="请输入考试名称" style="line-height:20px; height: 38px; *height: auto;">
                                </div>
                            </td>
                            <td class="search">
                                <input type="submit" class="btn btn-raed" value="查询"/>
                            </td>
                            <td></td>
                        </tr>  
                    </tbody>
                </table> 
            </form>
            <div class="classMemberBox" style="padding: 0; overflow: hidden;">
                <table class="table"> 
                    <tbody>
                        <tr class="tableHead">
                            <th width="12%"><div class="name">学校</div></th>
                            <th width="12%"> 名称</th>
                            <th width="10%">类型</th>
                            <th width="16%"><div style="width: 70px;">考试班级</div></th>
                            <th width="16%">科目</th> 
                            <th width="12%"><div style="width: 70px;">考试时间</div></th>
                            <th><div style="width: 45px;">操作</div></th>
                        </tr>
                        <?php if(count($data['model'])):?>
                        <?php foreach($data['model'] as $exam):?>
                        <tr class="tr_examinfo" examId="<?php echo $exam->eid;?>"> 
                            <td class="td_examinfo"><?php $school = School::model()->findByPk($exam->schoolid); echo $school->name; ?></td>
                            <td class="td_examinfo"><?php echo $exam->name; ?></td>
                            <td class="td_examinfo"><?php echo $exam->getExamTypeName(); ?></td>
                            <td class="td_examinfo"><?php echo $exam->getExamClassName(); ?></td>
                            <td class="td_examinfo"><?php echo $exam->getExamsubjectName(); ?></td>
                            <td class="td_examinfo"><?php echo substr($exam->creationtime,0,4).'年'.substr($exam->creationtime,5,2).'月'.substr($exam->creationtime,8,2).'日'; ?></td>
                            <td class="operation"> 
                                <a href="javascript:void(0);" onclick="showPromptsRemind('#remindBox')" rel="remove_member" data-href="<?php echo Yii::app()->createUrl('xiaoxin/exam/delete/'.$exam->eid);?>">删 除</a>
                            </td> 
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr class="remindBox">
                            <td colspan="7" style=" padding: 0;">
                                <div class="noContent" style="background: #FFF; padding-bottom: 20px;"> 
                                    <span ><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/noContent.png"></span>
                                    <p>空空如也，没有任何数据</p>
                                </div>
                            </td>
                        </tr>
                       <?php endif;?>
                    </tbody>
                </table>  
                <div id="pager">    
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

<div id="remindBox" class="popupBox"> 
    <div class="remindInfo"> 
        <div id="remindText" class="centent">是否删除当前考试？ </div>
    </div>
    <div class="popupBtn">
        <a id="deleLink" href=""  class="btn btn-raed">确 定</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="hidePormptMaskWeb('#remindBox')" class="btn btn-default">取 消</a>
    </div>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/prompt.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function(){
         var selectSubject=$('#selectSubject'),
             selectClass=$('#selectClass');
             ajaxurl = "<?php echo Yii::app()->createUrl('ajax/teacherschinfo'); ?>",
             ajaxclassurl = "<?php echo Yii::app()->createUrl('ajax/teacherclass'); ?>";
        var schoolid = $('#selectSchool').val();

        //刷新页面默认值调用
        if(schoolid){
            var sid=schoolid,
                subjecturl = ajaxurl+'?sid='+sid+'&ty=subject',
                classurl = ajaxclassurl+'?sid='+sid;
            loadAjax(selectClass,classurl,'班级',true);
            loadAjax(selectSubject,subjecturl,'科目',true);
        }else{
            var htmlS="<option value=''>--选择科目--</option>",
                htmlC="<option value=''>--选择班级--</option>";
                selectSubject.html(htmlS); 
                selectClass.html(htmlC); 
        }

        //科目关联
        $('#selectSchool').on('change', function(){
            var sid=$('#selectSchool').val(),
            subjecturl = ajaxurl+'?sid='+sid+'&ty=subject',
            classurl = ajaxclassurl+'?sid='+sid;
            if (sid) {
                    loadAjax(selectClass,classurl,'班级',false);
                    loadAjax(selectSubject,subjecturl,'科目',false);
            }else{
                var htmlS="<option value=''>--选择科目--</option>",
                    htmlC="<option value=''>--选择班级--</option>";
                selectSubject.html(htmlS); 
                selectClass.html(htmlC); 
            };
        });

        //刷新页面默认值方法
        function loadAjax(id,url,str,type){
            if (type) {
                var  relId=id.attr('rel');
            };
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'TEXT',
                data: {}
            }).done(function(data) {

                var data=JSON.parse(data),
                    html='';
                    html+='<option value="">全部'+str+'</option>';
                if (data != '') {
                    $.each(data, function(index, val) {
                       // console.log(val);
                        if(str=='科目'){
                            html+='<option value='+index+'>'+val+'</option>'
                        }else{
                            html+='<option value='+val.cid+'>'+val.name+'</option>'
                        }
                        id.html(html);
                    });
                    if(type){
                        id.find('option[value='+relId+']').attr('selected', 'selected');
                    }
                }else{
                    id.html('<option value="">--选择'+str+'--</option>');
                }
            })
            .fail(function() {

                //console.log("网络出错");
            })
        }
       
        //删除操作
        $('[rel=remove_member]').click(function(){ 
            var url = $(this).data('href'); 
            $('#deleLink').attr('href',url);
            showPromptsRemind('#remindBox');
        });
        //显示设置弹框
        $('[rel=updateLinkBtn]').click(function(e){ 
           clickTarget('[rel=updateLinkBtn]','.courseBox');
            $('.courseBox').hide();
            $(this).siblings('.courseBox').show();
            safariOptimize($('.courseBox ul li a em'));
        });
      
        $(".td_examinfo").on("click",function(){
            var examId=$(this).parent().attr("examId");
            var url="<?php echo Yii::app()->createUrl('xiaoxin/exam/update');?>";
            location.href=url+'/'+examId;
        });

        
    });
</script>
