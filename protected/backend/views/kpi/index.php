<style>
    #message,.message{ font-size: 18px; width: 265px; margin: 0px auto; position:absolute ; right: 20px; bottom:0px; display: none; z-index: 10000; border-radius: 5px;}
    #message .messageType,.message .messageType{ padding:8px 15px; line-height: 30px; -webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;}
    #message .success,.message .success{  border: 1px solid #fbeed5; background-color: #e95b5f; color: #fbe4e5; }
    #message .error,.message .error{border: 1px solid #eed3d7; background-color: #eeeeee; color: red; }
    .table td select{ width: 81px; }
    .tit {
		margin:10px 0;
	}
	.tit h2{
		padding:0;
		margin:0;
		font-weight:normal;
		font-size:18px;
	}
	.evaluation{
		border: 1px solid #ddd;
		padding:10px;
		margin:10px 0 10px;

	}
	.evaluation .evaluation-person{
		display:inline-block;
		*display:inline;
		*zoom:1;
		margin-right:20px;
	}
	.red{
		color:red;
	}
    .hidden {
        display: none;
    }
    #totalScore {
        margin-left: 10px;
    }
</style>
<div class="box">
    <div class="tableBox" >
    	<div class="tit">
    		<h2>全部名单：<span style="color:#bf1d0e;">(您可以给<?php echo $maxLimit = count($users['models']); ?>个人评分，平均基准分是<?php if(isset($config->orgscore)) echo $config->orgscore; ?>)</span></h2>
    	</div>
        <div class="evaluation" id="evaluationLoading" >
            loading....
        </div>
		<div class="evaluation" id="evaluation" style="display:none">
			<?php foreach($users['models'] as $v): ?>
				<div class="evaluation-person">
					<input  class="selecttype" type="checkbox"  data-id="<?php echo isset($v['uid'])?$v['uid']:''?>">
					<span><?php echo isset($v['name'])?$v['name']:'';?></span>
				</div>
			<?php endforeach; ?>
		</div>
        <script>
            $('#evaluationLoading').hide(20);
            $('#evaluation').show(20);
        </script>
		<!--<div class="red" id="tip" <?php if (false == isset($config->maxlimit)||$config->maxlimit!=count($cusers['models'])||0==$config->maxlimit):?>style="display:none;"<?php endif;?>>名额已选满<?php echo $maxLimit; ?>个人</div>-->
		<div class="tit" style="margin-top:20px;">
    		<h2>已选名单：</h2>
    	</div>
		<form action="" id="scoreForm" method="post" class="clearfix">
	        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
	            <thead>
		            <tr style="background-color: #e8e8e8;">
		                <th width="10%">序号</th>
		                <th width="40%">姓名</th>
		                <th width="50%">分数</th>
		            </tr>
	            </thead>
	            <tbody id="exam-list">
                    <?php foreach($cusers['models'] as $v): ?>
                    <tr id="name<?php echo isset($v['userid'])?$v['userid']:''?>"><td></td><td><?php echo isset($v['user']['name'])?$v['user']['name']:''?></td><td><input  name="score[<?php echo isset($v['userid'])?$v['userid']:''?>]"  value="<?php echo isset($v['score'])?$v['score']:''?>" placeholder="请输入分数" class="searchW260" style="width:120px;"  type="text"  ></td>
                    <?php if( true == isset($v['userid']) && $v['userid'] > 0 ):?>
                    <script>$('#evaluation').find("input[data-id='<?php echo $v['userid']?>']").attr('checked','true')</script>
                    <?php endif;?>
                    <input id="rowid<?php echo isset($v['userid'])?$v['userid']:rand(100000);?>" name="rowids[<?php echo isset($v['userid'])?$v['userid']:''?>]"  value="<?php echo isset($v['id'])?$v['id']:''?>" type="hidden"  /></tr>
                    <?php endforeach; ?>
	            </tbody>
	        </table>
	        <div class="batchOperation clearfix" style="float:left;">
                <input type="hidden" name="submit-flag" id="submit-flag"/>
	            <a href="javascript:;" class="btn btn-primary" style="margin-right:10px;" id="confirm">提交</a>
                <span id="totalScore"></span> <span id="remainScore"></span>
	            <span class="Validform_checktip " id="batchTip" style="display:none;"><span class="Validform_checktip Validform_wrong" >请勾选列表！</span> </span>
                <span id="errorTips" class="red hidden"></span>
	        </div>
        </form>
        <div id="pager" style="  margin-top: 30px;">

        </div>
    </div>
</div>
<script type="text/javascript">
    var maxLimit = <?php echo $maxLimit; ?>;
    var minLimit = <?php echo 1; ?>;
    var score = <?php if(isset($config->orgscore)) echo $config->orgscore; ?>;
    
    function scoreShow(){
        var result = 0;
        $('.searchW260').each(function(i, v) {
            result += parseInt($(this).val() ? $(this).val() : 0);
        });
        
        if( result ){
            var inputL = $('#evaluation').find('input:checked').length;
            $('#totalScore').text('您可以分配的分数:' + score * inputL);
            $('#remainScore').text('余下:'+parseInt(score * inputL-result)+'分');
        }
    }
    scoreShow();

    $('#exam-list').delegate('.searchW260', 'keyup', function(){
        scoreShow();
    });

    /*$('.searchW260').keyup(function(e){
        scoreShow();
    });*/
    
	var exam=function(){
		$('#confirm').on('click',function(){
            $('#submit-flag').val('true');
            var flag = true;
            var total = 0;
            var offsetLimit = true;
            var inputL = $('#evaluation').find('input:checked').length;
            var inputs = $('#exam-list').find(".searchW260");
            if (inputL < minLimit) {
                $('#errorTips').removeClass('hidden').text('请至少给'+ minLimit +'人评分');
                return false;
            }
            var temp = new Array();
            $.each(inputs, function(i) {
                var value = parseInt($(this).val());
                if (value > 100 || value < 0) {
                    $('#errorTips').removeClass('hidden').text('评分不能超过100分或少于0');
                    flag = false;
                }
                temp[i] = value;
                total += value ? value : 0;
            });
            for (var i = 0; i < temp.length; i++) {
                for (var j = i + 1; j < temp.length; j++) {
                    if (Math.abs(temp[i] - temp[j]) < 10) {
                        offsetLimit = false;
                    }
                }
            }
            if (!flag) {
                return false;
            }
            if (!offsetLimit) {
                $('#errorTips').removeClass('hidden').text('每人至少要相差10分');
                return false;
            }
            if (total > inputL * score) {
                $('#errorTips').removeClass('hidden').text('不能超过分配总分数' + inputL * score + '您分配了' + total + '分');
                return false;
            }
            if (total != inputL * score) {
                var scoreTotal = inputL * score;
                scoreTotal = scoreTotal ? scoreTotal : 0;
                $('#errorTips').removeClass('hidden').text('请分配完' + scoreTotal + '分，您只分配了' + total + '分');
                return false;
            }
    		$('form').submit();
    	})
        
    	$('#evaluation').on('change', 'input', function(){
            if (!$('#errorTips').hasClass('hidden')) {
                $('#errorTips').addClass('hidden');
            }
    		var id = $(this).data('id');
    		var examList = $('#exam-list');
    		var name = $(this).next().text();
    		var inputL = $('#evaluation').find('input:checked').length;

            $('#totalScore').text('您可以分配的分数:' + score * inputL);

    		if (inputL < maxLimit) {
    			if($(this).is(':checked')){
    				var _html='<tr id="name'+id+'"><td></td><td>'+name+'</td><td><input  name="score['+id+']"  value="" placeholder="请输入分数" class="searchW260" style="width:120px;"  type="text"  ></td></tr>';
	    			examList.append(_html);
	    		}else{
	    			$('#name'+id).remove();
	    		}
                //$('#tip').hide();
                $('#evaluation').find('input:checkbox').removeAttr('disabled');
    		} else if (inputL == maxLimit) {
                if($(this).is(':checked')){
                    var _html='<tr id="name'+id+'"></td><td><td>'+name+'</td><td><input  name="score['+id+']"  value="" placeholder="请输入分数" class="searchW260" style="width:120px;"  type="text"  ></td></tr>';
                    examList.append(_html);
                }else{
                    $('#name'+id).remove();
                }
                //$('#tip').show();
                $('#evaluation').find('input:checkbox').not("input:checked").attr('disabled','disabled');
            } else {
                $('#evaluation').find('input:checkbox').not("input:checked").attr('disabled','disabled');
    			//$('#tip').show();
    		}            
            updateChangeNumber();
            scoreShow();
    	});
	}
    
    function updateChangeNumber(){
        $("#exam-list tr").each(function(){
            $(this).find('td:first').text($(this).index()+1);
        });
    }
    updateChangeNumber();
    var inputL = $('#evaluation').find('input:checked').length;
    if (inputL >= maxLimit) {
        $('#evaluation').find('input:checkbox').not("input:checked").attr('disabled','disabled');
    }
    delete inputL;
    $(function () {
        $('#evaluationLoading').hide();
        $('#evaluation').show();
    	exam();
    });
</script>
