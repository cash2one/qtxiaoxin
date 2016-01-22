<div class="box">
    <div class="tableBox">
    <?php include('_msearch.php'); ?> 
        <table class="table table-bordered table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
                <tr style="background-color: #e8e8e8;">  
                    <th width="30%">标题</th>
                    <th width="18%">公众号ID</th>
                    <th width="18%">时间</th>
                    <th>操作</th> 
                </tr>  
            </thead>
            <tbody>
                <?php if(count($data['model'])){  ?> 
                    <?php foreach($data['model'] as $message){?>
                        <tr>
                            <td><?php echo $message->title;?></td>
                            <td><?php echo $message->offic->openid;?></td>                            
                            <td><?php echo ($message->send != 1)?'<font color="green">'.date('Y-m-d H:i',strtotime($message->publishtime)) . '</font>' : '<font color="red">' . date('Y-m-d H:i',strtotime($message->creationtime)) . '</font>'; ?></td>
                            <td>
                                <a href="<?php echo Yii::app()->request->baseUrl . '/index.php/official/default/remotemessage?msgid='.$message->msgid . '&infoid=' . $message->infoid; ?>">查看</a>&nbsp;&nbsp;
                                <a rel="msglockOfficial"  types="<?php echo $message->close; ?>" id="msglocks_<?php echo $message->msgid;?>" sid="<?php echo $message->msgid;?>" href="javascript:;" data-href="<?php echo Yii::app()->createUrl('official/msglock/'.$message->msgid); ?>"><?php echo ($message->send == 2 && $message->close == 1)?'封帖':($message->close == 2?'解封':'');?></a>
                            </td>
                        </tr>
                    <?php } ?> 
                <?php }else {?>
                        <tr>
                            <td colspan="8" align="center" style=" font-size: 21px; padding: 100px 0;">
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
    <div id="msglockBlockBox" class="popupBox" style="width:540px; height: 305px;">
        <div class=" header"><span class="title">封贴原因</span><a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#msglockBlockBox')"> </a></div>
        <div class="remindInfo" style="padding: 15px 10px 5px 10px; "> 
            <textarea id="textBlockContent"  style="width:100%;; height: 160px; resize: none;" placeholder="请在这里输入原因,最多输入100个字！" name="reason"></textarea>
            <div><span  class="inputRedinfo" style=" display: none; color: #E95B5F;">请填写原因,最多输入100个字</span>&nbsp;</div>
        </div>
        <div class="popupBtn" style="text-align: center;">
            <a id="msglockSendBnts" href="javascript:;" sid="" url="" class="btn btn-primary">确 定</a>&nbsp;&nbsp;&nbsp;
            <a href="javascript:void(0);" rel="isNotOkCancel" class="btn btn-default">取 消</a>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/business/prompt.js" ></script>
    <script type="text/javascript">
         $(function(){
            //封号、解封
            $('[rel=msglockOfficial]').click(function(){ 
                var url =$(this).data('href'); 
                var offId = $(this).attr("sid");
                var types =$(this).attr('types');  
                $('#msglockSendBnts').attr('url',url);
                $('#msglockSendBnts').attr('sid',offId); 
                if(parseInt(types)==2){
                    $("#msglockBlockBox").find('.header').find('.title').text('解封理由'); 
                }else{
                    $("#msglockBlockBox").find('.header').find('.title').text('封贴理由');  
                }
                showPromptsIfonWeb('#msglockBlockBox');
            });
            //确认操作
            $("#msglockSendBnts").click(function(){ 
                var urls =$(this).attr('url');
                var conten =$.trim($('#textBlockContent').val());
                if(conten.length>0 && conten.length<=100){
                    var offId = $(this).attr("sid");
                    ajaxPBolock(conten,urls,offId);
                    hidePormptMaskWeb('#msglockBlockBox');
                }else{
                    $(".inputRedinfo").show();
                }

            });
            //
            $("#textBlockContent").keydown(function(){ 
                $(".inputRedinfo").hide();
            });
            //取消封号、解封操作
            $('[rel=isNotOkCancel]').click(function(){
                hidePormptMaskWeb('#msglockBlockBox');
                $('#textBlockContent').val('');
                $(".inputRedinfo").hide();
            });

            //请求
            function ajaxPBolock(val,ajaxurl,offId){ 
                $.ajax({  
                    url:ajaxurl,   
                    type : 'POST',
                    data:{reason:val},
                    dataType : 'text',  
                    contentType : 'application/x-www-form-urlencoded',  
                    async : false,  
                    success : function(mydata) {   
                        var show_data =$.parseJSON(mydata); 
                        if(show_data.state){
                            if(show_data.type == '2'){ 
                                $('#msglocks_'+offId).text("解封"); 
                            }else{
                                $('#msglocks_'+offId).text("封帖");  
                            }
                            $('#msglocks_'+offId).attr('types',show_data.type);
                        }else{ }
                        $('#textBlockContent').val('');
                        $(".inputRedinfo").hide();
                    },  
                    error : function() {  
                       // $("#popupInfo").html("加载出错");  
                    }  
                });
            }
         });
    </script>
</div>


  
