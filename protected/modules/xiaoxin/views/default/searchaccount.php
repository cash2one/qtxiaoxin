<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit|ie-comp">
     <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/jquery-1.7.2.min.js" type="text/javascript"></script>
     <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/xiaoxin/searchSignStyle.css">
    <style>

    </style>
</head>

<body>
    <div  class="layout_div"> 
        <div class="layout_main" style="margin-top: 20%;" >
            <div class="logo">
                <a href=""> <img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/re-logo.png"></a>
            </div>
            <div class="layout_conrent">
                <div class="fromBox">
                    <form action="" method="get">
                        <div class="title">找回帐号</div>
                        <div class="input userName">
                            <span class="valueSpan" style="color: rgb(153, 153, 153); display: block;">请输入学校ID</span>
                            <input type="text" name="sid" class="textInput" value="" /> 
                        </div> 
                        <div class="input password" >
                            <span class="valueSpan" style="color: rgb(153, 153, 153); display: block;">请输入学生姓名</span>
                            <input type="text" name="name" class="textInput"  value=""/> 
                        </div>
                        <div class="red rememberme" id="tip" ></div>
                        <div class="bBottomBox">
                            <input type="hidden" value="aa" name="search"/>
                            <!--<input type="submit" value="查 找"/>--> 
                            <a href="javascript:;" id="search-btn"><img src="<?php echo Yii::app()->request->baseUrl; ?>/image/xiaoxin/login/searchBtn.jpg"/></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
     <div id="userBox" class="popupBox" style="width: 950px;">
        <div class="header"><i class="remenber-icon"></i>找回帐号<a href="javascript:void(0);" class="close" onclick="hidePormptMaskWeb('#userBox')" > </a></div>
        <div  style=" padding:15px;">
              <table class="table table-bordered" > 
                   <thead>
                      <tr >
                        <th style="width:30%" >学校</th>
                        <th style="width:20%">班级</th>
                        <th style="width:30%">学号</th>
                        <th >姓名</th>
                       </tr>
                   </thead>
                   <tbody id="user-list">
                       
                   </tbody>
              </table>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/input.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/xiaoxin/prompt.js" type="text/javascript"></script>
    <script>
        var register=function(){
            var search=$('#search-btn'),
                userList=$('#user-list'),
                url=location.href;
            var updateurl="<?php echo Yii::app()->createUrl('/xiaoxin/default/updateaccount');?>";
             
            search.on('click',function(){
                var sid=$('input[name=sid]').val();
                var name=$('input[name=name]').val();
                var _html="";
                if (sid !='') {
                    if (name !='') {
                         $.ajax({
                            url: url,
                            type: 'POST',
                            dataType: 'JSON',
                            data: {sid:sid,name:name,search:1}
                        }).done(function(data) {
                        
                           if (data.num > 1 ) {
                                $.each(data.data,function(index,val){
                                     _html+='<tr class="tr-click" data-userid="'+val.userid+'"  data-cid="'+val.cid+'" ><td class="school-list">'+val.schoolname+'</td><td>'+val.classname+'</td><td>'+val.studentid+'</td><td class="user-name ">'+val.name+'</td></tr>';
                                })
                                userList.html(_html);
                                showPromptsRemind('#userBox');
                                $('#user-list').on('click','.tr-click',function(){
                                    var uid=$(this).data('userid'),
                                        cid=$(this).data('cid');
                                     window.location=updateurl+'?userid='+uid+'&cid='+cid;

                                })

                           }else if (data.num == '1') {
                                window.location=updateurl+'?userid='+data.data[0].userid+'&cid='+data.data[0].cid;
                           }else{
                                $('#tip').text('该帐号不存在').show();
                           };

                        })
                    }else{
                        $('#tip').text('请输入学生姓名').show();
                    };
                }else{
                    $('#tip').text('请输入学校ID').show();
                };
            })
           
        }
        $(function(){
            register();
        })
    </script>
</body>
</html>