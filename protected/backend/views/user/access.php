<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/listbox/prettify.css"> 
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/business/listbox/bootstrap-duallistbox.css"> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/listbox/jquery.bootstrap-duallistbox.js"></script> 

<!-- <link rel="stylesheet" type="text/css" href="../src/prettify.css">
<link rel="stylesheet" type="text/css" href="../src/bootstrap-duallistbox.css">
<script src="../src/jquery.bootstrap-duallistbox.js"></script> -->


<div class="box">
<form id="demoform" action="" method="post">
<table class="tableForm searchForm" style="margin-bottom: 10px;">
    <tr> 
        <td width="75px"> 账号类型：</td>
        <td width="130px">
            <select datatype="*" nullmsg="请选择类型！" errormsg="" name="Access[type]" id="Access_type" class="Validform_error">
                <option value="">--选择类型--</option>
                <option value="1" <?php if($type==1):?>selected="selected"<?php endif; ?> >机构账号</option>
                <option value="2" <?php if($type==2):?>selected="selected"<?php endif; ?>>商户账号</option>
                <!-- <option value="3">机构商户通用账号</option> -->
            </select>
        </td>

        <td width="45px"> 账号：</td>
        <td width="130px">
            <select datatype="*" nullmsg="请选择类型！" errormsg="" name="Access[user]" id="Access_user" class="Validform_error">
              
            </select>
        </td>
        <td></td>
    </tr> 
</table> 
    <input type="hidden" name="Access[schools]" id="results" value="">
    <div id="target">
        <select multiple="multiple" size="20" name="duallistbox_demo1[]" >

        </select>
    </div>
    <div style="margin-top: 20px;">
        <button type="button" class="btn btn-default btn-block" id="save">保存</button>
    </div> 
</form>
<script>
    var settings = {
        infoTextEmpty:'无数据',
        infoText:'总计 {0}',
        filterPlaceHolder:'过滤',
        infoTextFiltered:'<span >匹配到</span> {1} 项中的 {0} 项',
        filterTextClear:'显示全部',
    };

    var demo1 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox(settings);
    $("#save").click(function() {
        var result = $('[name="duallistbox_demo1[]"]').val();
        $("#results").val(result);
        $("#demoform").submit();
    });

    ajaxuserurl = "<?php echo Yii::app()->createUrl('range/user');?>";
    ajaxareahtml = "";
    function ajaxGetUser(cid){
        $.ajax({  
            url: ajaxuserurl,   
            type : 'POST',  
            data : {cid:cid},  
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : false,  
            success : function(mydata) {   
                ajaxareahtml = mydata;
            },  
            error : function() {  
            }  
        });
    }

    ajaxschoolurl = "<?php echo Yii::app()->createUrl('range/accessschool');?>";
    ajaxschoolhtml = "";
    function ajaxGetSchools(uid,type){
        $.ajax({  
            url: ajaxschoolurl,   
            type : 'POST',  
            data : {uid:uid,type:type},  
            dataType : 'text',  
            contentType : 'application/x-www-form-urlencoded',  
            async : false,  
            success : function(mydata) {   
                ajaxschoolhtml = mydata;
            },  
            error : function() {  
            }  
        });
    }

    $("#Access_type").change(function(){
       var cid = $(this).val(); 
        ajaxGetUser(cid);
        $("#Access_user").html(ajaxareahtml);
    });

    $("#Access_user").change(function(){
       var uid = $(this).val();
       var type = $("#Access_type").val();
        ajaxGetSchools(uid,type);
        $("#target").html(ajaxschoolhtml);
        var demo = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox(settings);
    });

    var userid = '<?php echo $uid; ?>';
    var type = '<?php echo $type; ?>';
    if(type){
        $("#Access_type").change();
        if(userid){
             $("#Access_user option[value='"+userid+"']").attr("selected", true);
            ajaxGetSchools(userid,type);
            $("#target").html(ajaxschoolhtml);
            var demo = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox(settings);
        }
    }

</script>

  
</div>
