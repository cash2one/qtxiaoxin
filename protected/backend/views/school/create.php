<div class="box">
    <div class="form tableBox">
    	<form action="<?php echo Yii::app()->createUrl('school').($update?('/update/'.$model->sid):'/create');?>" id="business-form" method="post">
	        <table class="tableForm">
	            <thead></thead>
	            <tbody>
	                <tr>
	                    <td class="td_title_Long">学校名称* ：</td>
	                    <td>
	                        <div style="display: inline;">  
	                        	<input name="School[name]" value="<?php echo $update==1?$model->name:'';?>" maxlength="25"
                                       datatype="*1-20" nullmsg="学校名称不能为空！" errormsg="学校名称长度不能大于20个字！"
                                       type="text" class="Validform_error">
	                        </div>
	                        <span class="Validform_checktip ">名称限制20个字符以内</span>
	                    </td>
	                </tr>
	                <tr>
	                    <td class="td_title_Long">类型* ：</td>
		                    <td>
		                        <div class="Validform_checktip " style=" display: inline;margin-left:0;">
		                            <span  >
		                                &nbsp;&nbsp;
                                        <?php $kkkk=0;foreach($types as $k=>$v):?>
		                                <input id="Information_kindtop_<?php echo $kkkk;?>" <?php echo (in_array($k,$stid))?"checked='checked'":"";?> value="<?php echo $k;?>" class="selecttype" type="checkbox"  name="selecttype[]"
                                                <?php if($kkkk==0):?>
                                                datatype="need2" nullmsg="请选择您的类型！"
                                                <?php endif;?>
                                                >
		                                <label for="Information_kindtop_<?php echo $kkkk;?>"><?php echo $v;?></label>
		                               &nbsp;&nbsp;
                                        <?php $kkkk++;endforeach;?>
		                            </span> 
		                       		<span class="Validform_checktip "></span>
		                        </div>  
		                        <input id="countKindTop" type="hidden" value="12">
		                    </td>
	                </tr>
	                  <tr>
                        <td class="td_title_Long">省份* ：</td>
                        <td>
                            <div style="display: inline;">
                                <select id="queryprovince" name="city" style="width:150px;" datatype="*" nullmsg="请选择省份！">
                                    <!-- <option value="">全部</option> 必须要填城市-->
                                    <?php if(is_array($allProvinces)) foreach($allProvinces as $k=>$v):?>
                                        <option value="<?php echo $k;?>" <?php if($myprovince==$k) echo "selected='selected'";?>><?php echo $v;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <span class="Validform_checktip "></span>
                        </td>
                    </tr>
	                <tr>
	                    <td class="td_title_Long">城市* ：</td>
	                    <td>
	                        <div style="display: inline;"> 
	                            <select id="querycity" name="city" style="width:150px;" datatype="*" nullmsg="请选择城市！" >
					               <option value="">全部</option>
                                    <?php if(is_array($citys)) foreach($citys as $v):?>
					                <option value="<?php echo $v['aid'];?>"><?php echo $v['name'];?></option>
                                    <?php endforeach;?>
					            </select>                                               
							</div>
							<span class="Validform_checktip "></span>
	                    </td>
	                </tr>
	                <tr>
	                    <td class="td_title_Long">地区* ：</td>
	                    <td>
	                        <div style="display: inline;"> 
	                           <select name="School[aid]" style="width:150px;" datatype="*" nullmsg="请选择地区！" id="queryarea">
					                <option  value="">全部</option>
                                   <?php if(!empty($areas)):?>
                                       <?php foreach($areas as $v):?>
                                           <option  value="<?php echo $v['aid'];?>"><?php echo $v['name'];?></option>
                                       <?php endforeach;?>
                                   <?php endif;?>
					            </select>                                                  
							</div>
							<span class="Validform_checktip "></span>
	                    </td>
	                </tr>
                    <tr>
                        <td class="td_title_Long">套餐* ：</td>
                        <td>
                            <div style="display: inline;"> 
	                           <select name="School[taocan]" style="width:150px;" datatype="*" nullmsg=" " id=" ">
                                    <option value="AB" <?php if($taocan=="AB"){echo "selected";}?>>AB套餐</option>
                                    <option value="C" <?php if($taocan=="C"){echo "selected";}?>>C套餐</option>
					            </select>                                                  
							</div>
							<span class="Validform_checktip "></span>
                            <div style=" color:#999; margin-top: 10px; ">

                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="td_title_Long">定向发送* ：</td>
                        <td>
                            <div style="display: inline;">
                               <input type="radio" name="School[enableddirectsend]" value="0"   <?php if($update==0||($update==1&&$model&&$model->enableddirectsend==0)){ echo "checked=checked"; } ?> >不开启
                               <input type="radio" name="School[enableddirectsend]" value="1" <?php if($update==1&&$model&&$model->enableddirectsend==1){ echo "checked=checked";}?>>开启
                            </div>
                            <span class="Validform_checktip "></span>
                            <div style=" color:#999; margin-top: 10px; ">

                            </div>
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
	                    		<input type="submit" class="btn btn-primary" value="<?php echo $update?'保 存':'创 建';?>">&nbsp;&nbsp;
		                       <!-- <a id="sub_from" href="javascript:void(0);" >创 建</a> -->
                               <?php if($update):?>
                                   <a rel="deleLink" href="javascript:void(0);"  class="btn btn-primary" data-href="<?php echo Yii::app()->createUrl('school/delete/'.$model->sid."?list=1");?>" >删除</a>
                                   &nbsp;&nbsp;
                               <?php endif;?>
		                       <a id="sub_cancel" href="<?php echo Yii::app()->createUrl('school/index');?>" class="btn btn-default">取消</a>
		                </td> 
	                </tr>
	            </tbody>
	            <tfoot></tfoot>
	        </table>
        </form>
    </div>
</div>
<div id="popupBox" class="popupBox">
    <div id="popupInfo" style="padding:20px 30px;">
        <div class="centent">温馨提示：是否删除当前学校？删除学校后将会把该学校所关联的班级、部门、科目一并删除!</div>
    </div>
    <div style="text-align: center;">
        <a id="isOk" href="" class="btn btn-primary">确定</a> &nbsp;&nbsp;
        <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBox');" class="btn btn-default">取消</a>
    </div>
</div> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/prompt.js" ></script>
<script type="text/javascript">
	$(function(){
     var update="<?php echo $update;?>";

     if(update==1){ //编辑状态下
        var aid="<?php echo $model?$model->aid:'';?>";
        var stid="<?php echo $model?$model->stid:'';?>";
        var cityId="<?php echo isset($cityId)?$cityId:'';?>";
        $("#querycity").val(cityId);
        $("#queryarea").val(aid);
     }
     //删除提醒
    $('[rel=deleLink] ').click(function(){
        var urls = $(this).data('href');
        $("#isOk").attr('href',urls);
        showPromptsIfonWeb('#popupBox');
    });
	 $('#business-form').Validform({//表单验证
            tiptype:2,
            showAllError:true, 
            postonce:true,
			datatype:{//传入自定义datatype类型【方式二】;
				"need2":function(gets,obj,curform,regxp){
					var need=1,
						numselected=curform.find("input[name='"+obj.attr("name")+"']:checked").length;
					return  numselected >= need ? true : "请至少选择"+need+"项！";
				},
				
				"max2":function(gets,obj,curform,regxp){
					var atmax=2,
						numselected=curform.find("input[name='"+obj.attr("name")+"']:checked").length;
						
					if(numselected==0){
						return false;
					}else if(numselected>atmax){
						return "最多只能选择"+atmax+"项！";
					}
					return  true;
				}
				
			}
        });  
         //城市地区联动
   $(document).on('change','#queryprovince',function() {
       ajaxareaurl = "<?php echo Yii::app()->createUrl('range/schoolarea');?>";
        var cityid = $(this).find("option:selected").val(); 
        if (cityid) {
            $.ajax({  
                url:ajaxareaurl,
                type : 'Get',
                data : {cid:cityid},  
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {
                    var option ='<option value="">全部</option>';
                    mydata=$.parseJSON(mydata);
                    if(mydata.status=='1'){ 
                        var str=[];
                        $("#querycity").html('');
                        $("#queryarea").html(option);
                        $.each(mydata.data,function(i,v){
                             str.push('<option value="'+v.aid+'">'+v.name+'</option>');
                        });
                        $("#querycity").html(option +str.join('')); 
                    }
                }   
            });
        }else{
            var option ='<option value="">全部</option>';
            $("#querycity").html(option);
            $("#querycity").val('');

        }
   });
    //城市地区联动
   $(document).on('change','#querycity',function() {
        var ajaxareaurl = "<?php echo Yii::app()->createUrl('range/schoolarea');?>"; 
        var cityid = $(this).find("option:selected").val(); 
        if (cityid) {
            $.ajax({  
                url:ajaxareaurl,
                type : 'Get',
                data : {cid:cityid},  
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {
                   var option ='<option value="">全部</option>';
                   mydata=$.parseJSON(mydata);
                   if(mydata.status=='1'){ 
                        var str=[];
                        $("#queryarea").html('');
                        $.each(mydata.data,function(i,v){
                             str.push('<option value="'+v.aid+'">'+v.name+'</option>');
                        }); 
                        $("#queryarea").html(option +str.join('')); 
                    }
                }   
            });
        }else{
            var option ='<option value="">全部</option>';
            $("#queryarea").html(option);
            $("#queryarea").val('');

        }
   });
		 
	})
</script>
