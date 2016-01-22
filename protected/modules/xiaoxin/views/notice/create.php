<!--创建消息,通知 -->
<div class="header"> 
    <div class="titleText"><em></em>日常工作 > 布置作业</div>  
</div>
<div class="mianBox"> 
    <div id="submenuBoxR" class="submenuBoxR" data-viwe="show" >
        <div class="playerBox">
            <a id="player" href="javascript:void(0);" class="player playerOn" onclick="onClickHide('#submenuBoxR')"></a>
        </div>
        <div class="paneBox" style="background: #FFFFFF;">
            <div class="pheader"><em class="Pico"></em>选择分组</div>
            <div class="groupBox">
                <div class="titleName"><em class=""></em>某某学校</div>
                <ul>
                    <li><a rel="addClass" tid="0" data-uid="" data-cid="" href="javascript:void(0);">全部<span class="fright">✔</span></a></li>
                    <li><a rel="addClass" tid="0" data-uid="" data-cid="" href="javascript:void(0);">全部<span class="fright ">✔</span></a></li>
                    <li><a rel="addClass" tid="0" data-uid="" data-cid="" href="javascript:void(0);">全部<span class="fright">✔</span></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="contentBox" class="contentBox">
        <div class="box">
            <div class="headBox ">
                <div class="headNav noticeType_select">
                    <ul>
                        <li><a avalue="" href=" " class="focus" >班级</a></li>
                        <li><a avalue="2" href=" " >分组</a></li>
                        <li><a avalue="0" href=" " >学生</a></li>
                    </ul>
                </div>  
            </div>
            <div class="formBox">
               <form id="formBoxRegister" action="" method="post"> 
                   <table class="tableForm">
                        <tr>
                             <td>
                                 <div class="infoTitle" >〓 接收对象</div>
                             </td>
                        </tr>
                       <tr>
                            <td>
                                <div class="memberBox">
                                    <ul id="memberList">
                                        <li class="memberBtn"><a rel="addUserBtn" href="javascript:void(0);" ><em class="addBtnIco"></em> 添加成员</a></li> 
                                    </ul>
                                </div>
                                <div id="cuntUserCheck" class="cuntMember" >已选择了<span class="red">0</span>人<span id="cuntTip" style="display: none;" class="Validform_checktip Validform_wrong">至少添加一个成员</span></div>
                                <span class="Validform_checktip" ></span>
                                <div id="cacheBox" style="display: none;"> 
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="infoTitle" >〓 输入内容</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="margin-bottom: 10px;">家长称谓：
                                    <select>
                                        <option>xxx家长</option>
                                        <option>xxx家长</option>
                                        <option>xxx家长</option>
                                    </select>
                                </div>
                                <div>
                                    <textarea style="width: 100%; height: 120px; border:1px solid #E1E1E1;" placeholder="请这在里填写发送内容"></textarea>
                                </div>
                                <div class="fright" style="margin-top: 10px;">
                                    老师称谓：
                                    <select>
                                        <option>xxx家长</option>
                                        <option>xxx家长</option>
                                        <option>xxx家长</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="infoTitle" >〓 更多设置</div>
                                <div style="padding: 10px 0;"> <input type="checkbox"> 发送确认信息 </div>
                            </td>
                        </tr>
                         
                        <tr>
                            <td> 
                                <input id="submitForm" type="button" class="btn btn-raed"  value="保 存">
                                &nbsp;&nbsp;
                                <a href="" class="btn btn-default">定时发送</a>
                                &nbsp;&nbsp; 
                                <a href="" class="btn btn-default">取 消</a>
                            </td>
                        </tr>
                   </table> 
               </form>
            </div>
        </div> 
    </div>
</div>
<script type="text/javascript">
    $(function(){
        //添加成员
        $('[rel=addClass]').click(function(){
            var type =$(this).attr('tid');
            if(parseInt(type)==0){
                $(this).attr('tid',1);
                $(this).find('span').show();
            }else{
                $(this).attr('tid',0);
                $(this).find('span').hide();
            } 
        });
        //删除成员
        $('[rel=deleItime]').live('click',function(){
            alert(111);
            $(this).parent('li').remove();
        });
    });
</script>
