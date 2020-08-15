<?php
include './functions.php';

$redis = new redis();
$redis->connect('redis',6379);

if (isset($_COOKIE["_token"])){
    $redis->del('auth/token/'.$_COOKIE['_token']);
}

$token = $_REQUEST['token'];
$from = $_REQUEST['from'];
if(!isset($token)) die();
if(!isset($from)) die();

if(strlen($token) < 60 || !$redis->exists('auth/token/'.$token)){
    echo "<script>alert('Illegal Token!!');window.location.href='https://login.yimian.xyz/'</script>";
    die();
}

setcookie("_token", $token, time()+60*60*24*30*6);


echo '<html><head><script src="https://cdn.yimian.xyz/ushio-js/ushio-head.min.js"></script>';
echo '<script src="https://cdn.yimian.xyz/ushio-js/ushio-footer.min.js"></script>';
echo '</head><body>';
echo "<script>setTimeout(()=>{window.location.href='$from'}, 1000)</script></body></html>";
