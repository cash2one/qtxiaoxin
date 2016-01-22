<?php 
require_once("/qiniuphp/rs.php");

$bucket = "hwgq2005";
$accessKey = '00M0wHVcHJbGa6JSY2rCKaxkuXQHoz1jN6q5VUDc';
$secretKey = 'rk2tlj1SkN4dkYF39mXHR8vkCyA363MqYsrKE3zY';

Qiniu_SetKeys($accessKey, $secretKey);
$putPolicy = new Qiniu_RS_PutPolicy($bucket);
$upToken = $putPolicy->Token(null);
echo '{"uptoken": "'.$upToken.'"}';
?> 