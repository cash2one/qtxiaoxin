<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/listbox/prettify.css"> 
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/listbox/bootstrap-duallistbox.css"> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/listbox/jquery.bootstrap-duallistbox.js"></script>
<div class="box">
<form id="demoform" action="" method="post">
<table class="tableForm searchForm" style="margin-bottom: 10px;">
    <tr> 
        <!--<td width="75px"> 账号类型：</td>
        <td width="130px">
            <select datatype="*" nullmsg="请选择类型！" errormsg="" name="Access[type]" id="Access_type" class="Validform_error">
                <option value="">--选择类型--</option>
                <option value="1" <?php /*if($type==1):*/?>selected="selected"<?php /*endif; */?> >机构账号</option>
                <option value="2" <?php /*if($type==2):*/?>selected="selected"<?php /*endif; */?>>商户账号</option>
            </select>
        </td>-->
        <td width="75px"> 评选人：</td>
        <td width="150px">
            <select datatype="*" nullmsg="请选择类型！" errormsg="" name="Access[user]" id="Access_user" class="Validform_error">
                <option value="0">请选择</option>
                <?php $cacheArr = array(); ?>
                <?php foreach($user as $urow): ?>
                <option value="<?php echo $urow['uid']; ?>"><?php echo $urow['name']; ?></option>
                <?php $cacheArr[] = array('uid' => $urow['uid'], 'name' => $urow['name']); ?>
                <?php endforeach; ?>
            </select>
        </td>
        <td></td>
    </tr> 
</table> 
    <input type="hidden" name="Access[schools]" id="results" value="">
    <input type="hidden" name="userid" id="userid" value="" />
    <div id="target">
        <select multiple="multiple" size="20" name="duallistbox_demo1[]" >

        </select>
    </div>
    <div style="margin-top: 20px;">
        <button type="button" class="btn btn-default btn-block" id="save">保存</button>
    </div> 
</form>
<script>
    var cacheArr = <?php echo json_encode($cacheArr); $cacheArr == null; ?>;

    var settings = {
        infoTextEmpty:'无数据',
        infoText:'总计 {0}',
        filterPlaceHolder:'过滤',
        infoTextFiltered:'<span >匹配到</span> {1} 项中的 {0} 项',
        filterTextClear:'显示全部'
    };

    var demo1 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox(settings);

    $("#save").click(function() {
        if ($('#Access_user').val() == 0) {
            return false;
        }
        $('#userid').val($('#Access_user').val());
        var result = $('[name="duallistbox_demo1[]"]').val();
        $("#results").val(result);
        $("#demoform").submit();
    });

    //$('select:eq(1)',demo1.bootstrapDualListbox('getContainer')).children().index() + 1;

    $("#Access_user").change(function() {
        var self = $(this);
        if (self.val() == 0) return false;
        $.ajax({
            url: '<?php echo Yii::app()->createUrl('kpi/getselected'); ?>',
            type : 'POST',
            data : {uid : self.val()},
            dataType : 'text',
            contentType : 'application/x-www-form-urlencoded',
            success : function(json) {
                var tempArr = json.split(","); //临时数组
                var currentId = self.val();
                demo1.empty();
                $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox("refresh", true);
                var html = '';
                $.each(cacheArr, function(i, v) {
                    if (v.uid != currentId) {
                        if ($.inArray(v.uid, tempArr) != -1) {
                            html += '<option selected value="'+ v.uid +'">' + v.name + '</option>';
                        } else {
                            html += '<option value="'+ v.uid +'">' + v.name + '</option>';
                        }
                    }
                });
                demo1.append(html);
                $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox("refresh", true);
            },
            error : function() {
            }
        });
    });
</script>
</div>
