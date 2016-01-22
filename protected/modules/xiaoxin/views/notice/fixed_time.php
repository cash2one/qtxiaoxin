<!--发件箱消息,通知列表 --> 
<select id="selectY"> 
    <?php foreach ($years as $v): ?>
    <option value="<?php echo $v; ?>" <?php echo $v==$y?"selected='selected'":'';?> ><?php echo $v; ?></option>
    <?php endforeach; ?> 
</select> &nbsp;&nbsp;年&nbsp;&nbsp;
<select id="selectM">  
    <?php foreach ($months as $v): ?>
    <option value="<?php echo $v; ?>" <?php echo $v==$m?"selected='selected'":'';?>><?php echo $v; ?></option>
    <?php endforeach; ?> 
</select>&nbsp;&nbsp;月&nbsp;&nbsp;
<select id="selectD">
    <?php foreach ($days as $v): ?>
        <option value="<?php echo $v; ?>" <?php echo $v==$d?"selected='selected'":'';?>><?php if($v<10){echo '0'.$v;}else {echo $v;} ?></option>
    <?php endforeach; ?>
</select>&nbsp;&nbsp;日&nbsp;&nbsp;
<select id="selectH">
    <?php foreach ($hours as $v): ?>
        <option value="<?php echo $v; ?>" <?php echo $v>$h&&($v-$h==1)?"selected='selected'":'';?>><?php if($v<10){echo '0'.$v;}else {echo $v;} ?></option>
    <?php endforeach; ?>
</select>&nbsp;&nbsp;时&nbsp;&nbsp;
<select id="selectI">
    <?php foreach ($minutes as $v): ?> 
        <option value="<?php echo $v; ?>" <?php echo $v>$i&&($v-$i<5)?"selected='selected'":'';?>><?php if($v<10){echo '0'.$v;}else {echo $v;} ?></option> 
    <?php endforeach; ?>
</select>&nbsp;&nbsp;分&nbsp;&nbsp; 
<div class="setTimePayle" style="display: none;">本通知将于，今天 <span class="red"><?php foreach ($minutes as $v): ?> <?php echo $v>$i&&($v-$i<5)?($h+1)." : ".$v : '';?> <?php endforeach; ?></span> 发送</div>
<div style="line-height: 20px; padding: 10px 0; text-align: center;">&nbsp;<span class="setTimeTip" style="color: #E95B5F; display: none;">您设定的日期已过期</span></div>
<input id="timeHidden" type="hidden" value="<?php echo '';?>">
<input id="timeHiddenDefine" type="hidden" value="<?php echo $currentTime;?>">
<script type="text/javascript">
    function getLastDay(year,month)
    {
        var new_year = year;  //取当前的年份
        var new_month = month++;//取下一个月的第一天，方便计算（最后一天不固定）
        if(month>12)      //如果当前大于12月，则年份转到下一年
        {
            new_month -=12;    //月份减
            new_year++;      //年份增
        }
        var new_date = new Date(new_year,new_month,1);        //取当年当月中的第一天
        return (new Date(new_date.getTime()-1000*60*60*24)).getDate();//获取当月最后一天日期
    }
    $("#selectM").change(function(){
        var year=$("#selectY").val();
        var month=$("#selectM").val();
        var day=getLastDay(year,month);
        var str="", j;
        for(var i=0;i<day;i++){
             j=i+1;
             if(j<10){
                 str+='<option value="'+j+'">'+'0'+j+'</option>';
             }else{
                 str+='<option value="'+j+'">'+j+'</option>';
             }
        }
        $("#selectD").html(str);

    })
</script>
