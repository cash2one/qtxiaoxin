<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/My97DatePicker/WdatePicker.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/highcharts/highcharts.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/highcharts/exporting.js"></script> 
<div class="box"> 
    <form>
    <table class="tableForm searchForm" style="margin-bottom: 10px;">
    <tr> 
        <td width="45px">城市：</td>
        <td width="130px">
            <select name="city" id="querycity" >
                <option  value="">全部</option>
                <?php foreach($citys as $k=>$v):?>
                    <option value="<?php echo $k;?>" <?php if($query['city']==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                <?php endforeach;?>
            </select>
        </td>
        <td width="45px"> 区域：</td>
        <td width="130px">
            <select name="area" id="queryarea">
                <option value="">全部</option>
                <?php foreach($areas as $k=>$v):?>
                <option value="<?php echo $k;?>" <?php if($query['area']==$k) echo 'selected="selected"'; ?>><?php echo $v;?></option>
                <?php endforeach;?>
            </select>
        </td>
        <td width="45px"> 学校：</td>
        <td width="240px">
            <select name="sid" style="width: 220px;" id="querysid">
                <option value=''>全部</option>
                <?php foreach($schools as $k=>$v):?>
                    <option value="<?php echo $v['sid'];?>"  <?php if($query['sid']==$v['sid']) echo 'selected="selected"'; ?>><?php echo $v['name'];?></option>
                <?php endforeach;?>
            </select>
        </td>
        <td width="45px"> 用户：</td>
        <td width="130px">
            <select name="identity" id="queryidentity">
                <option  value="">全部</option> 
                <option  value="1" <?php if($query['identity']==1){ echo "selected='selected'";}?>>老师</option>
                <option  value="2" <?php if($query['identity']==2) { echo "selected='selected'";}?>>学生</option>
            </select>
        </td>
        <td width="75px"> 设备类型：</td>
        <td width="130px">
            <select name="deviceType" id="querydeviceType">
                <option  value="">全部</option> 
                <option  value="1" <?php if($query['deviceType']==1){ echo "selected='selected'";}?>>android</option>
                <option  value="2" <?php if($query['deviceType']==2){ echo "selected='selected'";}?>>ios</option>
            </select>
        </td> 
        <td class="search">  
        </td>
    </tr>
    <tr>
        <td colspan="7">
            步长：
           <input id="ctl00_MainContent_rbt1" type="radio" name="step" value="1" <?php if($query['step']==1){ echo "checked='checked'";}?> onclick="radiobuttonOnclick('day');">&nbsp;<label for="ctl00_MainContent_rbt1">日</label>&nbsp;&nbsp;
           <input id="ctl00_MainContent_rbt2" type="radio" name="step" value="2" <?php if($query['step']==2){ echo "checked='checked'";}?> onclick="radiobuttonOnclick('week');">&nbsp;<label for="ctl00_MainContent_rbt2">周</label>&nbsp;&nbsp;
           <input id="ctl00_MainContent_rbt3" type="radio" name="step" value="3" <?php if($query['step']==3){ echo "checked='checked'";}?> onclick="radiobuttonOnclick('Month');">&nbsp;<label for="ctl00_MainContent_rbt3">月</label> &nbsp;&nbsp;
           开始时间：<input readonly="readonly" name="start" class="Wdate" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})"
                       style="width: 120px; margin-right: 15px;" type="text" value="<?php echo $query['start'];?>">  结束时间：
            <input style="width: 120px;" type="text" name="end" value="<?php echo $query['end'];?>" readonly="readonly" class="Wdate" onclick="WdatePicker({dateFmt:'yyyy-MM-dd'})">  </td>
        <td class="search"> 

            <input type="submit" class="btn btn-primary" value="搜 索">
            <input type="hidden"  value="" name="search">
        </td>
        <td></td>
    </tr>
</table>
</form>
    <div id="container" style="min-width: 500px; height: 400px; margin: 0 auto; margin-top: 30px;"></div>
</div> 
<script type="text/javascript"> 
$(function() {
    var data='<?php echo $data_str;?>'
    var json_data=JSON.parse(data); //图表数据
    var total="<?php echo $total;?>";//总安装量
    var area="<?php echo $query['area'];?>",sid="<?php echo $query['sid'];?>";
    if(area){
      // / $("#queryarea").val(area);
    }
    if(sid){
        //$("#querysid").val(area);
    }
    //城市地区联动
    $(document).on('change','#querycity',function() {
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
                    $("#queryarea").html(option + mydata);
                }
            });
        }else{
            var option ='<option value="">全部</option>';
            $("#queryarea").html(option);
            $("#queryarea").val('');

        }
    });

    $(document).on('change','#queryarea',function() {

        var area=$("#queryarea").val();
        ajaxareaurl = "<?php echo Yii::app()->createUrl('range/areaschools');?>";
        if(area){
            $.getJSON(ajaxareaurl,{area:area},function(data){
                if(data&&data.status==='1'){

                    if(data.data){
                        var str=[];
                        $.each(data.data,function(i,v){
                            str.push('<option value="'+ v.sid+'">'+ v.name+'</option>');
                        });
                        $("#querysid").html("<option value=''>全部</option>"+str.join(" "));
                    }
                }
            })
        }
    });

    $('#container').highcharts({
        chart: { 
            type: 'column'
        },
        title: {
            text: '客户端安装量统计('+total+")"
        },
        subtitle: {
            text: ' '
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: { /* y轴 */
            title: {
                text: '安装量'
            },
            lineWidth: 1,
            lineColor: '#C0C0C0'
        },
        legend: {
            enabled: false,/* 隐藏图例 默认为ture*/
        },
        credits: {
            enabled: false   //右下角不显示LOGO
        }, 
        tooltip: {
            pointFormat: '安装激活数 : <b>{point.y:.1f} 个</b>'
        }, 
        series: [{
            name: '安装激活总数'+total,
            data: json_data,
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                x: 4,
                y: 10,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif',
                    textShadow: '0 0 3px black'
                }
            }
        }]
    });
    
}); 
</script>