<div>
    <!-- 显示查询结果及配置 -->
    <form>
         <!-- 查询结果 -->
        <div>
            <table class="table table-bordered"> 
                <thead>
                    <tr style="background-color: #f1f1f1;">
                        <th width="10%">全部可用</th>
                        <th width="10%">部分可用</th>
                        <th>学校名称</th>
                        <?php foreach($grade_arr as $gk=>$gv){ ?>
                        <th width="8%"><?php echo $gv; ?></th>
                        <?php } ?> 
                    </tr>
                </thead>
                 <tbody>
                 <?php foreach($data as $sd){ ?>  
                     <tr>
                        <td><input type="checkbox"  /> </td>
                        <td><input type="checkbox" /> </td>
                        <td sid="<?php echo $sd['sid']; ?>"><?php echo $sd['name']; ?></td>
                        <?php foreach($grade_arr as $gk=>$gv){ ?>
                            <?php if($sd[$gk]['info']['type'] == "empty"){ ?>
                                <td class="colorBox color1"></td>
                            <?php } ?>
                            <?php if($sd[$gk]['info']['type'] == "part"){ ?>
                                <td class="colorBox color2"><?php echo $sd[$gk]['info']['days']; ?>天</td>
                            <?php } ?>
                            <?php if($sd[$gk]['info']['type'] == "full"){ ?>
                                <td class="colorBox color3"></td>
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
                 备注：<span class="color1" ></span>全部可用<span class="color2"></span>部分可用 <span class="color3"></span>无空档期 <span class="color4"></span>未开通版面
             </div>
             <div style=" margin-right: 600px;">已选择共5所学校 约65142位用户</div> 
         </div>
        <p><a href="javascript:void(0);" class="btn btn-primary">配置</a></p>
    </form>
</div>