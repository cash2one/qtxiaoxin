<html>
<head>
	<meta charset="utf-8">
</head>
<body>
<!--<div>错误代码：<?php echo $error["code"]; ?></div>
<div>错误提示：<?php echo $error["title"]; ?></div>
<div>错误请求：<?php echo $error["message"]; ?></div>-->
<div style="text-align: center;">
            <h1>错误代码：<?php echo $error["code"]; ?></h1>
            <div>
                <h3>
                    对不起，你访问的页面<?php echo $error["title"]; ?>
                </h3> &nbsp;&nbsp;
                <a href="javascript:window.history.back();">返回首页</a>
            </div>
    </div>
</body>
</html>