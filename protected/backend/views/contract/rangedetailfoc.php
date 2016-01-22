
<?php if(count($school_arr)){ ?>
<div>
    <!-- 显示查询结果及配置 -->
    <form>
         <!-- 查询结果 --> 
        <div>
            <?php $grades = $relation->getRelationRangeGrades(); ?>
            <div class="grades_nav">
                <span class="leadt">推广范围：</span>
                <div class="grades_cotent" style="margin-left: 80px;">
                    <?php foreach($grades as $grade){ ?>
                    <span ><?php echo $grade->name;?></span>
                    <?php } ?>
                </div>
                </div>
            <table class="table table-bordered"> 
                <thead>
                    <tr style="background-color: #f1f1f1;">
                        <th width="180px">学校名称</th>
                    </tr>
                </thead>
                 <tbody>
                 <?php foreach($school_arr as $s){ ?>  
                     <tr>
                         <td><?php echo School::getSchoolName($s->sid); ?></td>
                    </tr>
                <?php } ?>
                </tbody> 
            </table>
            <div style=" margin-right: 600px;">已选择共<?php echo $relation->school; ?>所学校约<?php echo $relation->person; ?>位用户</div> 
        </div>
    </form>
    
</div>
<?php }else {?> 
        <div  style=" text-align: center; font-size: 21px; ">
            暂无数据
        </div>  
<?php } ?>