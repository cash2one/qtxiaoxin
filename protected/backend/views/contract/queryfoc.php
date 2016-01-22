<?php if(count($schools)){ ?>
<style>
    .tableFormSelct td{ font-size: 12px; padding:4px 0px;}
</style>
<div id="tab_box_<?php echo $order; ?>">
    <!-- 显示查询结果及配置 -->
    <form>
         <!-- 查询结果 -->
         <div style="height:220px; overflow-x: auto; overflow-y: auto; ">
            <table class="table table-bordered tableFormSelct"> 
                <thead>
                    <tr style="background-color: #f1f1f1;">
                        <th width="100px"><label class="checkbox"><input rel="allFocCheckBox" type="checkbox" />选择</label></th>
                        <th  >学校名称</th>
                    </tr>
                </thead>
                 <tbody>
                 <?php foreach($schools as $sc){ ?>  
                     <tr data-sid="<?php echo$sc->sid; ?>">
                         <td style="padding:4px 8px;"><input rel="schoolFocCheck" class="schoolFocCheck" type="checkbox" data-sid="<?php echo $sc->sid; ?>" data-order="<?php echo $order; ?>" person="<?php echo $person[$sc->sid]; ?>"/></td>
                        <td style="padding:4px 8px;" sid="<?php echo $sc->sid; ?>"><?php echo $sc->name; ?></td>
                     </tr>
                <?php } ?>
                </tbody> 
            </table>
        </div>
        <input type="hidden" id="grade_ids" value="<?php echo $grades; ?>">
        <p style=" text-align: center; margin-top: 20px">
            <a href="javascript:void(0);" data-order="<?php echo $order; ?>" rel="severFocData" class="btn btn-primary">确 定</a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="javascript:void(0);" class="btn btn-primary" onclick="hidePormptMaskWeb('#popupBoxViwe')">取 消</a>
        </p>
    </form>
</div>
<?php }else{ ?>
    <div style="text-align: center; font-size: 21px;">暂无数据</div>
<?php } ?>