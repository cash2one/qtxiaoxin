<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table class="tableForm searchForm" style="margin-bottom: 10px;"> 
    <tbody valign="middle">
        <tr valign="middle">
			<td width="45px"> 商家：</td>
            <td width="130px">
                <?php $bid = isset($MallGoodsCard['bid'])?$MallGoodsCard['bid']:''; ?>
                <?php echo $form->dropDownList($model,'bid',Business::getDataArr(true),array('empty' => '--全部商家--','options' => array($bid=>array('selected'=>true)))); ?>
            </td>
			
            <td width="45px"> 商品：</td>
            <td width="130px">
                <?php $mgid = isset($MallGoodsCard['mgid'])?$MallGoodsCard['mgid']:''; ?>
                <?php echo $form->dropDownList($model,'mgid',MallGoods::getDataArr(),array('empty' => '--全部商品--','options' => array($mgid=>array('selected'=>true)))); ?>
            </td>

        	<td width="75px"> 售出状态：</td>
            <td width="130px">
                <?php $sold = isset($MallGoodsCard['sold'])?$MallGoodsCard['sold']:''; ?>
                <select name="MallGoodsCard[sold]" id="MallGoodsCard_sold">
	                <option value="">--全部状态--</option>
	                <option value="0" <?php if($sold=='0'){?>selected="selected"<?php } ?> >未售出</option>
	                <option value="1" <?php if($sold=='1'){?>selected="selected"<?php } ?> >已售出</option>
	            </select>
            </td>

            <td width="75px"> 使用状态：</td>
            <td width="130px">
	            <?php $state = isset($MallGoodsCard['state'])?$MallGoodsCard['state']:''; ?>
	            <select name="MallGoodsCard[state]" id="MallGoodsCard_state">
	                <option value="">--全部状态--</option>
	                <option value="0" <?php if($state=='0'){?>selected="selected"<?php } ?> >未使用</option>
	                <option value="1" <?php if($state=='1'){?>selected="selected"<?php } ?> >已使用</option>
	            </select>
        	</td>

<!--            <td width="65px"> 有效期：</td>
            <td width="130px">
                <?php $eff = isset($MallGoodsCard['eff'])?$MallGoodsCard['eff']:''; ?>
                <select name="MallGoodsCard[eff]" id="MallGoodsCard_state">
                    <option value="">--全部状态--</option>
                    <option value="y" <?php if($eff=='y'){?>selected="selected"<?php } ?> >未过期</option>
                    <option value="n" <?php if($eff=='n'){?>selected="selected"<?php } ?> >已过期</option>
                </select>
            </td>  -->

            <td width="45px">卡号：</td>
            <td width="180px"><input type="text" style="width:160px;" name="MallGoodsCard[number]" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  value="<?php if(isset($MallGoodsCard['number'])){echo $MallGoodsCard['number'];} ?>"></td>

            <td class="search"><input type="submit" class="btn btn-primary" value=" 搜 索 "></td>
        </tr>
    </tbody>

</table> 
<?php $this->endWidget(); ?>
<script type="text/javascript"> 
 //选择商家 请求该商家的所有商品
 ajaxgoodsurl = "<?php echo Yii::app()->createUrl('range/goodlist');?>";
$("#MallGoodsCard_bid").change(function(){
    var bid = $(this).find('option:selected').val();
    var default_option = '<option value="">--全部商品--</option>';
    $('#Validform_mgid').find('span').removeClass().text('');
    $('#Validform_mgid').find('span').addClass("Validform_checktip");
    $.ajax({  
        url: ajaxgoodsurl,   
        type : 'POST',  
        data : {bid:bid},  
        dataType : 'text',  
        contentType : 'application/x-www-form-urlencoded',  
        async : false,  
        success : function(mydata) {
            $("#MallGoodsCard_mgid").empty(); 
            var html = default_option + mydata;
            $("#MallGoodsCard_mgid").append(html); 
            $('#result').empty(); 
            $("#fileChecktip").val(0);
            $("#Validform_file").find('span').remove();
        },  
        error : function() {  
        }  
    });
});

var selected_bid = $("#MallGoodsCard_bid").val();
var select_mgid = $("#MallGoodsCard_mgid").val();
if(selected_bid){
    $("#MallGoodsCard_bid").change();
    $("#MallGoodsCard_mgid option[value='"+select_mgid+"']").attr("selected","selected");
}

</script>