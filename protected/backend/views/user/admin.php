<style>
    #message,.message{ font-size: 18px; width: 265px; margin: 0px auto; position:absolute ; right: 20px; bottom:0px; display: none; z-index: 10000; border-radius: 5px;}
    #message .messageType,.message .messageType{ padding:8px 15px; line-height: 30px; -webkit-border-radius: 4px;-moz-border-radius: 4px;border-radius: 4px;}
    #message .success,.message .success{  border: 1px solid #fbeed5; background-color: #e95b5f; color: #fbe4e5; }
    #message .error,.message .error{border: 1px solid #eed3d7; background-color: #eeeeee; color: red; }
    .table td select{ width: 81px; }

</style>
<div class="box">
    <div class="tableBox">
    <?php include('_search.php'); ?>
        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
              <tr style="background-color: #e8e8e8;">
                  <th width="15%">账号名</th>
                  <th width="15%">真实姓名</th>
                  <th width="15%">联系电话</th>
                  <th width="20%">公司邮箱</th>
                  <th width="17%">创建时间</th>
                  <th width="6%">状态</th>
                  <th>操作</th>
<!--                  <th width="6%">删除</th>-->
              </tr>  
            </thead>
            <tbody>
                <?php if(count($data['model'])){  ?> 
                    <?php foreach($data['model'] as $user){?>
                        <tr>
                            <td><?php echo $user->username;?></td>
                            <td><?php echo $user->name;?></td>
                            <td><?php echo $user->mobile;?></td>
                            <td><?php echo $user->mail;?></td>
                            <td><?php echo date('Y-m-d H:i',strtotime($user->creationtime));?></td>
                            <td class="deleted_<?php echo $user->uid; ?>"><?php echo $user->getDisableState(); ?></td>
                            <td>
                                <a href="javascript:void(0);" rel="deleted" data-uid="<?php echo $user->uid; ?>" url="<?php echo Yii::app()->createUrl('user/setdisable/'.$user->uid);?>"><?php echo $user->getDisableState(true); ?></a>
                                &nbsp;&nbsp;<a href="<?php echo Yii::app()->createUrl('user/update/'.$user->uid);?>">编辑</a>
                                &nbsp;&nbsp;<a rel="deleLink" href="javascript:void(0);" data-href="<?php echo Yii::app()->createUrl('user/delete/'.$user->uid);?>">删除</a>
                                &nbsp;&nbsp;
                                <a rel="setPwd" href="javascript:void(0);" data-href="<?php echo Yii::app()->createUrl('user/initmemberpwd').'?uid='.$user['uid']; ?>">重置密码</a>
                            </td> 
                        </tr>
                    <?php } ?>
                <?php }else {?>
                    <tr>
                        <td colspan="7" align="center" style=" font-size: 21px; padding: 100px 0;">
                            暂无数据
                        </td> 
                    </tr> 
            <?php } ?> 
            </tbody>
        <!--    <tfoot>
                <tr>
                    <td colspan="7">

                    </td>
                </tr>  
            </tfoot>-->
        </table>
        <div id="pager">    
            <?php    
                $this->widget('CLinkPager',array(    
                    'header'=>'',    
                    'firstPageLabel' => '首页',    
                    'lastPageLabel' => '末页',    
                    'prevPageLabel' => '上一页',    
                    'nextPageLabel' => '下一页',    
                    'pages' => $data['pages'],    
                    'maxButtonCount'=>9    
                    )    
                );    
            ?>    
        </div>    
    </div>

    <div id="popupBoxRset" class="popupBox">
        <div id="popupInfo" style="padding: 30px;">
            <div class="centent">温馨提示：是否重置密码？</div>
        </div>
        <div style="text-align: center;">
            <a id="isSetPwd" href="javascript:void(0);" url="" class="btn btn-primary">确定</a> &nbsp;&nbsp;
            <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBoxRset');" class="btn btn-default">取消</a>
        </div> 
    </div>
    <div id="popupBox" class="popupBox">
        <div id="popupInfo" style="padding: 30px;">
            <div class="centent">温馨提示：是否删除当前用户？</div>
        </div>
        <div style="text-align: center;">
            <a id="isOk" href="" class="btn btn-primary">确定</a> &nbsp;&nbsp;
            <a href="javascript:void(0);" onclick="hidePormptMaskWeb('#popupBox');" class="btn btn-default">取消</a>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/jqueryui/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/popupVeiw.js"></script>
    <script type="text/javascript">
        //删除提醒
        $('[rel=deleLink] ').click(function () {
            var urls = $(this).data('href');
            $("#isOk").attr('href', urls);
            showPromptsIfonWeb('#popupBox');
        });
        $( "#dateTime" ).datepicker({//日期控件
            defaultDate: "+1w", 
            changeYear: true,
            numberOfMonths: 1
        }); 
        $("[rel=deleted]").click(function(){//用户启用停用操作
            url = $(this).attr("url");
            obj = $(this);
            $.ajax({  
                url:url,   
                type : 'POST',
                dataType : 'text',  
                contentType : 'application/x-www-form-urlencoded',  
                async : false,  
                success : function(mydata) {   
                        var show_data =mydata;
                        if(show_data=="启用"){
                             obj.text("停用");
                        }else{
                            obj.text("启用");
                        } 
                        $(".deleted_"+obj.data('uid')).text(show_data);
                },  
                error : function() {  
                        // alert("calc failed");  
                }  
            });
        })

         $(function () {
             //重置密码
            $('[rel=setPwd] ').click(function () {
                var urls = $(this).data('href');
                $("#isSetPwd").attr('url', urls);
                showPromptsIfonWeb('#popupBoxRset');
            });

            $('#isSetPwd').click(function(){ 
                $("#message,.message").remove();
                var url = $(this).attr('url');
                $.ajax({
                url:url,
                type : 'Get',
                data : {cid:""},
                dataType : 'json',
                contentType : 'application/x-www-form-urlencoded',
                async : false,
                success : function(mydata) {
                    hidePormptMaskWeb('#popupBoxRset');
                   if(mydata&&mydata.msg=='success'){
                            var tishi = '<div id="message"><div class="messageType success" id="type-success"><span >✔</span>&nbsp;&nbsp;密码已重置为'+mydata.password+'</div></div>';
                            $('body').append(tishi);
                            
                        }else{ 
                            var tishi = '<div id="message"><div class="messageType success" id="type-success"><span >✘</span>&nbsp;&nbsp;密码重置失败</div></div>';
                            $('body').append(tishi);
                        }
                        $('#message').show();
                        setTimeout( function() { $('#message').slideUp("slow");},3000); 
                }
                });
            });

        });

    </script>
</div>