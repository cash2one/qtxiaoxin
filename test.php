<?php

try {
    $a = $b['w'];
}catch (Exception $e){
   print_r(22222222);
}
$cb = new Couchbase("127.0.0.1:8091", "Administrator", "123456", "default");
$cb->set("doll", "bar");
echo 111;

?>