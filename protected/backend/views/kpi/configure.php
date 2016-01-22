<style>
    .tit h2 {
        padding: 0;
        margin: 0;
        font-weight: normal;
        font-size: 18px;
    }
    .hidden {
        display: none;
    }
    .user-item {
        position: relative;
        display: block;
        float: left;
        width: auto;
        padding: 6px 12px;
        margin-bottom: 5px;
        text-align: center;
        background-color: #f9f9f9;
        margin-right: 10px;
        cursor: pointer;
        border: 1px solid #e1e1e1;
        border-radius: 4px;;
    }
    .batch-opt {
        padding-top: 10px;
    }
    .user-box {
        margin: 10px 0;
        padding: 10px;
        border: 1px solid #ddd;
    }
    .user-box .active {
        background-color: #2869a3;
        color: #ffffff;
    }
    .opt-tips {
        color: darkred;
    }
    #pager {
        padding-right: 30px;
    }
    #kpi-form {
        margin-top: 10px;
    }
    #kpi-form label {
        text-align: left;
        width: 120px;
    }
</style>
<div class="box">
    <div class="clearfix">
        <div class="tit">
            <h2>全部名单：<span style="color:#bf1d0e;"></h2>
        </div>
        <div class="user-box clearfix">
            <?php foreach($model as $v): ?>
                <span class="user-item" data-id="<?php echo $v->uid; ?>"><?php echo $v->name; ?>(<?php if (isset($v->configs->minlimit)): echo $v->configs->minlimit; else: echo 2; endif;?>-<?php if (isset($v->configs->maxlimit)): echo $v->configs->maxlimit; else: echo 3; endif;?>)</span>
            <?php endforeach; ?>
        </div>
        <div class="tit">
            <h2 style="color: darkred;">
                显示格式:员工姓名(最少考核人数-最多考核人数)
            </h2>
        </div>
        <ul id="pager" class="pagination pagination-sm pull-right"></ul>
    </div>
    <div>
        <div class="action-box">
            <div class="batch-opt" style="overflow: hidden;">
                <div class="tit">
                    <h2><span class="opt-tips">提示: 点击名单列表选取需要修改的员工，若不选员工，则默认对全部员工修改!</span></h2>
                </div>
                <form action="./batchupdate" id="kpi-form" class="form-horizontal" method="POST">
                    <!--<div class="form-group">
                        <label for="orgscore" class="col-sm-2 control-label">平均分</label>
                        <div class="col-sm-10">
                            <input id="orgscore" name="config[orgscore]" type="text" value=""/>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <label for="min" class="col-sm-2 control-label">最少考核人数</label>
                        <div class="col-sm-10">
                            <input id="min" type="text" name="config[minlimit]" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="max" class="col-sm-2 control-label">最多考核人数</label>
                        <div class="col-sm-10">
                            <input id="max" type="text" name="config[maxlimit]" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="none" class="col-sm-2 control-label">&nbsp;</label>
                        <div class="col-sm-10">
                            <input type="hidden" id="uids" name="config[uids]" value=""/>
                            <button id="config-submit" type="submit" class="btn btn-primary">提交</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/prompt.js" ></script>
<script type="text/javascript">
    $('.user-box').delegate('span', 'click', function() {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
        }
    });
</script>
<style>
    #omsg{ font-size: 18px; width: 265px; margin: 0px auto; position:absolute ; right: 20px; bottom:50px; display: none; z-index: 10000; border-radius: 5px;}
    #omsg .messageType{ padding:8px 15px; line-height: 30px; -webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;}
    #omsg .error{border: 1px solid #eed3d7; background-color: #eeeeee; color: red; }
</style>
<div id="omsg">
    <div class="messageType error"><span id="icon-error">✘</span>&nbsp;&nbsp;<span id="omsg-error-msg"></span></div>
</div>
<div id="popupBox" class="popupBox">
    <div id="popupInfo" style="padding:20px 30px;">
        <div id="warningTips" class="centent">温馨提示：确定要对所有员工进行修改吗?</div>
    </div>
    <div style="text-align: center;">
        <a id="isOk" href="javascript:;" class="btn btn-primary">确定</a> &nbsp;&nbsp;
        <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBox');" class="btn btn-default">取消</a>
    </div>
</div>
<script type="text/javascript">
    function showError(msg) {
        $('#omsg-error-msg').text(msg);
        $('#omsg').slideDown();
        setTimeout(function() {
            $('#omsg').slideUp("slow");
        }, 3000);
    }

    $('#config-submit').click(function () {
        var score = $('#orgscore').val();
        var min = parseInt($('#min').val());
        var max = parseInt($('#max').val());
        if (score == '' || min =='' || max =='') {
            showError('所有文本框都是必填的');
            return false;
        }
        if (!$.isNumeric(min) || !$.isNumeric(max)) {
            showError('所填项必须是数字');
            return false;
        }
        /*if (score < 0 || score > 100) {
            showError('平局分不能少于0或者大于100');
            return false;
        }*/
        if (min < 0 || max < 0) {
            showError('最少或最多考核人不能为负');
            return false;
        }
        if (min > max) {
            showError('最少考核人数不能大于最多考核人数!');
            return false;
        }
        var uids = '';
        $('.user-box .active').each(function(i) {
            if (i == 0) {
                uids += $.trim($(this).attr('data-id'));
            } else {
                uids += ',' + $.trim($(this).attr('data-id'));
            }
        });
        $('#uids').val(uids);
        if (uids == '') {
            $('#warningTips').text('温馨提示：确定要对所有员工进行修改吗?修改之后,这个月所有已评分数据将删除!');
            showPromptsIfonWeb('#popupBox');
            return false;
        } else {
            $('#warningTips').text('温馨提示：修改之后,被选中员工这个月已评分数据将删除!');
            showPromptsIfonWeb('#popupBox');
            return false;
        }
    });

    $('#isOk').click(function(){
        $('#kpi-form').submit();
    });

    function Pager(options) {
        this.options = {
            perPage: 10,
            container: "pager",
            total: 0,
            startPage: 1,
            startRange: 1,
            endRange: 1,
            pageNum: 0,
            midRange: 5
        };

        this._curPage = 1;
        this._holder = $('#' + this.options.container);

        for (var option in this.options) {
            if (option in options) {
                this.options[option] = options[option];
            }
        }

        if (this.options.total === 0) {
            return false;
        }

        this._pageNum = Math.ceil(this.options.total / this.options.perPage);

        if (this._pageNum == 1) {
            return false;
        }

        this.init();
    }

    Pager.prototype = {
        constructor: Pager,

        writeNav: function() {
            var list = '';
            var i = 1;

            for (; i <= this._pageNum; i++) {
                if (i > this.options.startRange && i < this._pageNum - this.options.endRange) {
                    list += '<a>';
                }
                if (i === this._curPage)
                    list += '<li class="active" data-id="'+ i +'"><a href="javascript:;">'+ i +'</a></li>';
                else
                    list += '<li data-id="'+ i +'"><a href="javascript:;">'+ i +'</a></li>';

            }
            return list;
        },

        setNav: function() {
            var list = this.writeNav();

            this._holder.append(list);
        },

        getRange: function(page) {
            var range = {};
            range.start = (page - 1) * this.options.perPage;
            range.end = range.start + this.options.perPage;
            return range;
        },

        bind: function() {
            var that = this;
            this._holder.children().click(function() {
                if (that._curPage == $(this).attr('data-id')) {
                    return false;
                }
                that._curPage = $(this).attr('data-id');
                that._holder.children().removeClass("active");
                $(this).addClass("active");

                $.ajax({
                    type: "GET",
                    dataType: "JSON",
                    url: "<?php echo Yii::app()->createUrl('kpi/getmore'); ?>?page=" + that._curPage,
                    success: function(data) {
                        $('.user-box').empty();
                        var list = '';
                        $.each(data, function(i, v){
                            list += '<span class="user-item" data-id="'+ v['userid'] +'">'+ v['name'] +'('+ v['score'] +'::'+ v['min']+'-'+ v['max'] +')</span>';
                        });
                        $('.user-box').append(list);
                    },
                    error: function(xhr, response, e) {
                        console.log(response);
                    }
                });
            });
        },

        init: function() {
            this.setNav();
            this.bind();
        }

    }
</script>
