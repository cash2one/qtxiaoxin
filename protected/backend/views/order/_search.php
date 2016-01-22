<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
<table class="tableForm searchForm" style="margin-bottom: 10px;"> 
    <tbody valign="middle">
        <tr valign="middle">
            <td width="75px" valign="middle">订单号：</td>
            <td width="220px"><input type="text" style="width:200px;" name="ViewGoodsOrderUserCenter[moid]" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  value="<?php if(isset($MallOrders['moid'])){echo $MallOrders['moid'];} ?>"></td>
            <td width="85px" valign="middle">注册手机：</td>
            <td width="220px"><input type="text" style="width:200px;" name="ViewGoodsOrderUserCenter[mobilephone]" onkeyup="this.value=this.value.replace(/^ +| +$/g,'')"  value="<?php if(isset($MallOrders['mobilephone'])){echo $MallOrders['mobilephone'];} ?>"></td>

            <td width="45px"> 商家：</td>
            <td width="130px">
                <?php $bid = isset($MallOrders['bid'])?$MallOrders['bid']:''; ?>
                <?php echo $form->dropDownList($model,'bid',Business::getDataArr(true),array('empty' => '--全部商家--','options' => array($bid=>array('selected'=>true)))); ?>
            </td>
            
            <td width="45px"> 商品：</td>
            <td width="130px">
                <?php $mgid = isset($MallOrders['mgid'])?$MallOrders['mgid']:''; ?>
                <?php echo $form->dropDownList($model,'mgid',MallGoods::getDataArr(),array('empty' => '--全部商品--','options' => array($mgid=>array('selected'=>true)))); ?>
            </td>

            <td width="45px"> 状态：</td>
            <td width="130px">
                <?php $state = isset($MallOrders['state'])?$MallOrders['state']:''; ?>
                <select name="ViewGoodsOrderUserCenter[state]" id="MallOrders_state">
                    <option value="">--全部--</option>
                    <option value="0" <?php if($state=='0'){?>selected="selected"<?php } ?> >待确认</option>
                    <option value="1" <?php if($state=='1'){?>selected="selected"<?php } ?> >待发货</option>
                    <option value="2" <?php if($state=='2'){?>selected="selected"<?php } ?> >待收货</option>
                    <option value="3" <?php if($state=='3'){?>selected="selected"<?php } ?> >已收货</option>
                </select>
            </td>
            <td class="search"><input type="submit" class="btn btn-primary" value=" 搜 索 "></td>
        </tr>
    </tbody>

</table> 
<?php $this->endWidget(); ?>
<script type="text/javascript"> 
 //选择商家 请求该商家的所有商品
 ajaxgoodsurl = "<?php echo Yii::app()->createUrl('range/goodlist');?>";
$("#ViewGoodsOrderUserCenter_bid").change(function(){
    var bid = $(this).find('option:selected').val();
    var ty = 'all';
    var default_option = '<option value="">--全部商品--</option>';
    $('#Validform_mgid').find('span').removeClass().text('');
    $('#Validform_mgid').find('span').addClass("Validform_checktip");
    $.ajax({  
        url: ajaxgoodsurl,   
        type : 'POST',  
        data : {bid:bid,ty:ty},  
        dataType : 'text',  
        contentType : 'application/x-www-form-urlencoded',  
        async : false,  
        success : function(mydata) {
            $("#ViewGoodsOrderUserCenter_mgid").empty(); 
            var html = default_option + mydata;
            $("#ViewGoodsOrderUserCenter_mgid").append(html); 
            $('#result').empty(); 
            $("#fileChecktip").val(0);
            $("#Validform_file").find('span').remove();
        },  
        error : function() {  
        }  
    });
});

var selected_bid = $("#ViewGoodsOrderUserCenter_bid").val();
var select_mgid = $("#ViewGoodsOrderUserCenter_mgid").val();
if(selected_bid){
    $("#ViewGoodsOrderUserCenter_bid").change();
    $("#ViewGoodsOrderUserCenter_mgid option[value='"+select_mgid+"']").attr("selected","selected");
}
</script>