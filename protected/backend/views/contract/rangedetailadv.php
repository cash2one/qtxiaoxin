<?php if(count($school_arr)){ ?>
<div>
    <!-- 显示查询结果及配置 -->
    <form>
         <!-- 查询结果 -->
        <div>
            <table class="table table-bordered"> 
                <thead>
                    <tr style="background-color: #f1f1f1;">
                        <th style="width:180px;">学校名称</th>
                        <?php foreach($grade_arr as $gk){ ?>
                        <th style="width:75px;"><?php echo Grade::getGradeName($gk); ?></th>
                        <?php } ?> 
                    </tr>
                </thead>
                 <tbody>
                 <?php foreach($school_arr as $s){ ?>  
                     <tr>
                        <td><?php echo School::getSchoolName($s); ?></td>
                        <?php foreach($grade_arr as $g){ ?>  
                            <?php if(!isset($data[$s][$g])){ ?>
                            <td></td>
                            <?php }else{ ?>
                                <?php if($data[$s][$g]['type'] == "all"){ ?>
                                    <td class="colorBox allColor" style="padding: 0;">
                                        <div class="color1" style="padding: 8px;">&nbsp;</div> 
                                    </td>
                                <?php } ?>
                                <?php if($data[$s][$g]['type'] == "part"){ ?>
                                    <td class="colorBox allColor" style="padding: 0;">
                                        <div class="color2" style="padding: 8px;"><?php echo $data[$s][$g]['days']; ?>天</div> 
                                    </td>
                                <?php } ?>
                                <?php if($data[$s][$g]['type'] == "empty"){ ?>
                                    <td  class="colorBox" style="padding: 0;">
                                        <div class="color4" style="padding: 8px;">&nbsp;</div>
                                    </td>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </tr>
                <?php } ?>
                </tbody> 
            </table>
        </div>
    </form>
    <div style=" margin-bottom:10px; ">
        <div class="remarkBox" style="float:right; ">
            备注：<span class="color1" ></span>全部可用<span class="color2"></span>部分可用 <span class="color4 border4" style="display: inline-block;height: 17px;margin-bottom: -4px;"></span>未选择
        </div>
        <div style=" margin-right: 600px;">已选择共<?php echo $relation->school; ?>所学校约<?php echo $relation->person; ?>位用户</div> 
    </div>
</div>
<?php }else {?> 
        <div  style=" text-align: center; font-size: 21px; ">
            暂无数据
        </div>  
<?php } ?>