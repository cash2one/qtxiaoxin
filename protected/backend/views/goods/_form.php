<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/My97DatePicker/WdatePicker.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/textarea_good.js"></script>
<style type="text/css">
.radioTypeBox { display: inline-block; margin-right: 10px; }
.radioTypeBox label { font-weight: 100; }
.bandType{
    display:none;
}
.bandTypeShow{
    display: table-row;
}
.bandTypeBox input{
    margin-right:10px;
    margin-bottom:5px;
}

</style>
<div class="box">
    <div class="form tableBox">
    <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'business-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation'=>false,
            'htmlOptions'=>array('enctype'=>'multipart/form-data'),
    )); ?>
        <?php if($model->isNewRecord){$model->visible=1;} ?>
        <?php echo $form->errorSummary($model); ?>
        <table class="tableForm">
            <thead></thead>
            <tbody>
                <tr>
                    <td class="td_label">所属商家* ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->dropDownList($model,'bid',Business::getDataArr(true),array('empty' => '--选择商家--','datatype'=>'*','nullmsg'=>'请选择商家！','errormsg'=>'')); ?>
                            <?php echo $form->error($model,'bid'); ?> 
                        </div>
                        <span class="Validform_checktip "></span>
                    </td> 
                </tr>
                <tr>
                    <td class="td_label">物品类型* ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->radioButtonList($model,'type',MallGoods::getGoodTypeArr(),array('template' => '<div class="radioTypeBox">{input} {label}</div>', 'separator' => ' ')); ?>
                            <?php echo $form->error($model,'type'); ?> 
                        </div>
                        <span class="Validform_checktip "></span>
                    </td> 
                </tr>
                <tr class="bandType <?php echo $model->type == 1 ? 'bandTypeShow' : '';?>">
                    <td class="td_label" style="width:100px;">商品子类型* ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->radioButtonList($model,'subtype',MallGoods::getSubGoodTypeArr(),array('template' => '<div class="radioTypeBox">{input} {label}</div>', 'separator' => ' ')); ?>
                            <?php echo $form->error($model,'subtype'); ?> 
                        </div>

                        <span class="Validform_checktip " id="subTypeTip"></span>
                        <input type="hidden" id="bandTypeStatus" value="<?php echo $model->subtype;?>">
                    </td> 
                </tr>

                <tr class="bandType <?php echo $model->type == 1 ? 'bandTypeShow' : '';?>">
                    <td class="td_label">取货地址* ：</td>

                    <td>
                        <?php if(isset($subs) && $subs): ?>
                            商家:<div style="display: inline;"> 
                                <select id="MallGoods_bid_tmp">
                                    <?php foreach(Business::getDataArr(true) as $key=>$val): ?>
                                        <option value="<?php echo $key;?>" <?php echo $key == $subs[0]['bid'] ? 'selected' : '';?>><?php echo $val;?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <span class="Validform_checktip " id="bandAddTip"></span>
                        <?php else: ?>
                            商家:<div style="display: inline;"> 
                                <select id="MallGoods_bid_tmp">
                                    <?php foreach(Business::getDataArr(true) as $key=>$val): ?>
                                        <option value="<?php echo $key;?>" <?php echo $key == $model->bid ? 'selected' : '';?>><?php echo $val;?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                              <span class="Validform_checktip " id="bandAddTip">不能为空</span>
                        <?php endif; ?>
                     
                        <div style="display: inline;" id="getAddress"> 
                            <?php if(isset($subs) && count($subs)):?>
                            <?php foreach($subs as $sub): ?>
                                <div class="bandTypeBox">
                                    <input name="MallGoods[subaddress][]" type="checkbox" value="<?php echo $sub['id']; ?>" <?php if($sub['selected']) echo 'checked="checked"'; ?>><?php echo $sub['name'] . ', ' . $sub['address'] ; ?>
                                </div>
                            <?php endforeach;?>
                            <?php endif; ?>
                        </div>
                        <span class="Validform_checktip "></span>
                    </td> 

                </tr>

                <tr>
                    <td class="td_label">所属分类* ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->dropDownList($model,'mgkid',MallGoodsKind::getDataArr(),array( 'empty' => '--选择分类--','datatype'=>'*','nullmsg'=>'请选择分类!','errormsg'=>'')); ?>
                            <?php echo $form->error($model,'mgkid'); ?>
                        </div>
                        <span class="Validform_checktip "></span>
                    </td> 
                </tr>
                 <tr>
                    <td class="td_label">推荐设置：</td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->checkBox($model,'hot',array('rel'=>'inputSale')); ?>
                            <label for="Information_head" style=" font-weight: 100;">设为推荐</label>
                            <?php echo $form->error($model,'hot'); ?> 
                        </div>
                        <span class="Validform_checktip "></span>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">需要青豆*：</td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->textField($model,'integration',array('style'=>'width: 60px;','datatype'=>'nZ','nullmsg'=>'青豆不能为空!','errormsg'=>'只能填写正整数!')); ?>
                            <?php echo $form->error($model,'integration'); ?>
                        </div>
                        <span class="Validform_checktip "></span>
                    </td>
                </tr>
                <tr class="<?php if($model->isNewRecord){ echo 'number_tr';}?> "> 
                    <td class="td_label">库存*：</td>
                    <td>
                        <input type="hidden" id="physical_number" value="<?php echo $model->number; ?>">
                        <input class="number_tr" type="hidden" id="virtual_number" value="<?php echo $model->countGoodsCards(); ?>">
                        <div style="display: inline;">
                            <?php if(!$model->isNewRecord){?>
                                <span  class="number_trs" style=" display: none;" ><?php echo $model->countGoodsCards(); ?></span>
                            <?php }?>
                            <span <?php if(!$model->isNewRecord){echo ' class="number_tr" style=" display: none;" ';}?> > 
                                <?php echo $form->textField($model,'number',array('style'=>'width: 60px;','datatype'=>'nZ','nullmsg'=>'库存不能为空！','errormsg'=>'只能填写正整数!')); ?>
                                <?php echo $form->error($model,'number'); ?>
                            </span>
                            <span class="Validform_checktip "></span>
                        </div> 
                    </td>
                </tr>
                <tr>
                    <td class="td_label">折扣值：</td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->textField($model,'discount',array('style'=>'width: 60px;','ignore'=>'ignore','datatype'=>'nF','nullmsg'=>'折扣值不能为空！','errormsg'=>'请输入大于或等于0，小于或等于1之间的数字!')); ?>
                            <?php echo $form->error($model,'discount'); ?>
                        </div>
                        <span class="Validform_checktip ">输入大于或等于0，小于或等于1之间的数字</span>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">兑换限制：</td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->textField($model,'quotas',array('style'=>'width: 60px;','datatype'=>'nZ','nullmsg'=>'兑换限制不能为空！','errormsg'=>'只能填写正整数!')); ?>
                            <?php echo $form->error($model,'quotas'); ?>
                        </div>
                        <span class="Validform_checktip ">可兑换商品数量,0代表无限制</span>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">有效时间：</td>
                    <td>
                        <div style="display: inline;">
                           <?php echo $form->textField($model,'mallstarttime',array('rel'=>'datatimeinput','readonly'=>'readonly',"onclick"=>'WdatePicker({maxDate:"#F{$dp.$D(\'MallGoods_mallstarttime\')||\'2080-10-01\'}",dateFmt:"yyyy-MM-dd HH:mm:ss"})','style'=>'width: 180px; height:auto;','class'=>'Wdate','value'=>$model->mallstarttime=='0000-00-00 00:00:00'?'':$model->mallstarttime
)); ?> 
                            <?php echo $form->error($model,'mallstarttime'); ?>
                                &nbsp;至&nbsp;
                                <?php echo $form->textField($model,'mallendtime',array('rel'=>'datatimeinput','readonly'=>'readonly',"onclick"=>'WdatePicker({minDate:"#F{$dp.$D(\'MallGoods_mallendtime\')}",maxDate:"2080-10-01",dateFmt:"yyyy-MM-dd HH:mm:ss"})','style'=>'width: 180px; height:auto;','class'=>'Wdate','value'=>$model->mallendtime=='0000-00-00 00:00:00'?'':$model->mallendtime
)); ?>
                                <?php echo $form->error($model,'mallendtime'); ?> 
                        </div>
                        <span class="Validform_checktip "> </span>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">商品序号：</td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->textField($model,'sort',array('style'=>'width: 60px;','ignore'=>'ignore','datatype'=>'nS','nullmsg'=>'','errormsg'=>'请输入1~999之间的数字!','value'=>($model->sort==1000 || $model->sort==0)?'':$model->sort)); ?>
                            <?php echo $form->error($model,'sort'); ?>
                        </div>
                        <span class="Validform_checktip "></span>
                    </td>
                </tr>
                <?php if(!$model->isNewRecord): ?>
                    <tr>
                        <td class="td_label">特卖活动：</td>
                        <td>
                            <div style="display: inline;">
                                <?php echo $form->checkBox($model,'sale',array('rel'=>'inputSale')); ?>
                                <label for="Information_head" style=" font-weight: 100;">参加特卖</label>
                                <?php echo $form->error($model,'ikid'); ?> 
                            </div>
                            <span class="Validform_checktip "></span>
                        </td>
                    </tr>
                    <tr  class="sale_tr" style="display: none;">
                        <td class="td_label"></td>
                        <td>
                            特卖时段 *：
                            <div style="display: inline;">
                                <?php echo $form->textField($model,'starttime',array('rel'=>'datatimeinput','readonly'=>'readonly',"onclick"=>'WdatePicker({maxDate:"#F{$dp.$D(\'MallGoods_endtime\')||\'2080-10-01\'}",dateFmt:"yyyy-MM-dd HH:mm:ss"})','style'=>'width: 180px; height:auto;','datatype'=>'*','nullmsg'=>'起始时间不能为空!','errormsg'=>'','class'=>'Wdate','value'=>$model->starttime=='0000-00-00 00:00:00'?'':$model->starttime
)); ?>
                                <?php echo $form->error($model,'starttime'); ?> 
                                &nbsp;至&nbsp;
                                <?php echo $form->textField($model,'endtime',array('rel'=>'datatimeinput','readonly'=>'readonly',"onclick"=>'WdatePicker({minDate:"#F{$dp.$D(\'MallGoods_starttime\')}",maxDate:"2080-10-01",dateFmt:"yyyy-MM-dd HH:mm:ss"})','style'=>'width: 180px; height:auto;','datatype'=>'*','nullmsg'=>'结束时间不能为空!','errormsg'=>'','class'=>'Wdate','value'=>$model->endtime=='0000-00-00 00:00:00'?'':$model->endtime
)); ?>
                                <?php echo $form->error($model,'endtime'); ?> 
                            </div>
                            <span id="timeTip" class="Validform_checktip"></span>
                            <span id="pTimeTip" style="display: none;" class="Validform_checktip Validform_wrong">起止时间不能为空！</span>
                        </td>
                    </tr>
                    <tr  class="sale_tr" style="display: none;"> 
                        <td class="td_label"></td>
                        <td>
                            特卖折扣 *：
                            <div style="display: inline;">
                                <?php echo $form->textField($model,'salediscount',array('style'=>'width: 60px;','datatype'=>'nF','nullmsg'=>'特卖折扣不能为空!','errormsg'=>'请输入大于或等于0，小于或等于1之间的数字!')); ?>
                                <?php echo $form->error($model,'salediscount'); ?> 
                            </div>
                            <span class="Validform_checktip"></span>
                        </td>
                    </tr>
                    <tr class="sale_tr" style="display: none;" >
                        <td class="td_label"></td>
                        <td style="padding-bottom: 15px;">
                            特卖数量 *：
                            <div style="display: inline;">
                                <?php echo $form->textField($model,'salenumber',array('style'=>'width: 60px;','datatype'=>'nZ','nullmsg'=>'特卖数量不能为空!','errormsg'=>'只能填写正整数!')); ?>
                                <?php echo $form->error($model,'salenumber'); ?> 
                            </div>
                            <span id="salenumber_R" class="Validform_checktip "></span>
                            <span id="salenumber_S" style="color: red;"></span>
                        </td> 
                    </tr>
                <?php endif; ?>
                <tr>
                    <td class="td_label">商品名称*：</td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->textField($model,'name',array('datatype'=>'*1-20','nullmsg'=>'商品名称不能为空!','errormsg'=>'商品名称长度不大于10个字!','maxlength'=>10)); ?>
                            <input id="goodsidname" type="hidden" value="<?php echo $model->mgid;?>" />
                        </div>
                        <span style="color: #999; font-size: 12px;">&nbsp;&nbsp;此处限制10字以内</span>
                        <span id="Validform_r"  class="Validform_checktip "></span>
                        <span id="Validform_ajx" class="Validform_checktip" style=" display: none;"></span>
                        <input id="rightOrWrong" type="hidden" value="1">
                         <?php echo $form->error($model,'name'); ?>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">可见范围 ：</td>
                    <td>
                        <div style="display: inline;"> 
                            <?php echo $form->dropDownList($model,'visible',MallGoods::getVisibleArr(),array('nullmsg'=>'请选择范围!','errormsg'=>'')); ?>
                            <?php echo $form->error($model,'visible'); ?>
                        </div>
                        <span class="Validform_checktip "></span>
                    </td> 
                </tr> 
                <tr class="search_condition_tab_region"> 
                    <td class="td_label">上架区域：</td>
                    <td class="search_condition_container_region">
                        <div style=" margin-bottom: 10px;"> 
                             <select id="queryprovince">                             
                                <option>选择省份</option>
                                <?php foreach ($province_list as $province):?>
                                    <option value="<?php echo $province['aid'];?>"><?php echo $province['name'];?></option>
                                <?php endforeach;?>
                             </select> 
                         </div>
                        <div id="querycityDiv" style="margin-bottom: 10px;">
                            <!--<a href="javascript:void(0);">全部</a> &nbsp;&nbsp;-->
                            <?php // ?foreach(Area::getCityArr() as $ck=>$cv){ ?>
                                <!--<a href="javascript:void(0);" data-value="<?php // ?echo $ck; ?>"  rel="detail_city">&nbsp;<?php // echo $cv; ?> </a>-->
                                <!--&nbsp;&nbsp;-->
                            <?php //? } ?>
                        </div>
                        <div class="regionBox"  rel="detail_city_area" style=" border: 1px solid #bbcedc; border-bottom: none;  padding:10px 10px; display: none;">

                        </div>
                        <div style=" border: 1px solid #bbcedc; padding:10px 10px; background-color:#f5f5f5;">
                            <div>已选条件：</div>
                            <div class="checkRegionBox " style=" display: inline-block;">
                                <ul class="checkList">
                                <?php if($model->range):?>
                                <?php foreach(explode(",",$model->range) as $aid): ?> 
                                    <li class="itme_<?php echo $aid; ?>"><input type="hidden" class="hide" name="MallGoods[aids][]" value="<?php echo $aid; ?>"><?php echo Area::getAreaNameWithCity($aid); ?><a href="javascript:void(0);" class="closeIoc closeRegion" data-value="<?php echo $aid; ?>" rel="<?php echo $aid; ?>"></a></li>
                                <?php endforeach; ?>
                                <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </td> 
                </tr>
                <tr>
                    <td class="td_label">订购条件：</td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->textArea($model,'condition',array('datatype'=>'*1-30','ignore'=>'ignore','nullmsg'=>'','errormsg'=>'订购条件长度不大于30个字!')); ?>
                            <?php echo $form->error($model,'condition'); ?>
                        </div>
                        <span class="Validform_checktip ">此处限制30字以内</span>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">兑换指引*：</td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->textArea($model,'guide',array('datatype'=>'*','nullmsg'=>'兑换指引不能为空!','errormsg'=>'')); ?>
                            <?php echo $form->error($model,'guide'); ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">商品简介*：</td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->textArea($model,'summery',array('datatype'=>'*1-30','nullmsg'=>'商品简介不能为空!','errormsg'=>'商品简介长度不大于30个字!')); ?>
                            <?php echo $form->error($model,'summery'); ?>
                        </div>
                        <span class="Validform_checktip ">此处限制30字以内</span>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">商品描述*：</td>
                    <td>
                        <div style="display: inline;">
                            <?php echo $form->textArea($model,'remark',array('datatype'=>'*','nullmsg'=>'商品描述不能为空!','errormsg'=>'')); ?>
                            <?php echo $form->error($model,'remark'); ?>
                        </div>
                        <div class="contentTip Validform_checktip Validform_wrong" style="display: none;"> 商品描述不能为空！</div>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">小图*：</td>
                    <td>
                        <div style="display: inline;"> 
                             <?php if(!$model->isNewRecord){ ?>
                            <!-- 编辑 修改-->
                                <?php echo $form->fileField($model,'image',array('rel'=>'previewNewLogo','onchange'=>'previewImg(this)')); ?>
                            <?php }else{ ?>
                                <?php echo $form->fileField($model,'image',array('rel'=>'previewNewLogo','onchange'=>'previewImg(this)','datatype'=>'*','nullmsg'=>'商品小图不能为空！')); ?>
                            <?php }?>
                                <?php echo $form->error($model,'image'); ?>
                            <span style="color: #999; font-size: 12px">建议图片比例为226*208，仅支持JPG，PNG格式上传</span>
                        </div>
                        <span class="Validform_checktip "></span>
                        <div id="previewNewLogo" class="previewMax_box" ><img style="height: 208px;" src="<?php echo $model->image; ?>"></div>
                    </td>
                </tr>
                <tr>
                    <td class="td_label">大图*：</td>
                    
                    <td>
                        <div id="imgBox"> 
                            <?php foreach($model->getGoodBigImages() as $bg): ?>
                            <div class="fileBox">
                                <div id ="imgFileBox_1"  class="imgFileBox"> 
                                    <div class="prevFileBox">
                                        <img src="<?php echo $bg['url']; ?>">
                                        <input type="hidden" name="oldbigimages[]" value="<?php echo $bg['url']; ?>">
                                    </div>
                                </div>
                                <div class="dedeBox" style="display: inline-block;">
                                    <a href="javascript:void(0);" class="btn btn-primary" rel="deleImgFile">删除图片</a> 
                                </div>
                            </div>
                            <?php endforeach; ?> 
                            <div class="fileBox">
                                <div id ="imgFileBox_1"  class="imgFileBox" style="width: 640px;">
                                    <div id="inputFileBox_1" style="position: relative; float: left; height: 190px; zoom: 1; width: 640px;">
                                        <div class="inputFileBox"  style="float: left;">
                                            <input id="bigimage_1" type="file" name="bigimage[1]" onchange="preview(this)" datatyp="*" nullmsg="商品小图不能为空！" rel="1">
                                        </div>
                                        <span style="position:absolute; display: block; float: left; left:195px; color: #999; font-size: 12px; bottom: 0;">建议图片比例为640*300，仅支持JPG，PNG格式上传</span>
                                    </div> 
                                    <div id="prevFileBox_1" class="prevFileBox" style="display: none;"> 
                                    </div> 
                                </div>
                                <div id="deleImgBox_1" class="dedeBox">
                                    <a href="javascript:void(0);" class="btn btn-primary" rel="deleImgFile">删除图片</a> 
                                </div>
                            </div>
                        </div>
                        <div>
                        <span id="fileTip" style="display: none; margin-left: 0;" class="Validform_checktip Validform_wrong">请至少添加一张图片</span>
                        </div> 
                    </td>
                </tr> 
                <tr>
                    <td></td>
                    <td>
                        <a href="javascript:void(0);" rel="postFrom" class="btn btn-primary"><?php echo $model->isNewRecord ? '创 建' : '保 存';?></a>
                    <?php if(!$model->isNewRecord && !$model->state): ?>
                        &nbsp;&nbsp;<a class="btn btn-default" href="<?php echo Yii::app()->createUrl('goods/delete/'.$model->mgid);?>"> 删 除 </a>
                    <?php endif; ?>
                    </td> 
                </tr>
            </tbody>
            <tfoot></tfoot>
        </table> 
        <?php $this->endWidget(); ?> 
     </div><!-- form --> 
<script type="text/javascript"> 
    var regionValue = ',';
    //选择省份    
    $("#queryprovince").live('change', function(){
        var ajaxareaurl = '<?php echo Yii::app()->createUrl('range/schoolarea');?>';
        var idv = $(this).val();
    	$.ajax({  
            url: ajaxareaurl,   
            type : 'POST',  
            data : {cid:idv},  
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : false,  
            success : function(mydata) { 
                mydata=$.parseJSON(mydata);
                if(mydata.status=='1'){ 
                    var str=[];
                    $("[rel=detail_city_area]").html(''); 
                    $.each(mydata.data,function(i,v){
                         str.push('<a href="javascript:void(0);" style="margin-right:10px;" data-value="'+v.aid+'" rel="detail_city">'+v.name+'</a>');
                    });
                    $("#querycityDiv").html(str.join('')); 
                }
            },  
            error : function() {  
            }  
        });
    });
    //选择城市
    $("[rel=detail_city]").live('click',function(){
       var cid = $(this).data('value'); 
       var name =$(this).text();
        ajaxGetArea(cid);
        var all ='<a href="javascript:void(0);" style="margin-right:10px;" class="cityAll" data-value="'+cid+'" data-city="'+name+'">全部</a>';
        var str=[];
//                <a href="javascript:void(0);" class="itmeRegion" data-city="成都" data-parent="2" data-value="13" rel="2">天府新区</a>
        $("[rel=detail_city_area]").show();
        $.each(ajaxareahtml.data,function(i,v){
            if(v.pid){
               str.push('<a href="javascript:void(0);" style="margin-right:10px;" class="itmeRegion" data-city="'+v.pname+'" data-parent="'+v.pid+'" rel="'+v.pid+'"  data-value="'+v.aid+'">'+v.name+'</a>');
            }
        }); 
        
        $("[rel=detail_city_area]").html(all+str.join(''));
    }); 
    //选择区域
    $(document).on('click','.itmeRegion',function(event){ 
        event.preventDefault();
        var dtaval = $(this).data('value') , textinfo = $(this).text(),cityName = $(this).data('city');
        if(regionValue.indexOf(','+dtaval+',',',') > -1){  
        }else{
            $(this).parent('.regionBox').siblings('div').find('.checkRegionBox ul').find('.itme_'+dtaval).remove(); 
            regionValue+=dtaval+','; 
            var srt = '<li><input type="hidden" class="hide" name="MallGoods[aids][]" value="'+dtaval+'">'+ textinfo+' - '+ cityName +'<a href="javascript:void(0);" class="closeIoc closeRegion" data-value="'+dtaval+ '" rel="'+dtaval +'"></a></li>';
            $(this).parent('.regionBox').siblings('div').find('.checkRegionBox ul').append(srt); 
        } 
        event.stopPropagation();
    });  
    //删除选中 
    $(document).on('click','.closeRegion',function(){
        var itmeVal = $(this).data('value');
        $(this).parent('li').remove();
        var s = regionValue.replace(itmeVal+',',"");
        regionValue = s; 
        //console.log(regionValue);
    });
    //城市区域全选
    $(document).on('click','.cityAll',function(){
        var dataV1 = $(this).data('value');
        $(this).parent('.regionBox').find('a[rel="'+ dataV1 +'"]').click();
    }); 

    ajaxareaurl = "<?php echo Yii::app()->createUrl('range/schoolarea');?>";
    ajaxareahtml = "";
    function ajaxGetArea(cid){//请求城市区域
        $.ajax({  
            url: ajaxareaurl,   
            type : 'POST',  
            data : {cid:cid},  
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : false,  
            success : function(mydata) {  
                mydata=$.parseJSON(mydata);
                ajaxareahtml = mydata;
            },  
            error : function() {  
            }  
        });
    }

    var Valid = $('#business-form').Validform({//表单验证
        tiptype:2,
        showAllError:true,
        ignoreHidden:true,
        postonce:true,
        datatype:{//传入自定义datatype类型 ; 
            "tel-3" : /^(\d{3,4}-)?\d{7,8}$/, 
            "nZ"    : /^(0|[1-9][0-9]*)$/,
            "nF"     :/^(?:0\.\d+|[01](?:\.0)?)$/,
            "nS"    : /^([1-9]\d{0,2})$/,
             "need2":function(gets,obj,curform,regxp){
                    var need=1,
                        numselected=curform.find("input[name='"+obj.attr("name")+"']:checked").length;
                     
                    return  numselected >= need ? true : "请至少选择"+need+"项！";
                } 
        },
        callback:function(data){ 
            var len = $("#imgBox").find('.fileBox').length;
            if($('#rightOrWrong').val()== '1'){ 
                if(len>1){ 
                    var content = tinyMCE.get('MallGoods_remark').getContent(); 
                    if(content.length>0){ 
                        if($('#MallGoods_type input[type=radio]:checked')){
                            //alert($('#MallGoods_sale').attr('checked'));
                            if($('#MallGoods_sale').attr('checked')=='checked'){ 
                                var goodsType = $('#MallGoods_type input[type=radio]:checked').val();
                                var discount = $('#MallGoods_salenumber').val();
                                if(discount){ 
                                }else{
                                    discount = '0';
                                }
                                var number = '';
                                if(goodsType=='0'){ 
                                     number = $('#MallGoods_number').val(); 
                                }else{ 
                                     number = $('#virtual_number').val();
                                }
                               if(parseInt(number)>=parseInt(discount)){ 
                                 $("[rel=postFrom]").attr("disabled","disabled");
                                 $("#imgBox .fileBox").last().remove();  
                                   return true;
                               }else{ 
                                   return false; 
                               }
                            }else{ 
                                $("[rel=postFrom]").attr("disabled","disabled");
                                $("#imgBox .fileBox").last().remove(); 
                                return true; 
                            } 
                         }else{
                             $("[rel=postFrom]").attr("disabled","disabled");
                             $("#imgBox .fileBox").last().remove(); 
                             return true;
                         } 
                     }else{
                        return false;  
                     }
                }else{ 
                     return false;  
                }
            }else{ 
               return false;  
            } 
        }
    }); 
    //删除大图
    $(document).on('click','[rel=deleImgFile]',function(){
        $(this).parents('.fileBox').remove();
    });
    //大图预览添加
    var box = 1;
    function preview(file){ 
        box += 1;
        var imFile ='<div class="fileBox">'
                +'<div id ="imgFileBox_'+ box +'"  class="imgFileBox" style="width: 640px;">'
                +'<div id="inputFileBox_'+ box +'" style="position: relative; float: left; height: 190px; zoom: 1; width: 640px;"><div class="inputFileBox">'
                +'<input id="bigimage_'+ box +'" datatyp="*" nullmsg="商品小图不能为空！" type="file" name="bigimage['+ box +']" onchange="preview(this)" rel="'+ box +'">'
                +'</div><span style="position:absolute; display: block; float: left; left:195px; color: #999; font-size: 12px bottom: 0;">建议图片比例为640*300，仅支持JPG，PNG格式上传</span></div>'
                +'<div id="prevFileBox_'+ box +'" class="prevFileBox" style="display: none;"></div> </div>'
                +'<div id="deleImgBox_'+ box +'" class="dedeBox"><a href="javascript:void(0);" class="btn btn-primary" rel="deleImgFile">删除图片</a></div></div>';
        var preview = $("#"+file.id).attr('rel'); 
        var prevDiv = document.getElementById("prevFileBox_"+preview);
        var prevInput = document.getElementById("inputFileBox_"+preview);
        var deleImg = document.getElementById("deleImgBox_"+preview);
        var fileTip = document.getElementById("fileTip");
        var perHtml = prevDiv.innerHTML; 
        var size = file.size / 1024;  
        if(size>10){
            alert("附件不能大于10M");
        }else{ 
            var filepath = file.value;  
            var re = /(\\+)/g; 
            var filename=filepath.replace(re,"#"); 
            var one=filename.split("#"); 
            var two=one[one.length-1]; 
            var three=two.split("."); 
            var last=three[three.length-1]; 
            var tp ="jpg,JPG,png,PNG";
            var rs=tp.indexOf(last); 
            if(rs>=0){
                if (file.files && file.files[0]){ 
                    var reader = new FileReader();
                    reader.onload = function(evt){
                        prevInput.style.display='none';
                        prevDiv.style.display='';
                        deleImg.style.display='inline-block';
                        prevDiv.innerHTML ='<img src="' + evt.target.result + '" />'; 
                    } 
                    reader.readAsDataURL(file.files[0]);
                    $("#imgBox").append(imFile);
                    fileTip.style.display='none';
                }else {  
                    prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
                }
            }else{ 
                file.value = '';
                prevDiv.innerHTML = perHtml;
                alert("您选择的上传文件不是有效的图片文件！");
                return false;
            }
        } 
    }
    //小图预览
    function previewImg(file){ 
        var preview = $("#"+file.id).attr('rel'); 
        var prevDiv = document.getElementById(preview);
        var perHtml = prevDiv.innerHTML; 
        var size = file.size / 1024;  
        if(size>10){
            alert("附件不能大于10M");
        }else{ 
            var filepath = file.value;  
            var re = /(\\+)/g; 
            var filename=filepath.replace(re,"#"); 
            var one=filename.split("#"); 
            var two=one[one.length-1]; 
            var three=two.split("."); 
            var last=three[three.length-1]; 
            var tp ="jpg,JPG,png,PNG";
            var rs=tp.indexOf(last); 
            if(rs>=0){
                if (file.files && file.files[0]){ 
                var reader = new FileReader();
                reader.onload = function(evt){
                prevDiv.innerHTML = '<img src="' + evt.target.result + '" />';
                }	  
                reader.readAsDataURL(file.files[0]);
            }else { 
                prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
            }
            }else{
                file.value = '';
                prevDiv.innerHTML = perHtml;
                alert("您选择的上传文件不是有效的图片文件！");
                return false;
            }
        } 
    }
    // 创建虚拟卡或实物判断
    $("#MallGoods_type input[type=radio]").change(function(){
        var check = $(this).attr("checked");
        var number = "";
        var discount = $('#MallGoods_salenumber').val();
        if(discount){ 
        }else{
            discount = '0';
        }
        if(check=="checked"){
            if($(this).val()=='0'){
                number = $('#physical_number').val();
                $(".number_trs").hide();
                $(".number_tr").show();
                $('#MallGoods_number').val(number); 
            }else{
                number = $('#virtual_number').val();
                $(".number_trs").show();
                $(".number_tr").hide(); 
            }
        } 
        if($('input[rel=inputSale]:checked').length>0){
            if(parseInt(discount) > parseInt(valueInput)){ 
                if($(this).val()=='1'){ 
                    $("#salenumber_S").text('虚拟卡库存不足，请先创建虚拟卡').show();
                }else{
                    $("#salenumber_S").text('库存不足').show();  
                }
                $("#salenumber_R").hide();
            }else{ 
                $("#salenumber_S").hide();
                $("#salenumber_R").show();
            }  
        } 
    });
    //// 创建虚拟卡或实物判断
    if($("#MallGoods_type input[type=radio]:checked").val()=='1'){
        $(".number_trs").show();
        $(".number_tr").hide();
    }else{
        $(".number_tr").show();
        $(".number_trs").hide();
    }
    //特卖判断
    $('#MallGoods_sale').change(function(){
        var check = $(this).attr("checked");
        if(check=="checked"){  
            $(".sale_tr").show();
        }else{ 
            $(".sale_tr").hide();
            $("#MallGoods_salenumber").val(0);
            $("#salenumber_S").hide();
        }
    });
    //特卖初始化
    if($('#MallGoods_sale').attr("checked")=="checked"){
        $(".sale_tr").show();
    }else{
       $(".sale_tr").hide(); 
    }
    //库存判断
    $('#MallGoods_salenumber').blur(function(){  
        if($("#MallGoods_sale").attr("checked")=="checked"){
            var goodsType = $("#MallGoods_type input[type=radio]:checked").val();
            var discount = $(this).val();
            var number = $('#MallGoods_number').val(); 
             if(discount){ 
             }else{
                 discount = '0';
             }
            if(parseInt(discount) > parseInt(number)){ 
                if(goodsType=='0'){
                    $("#salenumber_S").text('库存不足').show(); 
                }else{
                    $("#salenumber_S").text('虚拟卡库存不足，请先创建虚拟卡').show(); 
                } 
                $("#salenumber_R").hide();
            }else{ 
                $("#salenumber_S").hide();
                $("#salenumber_R").show();
            }
        } 
    });
    //判断库存特卖数
    $("#MallGoods_number").change(function(){
        if($('#MallGoods_sale').attr("checked")=="checked"){ 
            $('#MallGoods_salenumber').blur();
        }
    });
    //改变商家是验证商品名操作
    $("#MallGoods_bid").change(function(){
        if($("#MallGoods_name").val()){ 
            $("#MallGoods_name").blur();
        }
    })
    //判断商品名是否已使用
    $("#MallGoods_name").blur(function(){
        var ajaxurl ='<?php echo Yii::app()->createUrl('goods/checkname'); ?>';
        var name =$(this).val();
        var bid = $("#MallGoods_bid").find('option:selected').val();
        var mgid =$("#goodsidname").val(); 
        if(bid&&name){
            $('#Validform_r').hide();
            $('#Validform_ajx').removeClass("Validform_wrong");
            $('#Validform_ajx').addClass('Validform_loading').text('正在加载数据..').show(); 
            $.ajax({  
                url: ajaxurl,   
                type : 'POST',  
                data : {bid:bid,name:name,mgid:mgid},  
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',
                async :false,  
                success : function(mydata) { 
                    if(mydata<=0){
                        $('#rightOrWrong').val(1); 
                        $('#Validform_r').show();
                        $('#Validform_ajx').hide();
                        //$('#Validform_r').find('.Validform_checktip').addClass('Validform_right').text('该卡号可以使用');
                    }else{ 
                        $('#rightOrWrong').val(0);
                        $('#Validform_r').hide(); 
                        $('#Validform_ajx').removeClass("Validform_loading");
                        $('#Validform_ajx').addClass('Validform_wrong').text('该商品已经创建！').show();
                    }
                },  
                error : function() { 
                }  
            });
        }
    });
    //用户体验优化
    $(document).click(function(e){ 
        if($(e.target).eq(0).is('body')){ 
        }else{
           tinyMCE.triggerSave(true); 
           var content = tinyMCE.get('MallGoods_remark').getContent();
           if(content.length>0){ 
                $(".contentTip").hide();
            }
             if($('#MallGoods_sale').attr("checked")=="checked"){
                var starttime = $('#MallGoods_starttime').val();
                var endtime = $('#MallGoods_endtime').val();
                if(starttime && endtime){ 
                    $("#timeTip").show();
                    $("#pTimeTip").hide(); 
                }
            }
        }
    });
    //表单提交操作 及验证
    $("[rel=postFrom]").click(function(){ 
        tinyMCE.triggerSave(true);
        var len = $("#imgBox").find('.fileBox').length;
        if(len<=1){
            $("#fileTip").show();
        } 
       var content = tinyMCE.get('MallGoods_remark').getContent();
       if(content.length>0){
           $(".contentTip").hide(); 
        }else{
           $(".contentTip").show(); 
        }
        if($('#MallGoods_sale').attr("checked")=="checked"){
            var starttime = $('#MallGoods_starttime').val();
            var endtime = $('#MallGoods_endtime').val();
            if(starttime==""||endtime==""){
                $("#timeTip").hide();
                $("#pTimeTip").show();
            }
        }
         //$("#imgBox .fileBox").last().remove();
        Valid.resetStatus();
        var subbandTypeCheck=$('#MallGoods_subtype').find('input:checked').length;

        //判断商品类型
        if ($('#bandTypeStatus').val() ==1) {
                
                 if (subbandTypeCheck ==1) {
                     var inputCheck=$('#getAddress').find('input:checked').length;
                    if (inputCheck != 0) {
                        $('#business-form').submit(); 
                    }else{
                        $('#bandAddTip').text('请选择商家地址').addClass('Validform_wrong').show();
                    };
                     
                 }else{
                    $('#subTypeTip').text('请选择商品子类型').addClass('Validform_wrong').show();
                 };
        }else{
             $('#business-form').submit(); 
        }    

        
    });
    //添加鼠标移上的效果
    $(".inputFileBox input").live({
        mouseenter: function () {
            $(this).parent(".inputFileBox").addClass("hoverAdd");
        },
        mouseleave: function () {  
            $(this).parent(".inputFileBox").removeClass("hoverAdd"); 
        }
    });


    //物品类型切换
    var bandType=function(){
        var type=$('#MallGoods_type');
        type.on('change', 'input', function(event) {
            var _left=$(this);
            $('#bandTypeStatus').val(_left.val());
            if (_left.val()=='0') {
                $('.bandType').hide();
            }else{
                $('.bandType').show();
            };
        });

       $('#MallGoods_subtype').on('change', function(event) {
           $('#subTypeTip').text('通过信息验证！').removeClass('Validform_wrong').addClass('Validform_right').show();
       });
       $('#MallGoods_bid_tmp').on('change',  function(event) {
            var val=$(this).val(),
                getAddId=$('#getAddress'),
                url='<?php echo Yii::app()->createUrl("ajax/subbusiness");?>';
            if (val != '') {
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'JSON',
                    data: {bid: val}
                }).done(function(data) {
                    if (data.state=='1' ) {
                        var _html='';
                        $.each(data.data, function(index, val) {
                             _html+='<div class="bandTypeBox">'
                                  +'<input name="MallGoods[subaddress][]" type="checkbox" value="'+val.id+'" >'
                                  +val.name + ', ' + val.address +'</div>';
                        });
                        getAddId.html(_html);
                    }else{
                        getAddId.html('<div class="bandTypeBox">无</div>');
                    }
                })
            };
       });

       $('#getAddress').on('change',function(){
             var inputCheck=$('#getAddress').find('input:checked').length;
             if (inputCheck!=0) {
                  $('#bandAddTip').text('通过信息验证！').removeClass('Validform_wrong').addClass('Validform_right').show();
             };
       })
    }
    $(function(){
        bandType();
    })
    </script>
 </div>