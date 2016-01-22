<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <div style="text-align: center;">
        <?php if($code==404){ ?> 
            <h1>Error：<?php echo $code; ?></h1>
            <div>
                <h3> 对不起，你访问的页面不存在 ！</h3> 
                <a href="/admin.php">返回首页</a>
            </div> 
        <?php } ?> 
        <?php if($code==500){ ?> 
            <h1>Error：<?php echo $code; ?></h1>
            <div>
                <h3>对不起， <?php echo CHtml::encode($message); ?>！稍后再试。</h3>&nbsp;&nbsp;<a href="">返回首页</a> 
            </div> 
        <?php } ?> 
        <?php if($code==502){ ?> 
            <h1>Error：<?php echo $code; ?></h1>
            <div>
                <h3>对不起，<?php echo CHtml::encode($message); ?>！稍后再试。</h3>&nbsp;&nbsp;<a href="">返回首页</a> 
            </div> 
        <?php } ?>
    </div>  
</body>
</html>