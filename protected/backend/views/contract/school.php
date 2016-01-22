<div>
<?php  if(count($grade_arr)): ?>
    <!-- 显示查询结果及配置 -->
    <form>
         <!-- 查询结果 -->
        <div>
            <table class="table table-bordered"> 
                <thead>
                    <tr style="background-color: #f1f1f1;">
                        <th style="width:180px;">广告位</th> 
                        <?php foreach($grade_arr as $gk=>$gv){ ?>
                        <th style="width:85px;"><?php echo $gv; ?></th>
                        <?php } ?> 
                    </tr>
                </thead>
                 <tbody>
                 <?php foreach($data as $sd){ ?>  
                     <tr data-sid="<?php echo $sd['sid']; ?>">
                        <td sid="<?php echo $sd['sid']; ?>"><?php echo $sd['name']; ?></td>
                        <?php foreach($grade_arr as $gk=>$gv){ ?>
                            <?php if($sd[$gk]['info']['type'] == "empty"){ ?>
                                <td data-classid="<?php echo $gk; ?>"  class="colorBox color1 allColor">
                                    <input style="display: none;" class="allCheck"/>
                                </td>
                            <?php } ?>
                            <?php if($sd[$gk]['info']['type'] == "part"){ ?>
                                <td data-classid="<?php echo $gk; ?>" class="colorBox color2 allColor">
                                    <?php echo $sd[$gk]['info']['days']; ?>天
                                    <input style="display: none;" class="partCheck" rel="classId" />
                                </td>
                            <?php } ?>
                            <?php if($sd[$gk]['info']['type'] == "full"){ ?>
                                <td  class="colorBox color3"></td>
                            <?php } ?>
                            <?php if($sd[$gk]['info']['type'] == "disable"){ ?>
                                <td class="colorBox color4"></td>
                            <?php } ?>
                        <?php } ?>
                     </tr>
                <?php } ?>
                </tbody> 
            </table>
        </div>
         <div style=" margin-bottom:10px; ">
             <div class="remarkBox" style="float:right; ">
                 备注：<span class="color1" ></span>全部可用<span class="color2"></span>部分可用 <span class="color3"></span>无空档期 <span class="color4 border4"></span>未开通版面
             </div>
         </div>
    </form>
    <?php else:?>
    <div style="text-align: center; color: #666;">由于学校没有添加年级，暂时找不到任何数据</div>
    <?php endif; ?>
</div>