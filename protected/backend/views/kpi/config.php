<div class="box">
    <div class="viweInfo" style="">
        <form class="form-horizontal" role="form" action="" method="POST">
            <div class="form-group">
                <label for="min" class="col-sm-2 control-label">用户名</label>
                <div class="col-sm-10">
                    <span class="user-item"><?php echo $user['username']; ?></span>
                </div>
            </div>
            <div class="form-group">
                <label for="min" class="col-sm-2 control-label">平均分</label>
                <div class="col-sm-10">
                    <input id="orgscore" name="config[orgscore]" type="text" value="<?php echo $model->orgscore; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label for="min" class="col-sm-2 control-label">最少考核人数</label>
                <div class="col-sm-10">
                    <input id="min" type="text" name="config[minlimit]" value="<?php echo $model->minlimit; ?>"/>
                    <!--<select name="" class="form-control">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>-->
                </div>
            </div>
            <div class="form-group">
                <label for="min" class="col-sm-2 control-label">最多考核人数</label>
                <div class="col-sm-10">
                    <input id="max" type="text" name="config[maxlimit]" value="<?php echo $model->maxlimit; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label for="min" class="col-sm-2 control-label">&nbsp;</label>
                <div class="col-sm-10">
                    <button id="config-submit" type="submit" class="btn btn-primary">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
<style>
    <style>
    #omsg{ font-size: 18px; width: 265px; margin: 0px auto; position:absolute ; right: 20px; bottom:50px; display: none; z-index: 10000; border-radius: 5px;}
    #omsg .messageType{ padding:8px 15px; line-height: 30px; -webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;}
    #omsg .error{border: 1px solid #eed3d7; background-color: #eeeeee; color: red; }
</style>
<div id="omsg">
    <div class="messageType error"><span id="icon-error">✘</span>&nbsp;&nbsp;<span id="omsg-error-msg"></span></div>
</div>
<script type="text/javascript">
    function showError(msg) {
        $('#omsg-error-msg').text(msg);
        $('#omsg').slideDown();
        setTimeout(function() {
            $('#omsg').slideUp("slow");
        }, 3000);
    }

    $('#config-submit').click(function (){
        var score = $('#orgscore').val();
        var min = $('#min').val();
        var max = $('#max').val();
        if (score == '' || min =='' || max =='') {
            showError('所有文本框都是必填的');
            return false;
        }
        if (!$.isNumeric(score) || !$.isNumeric(min) || !$.isNumeric(max)) {
            showError('所填项必须是数字');
            return false;
        }
        if (score < 0 || score > 100) {
            showError('平局分不能少于0或者大于100');
            return false;
        }
        if (min < 0 || max < 0) {
            showError('最少或最多考核人不能为负');
            return false;
        }
        if (min > max) {
            showError('最少考核人数不能大于最多考核人数');
            return false;
        }
    });
</script>
