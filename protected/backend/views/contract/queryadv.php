<?php if (count($data)) { ?>
    <style>
        .tableFormSelct td{ font-size: 12px; padding:4px 0px;}
    </style>
    <div id="tab_box_<?php echo $order; ?>">
        <!-- 显示查询结果及配置 -->
        <form> 
            <!-- 查询结果 -->
            <div style=" max-width: 769px;height:190px; overflow: auto; margin-bottom: 10px;">
                <div style="<?php
                if (count($grade_arr) <= 6) {
                    echo 'width: auto;';
                } else if (count($grade_arr) > 6 && count($grade_arr) <= 10) {
                    echo ' width: 1000px;';
                } else if (count($grade_arr) > 10 && count($grade_arr) <= 16) {
                    echo 'width: 1400px;';
                } else {
                    echo 'width: 1600px;';
                }
                ?>">
                    <table class="table table-bordered tableFormSelct"> 
                        <thead>
                            <tr style="background-color: #f1f1f1;">
                                <th style="width:110px;" class="color1"><label class="checkbox"><input rel="allCheckBox" type="checkbox" />全部可用</label></th>
                                <th style="width:110px;" class="color2"><label class="checkbox"><input rel="partCheckBox" type="checkbox" />部分可用</label></th>
                                <th style="width:260px;">学校名称</th>
                                <?php foreach ($grade_arr as $gk => $gv) { ?>
                                <th style="width:70px;"><?php echo $gv; ?></th>
                                <?php } ?> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $sd) { ?>  
                                <tr class="check" data-sid="<?php echo $sd['sid']; ?>">
                                    <td style="padding: 0px 8px;"><input rel="allCheck" class="schoolCheck" type="checkbox" data-sid="<?php echo $sd['sid']; ?>" data-order="<?php echo $order; ?>" /> </td>
                                    <td style="padding: 0px 8px;"><input rel="partCheck" class="schoolCheck" type="checkbox" data-sid="<?php echo $sd['sid']; ?>" data-order="<?php echo $order; ?>" /></td>
                                    <td style="padding: 0px 8px;" sid="<?php echo $sd['sid']; ?>"><?php echo $sd['name']; ?></td>
                                    <?php foreach ($grade_arr as $gk => $gv) { ?>
                                        <?php if ($sd[$gk]['info']['type'] == "empty") { ?>
                                            <td data-classid="<?php echo $gk; ?>"  class="colorBox  allColor" style=" padding: 0;">
                                                <div class="color1" style="padding: 6px; position: relative;">
                                                    &nbsp;
                                                    <input style="display: none;" class="allCheck" sid="sid_<?php echo $sd['sid']; ?>" rel="classId" name="ConType[<?php echo $order; ?>][result]" type="checkbox" value="<?php echo $sd['sid']; ?>-<?php echo $gk; ?>" person="<?php echo $sd[$gk]['info']['person']; ?>"/>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php if ($sd[$gk]['info']['type'] == "part") { ?>
                                            <td data-classid="<?php echo $gk; ?>" class="colorBox  allColor" style="padding: 0;">
                                                <div class="color2" style="padding: 6px; position: relative;">
                                                    <?php echo $sd[$gk]['info']['days']; ?>天
                                                    <input style="display: none;" class="partCheck" sid="sid_<?php echo $sd['sid']; ?>" rel="classId" name="ConType[<?php echo $order; ?>][result]" type="checkbox" value="<?php echo $sd['sid']; ?>-<?php echo $gk; ?>" person="<?php echo $sd[$gk]['info']['person']; ?>"/>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php if ($sd[$gk]['info']['type'] == "full") { ?>
                                            <td  class="colorBox" style="padding: 0;">
                                                <div class="color3" style="padding: 6px; ">
                                                    &nbsp;
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php if ($sd[$gk]['info']['type'] == "disable") { ?>
                                            <td class="colorBox " style="padding: 0;">
                                                <div class="color4" style="padding: 6px;">
                                                    &nbsp;
                                                </div>
                                            </td>
                                        <?php } ?>
                                    <?php } ?> 
                                </tr>
                            <?php } ?>
                        </tbody> 
                    </table>
                </div>
            </div>
            <div style=" margin-bottom:15px; overflow: hidden; ">
                <div class="remarkBox" style="float:right; ">
                    备注：<span class="color1" ></span>全部可用<span class="color2"></span>部分可用 <span class="color3"></span>无空档期 <span class="color4 border4" style="display: inline-block;height: 17px;margin-bottom: -4px;"></span>未开通版面
                </div>
                <!--<div style=" margin-right: 600px;">已选择共5所学校 约65142位用户</div>--> 
            </div>
            <p style=" text-align: center; margin-top: 5px">
                <a href="javascript:void(0);" data-order="<?php echo $order; ?>" rel="severData" class="btn btn-primary">确 定</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="javascript:void(0);" class="btn btn-primary" onclick="hidePormptMaskWeb('#popupBoxViwe')">取 消</a>
            </p>
        </form>
    </div>
<?php } else { ?>
    <div style="text-align: center; font-size: 21px;">暂无数据</div>
<?php } ?>
