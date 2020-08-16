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
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>Ushio Auth</title><meta name=viewport content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no"><meta name="keywords" content="iotcat,呓喵酱,yimian"><link rel="shortcut icon" href="https://cdn.yimian.xyz/img/head/head3r.ico"><style type="text/css">.chromeframe{margin:.2em 0;background:#ccc;color:#000;padding:.2em 0}#loader-wrapper{position:fixed;top:0;left:0;width:100%;height:100%;z-index:999999}#loader{display:block;position:relative;left:50%;top:50%;width:150px;height:150px;margin:-75px 0 0 -75px;border-radius:50%;border:3px solid transparent;border-top-color:#FFF;-webkit-animation:spin 2s linear infinite;-ms-animation:spin 2s linear infinite;-moz-animation:spin 2s linear infinite;-o-animation:spin 2s linear infinite;animation:spin 2s linear infinite;z-index:1001}#loader:before{content:"";position:absolute;top:5px;left:5px;right:5px;bottom:5px;border-radius:50%;border:3px solid transparent;border-top-color:#FFF;-webkit-animation:spin 3s linear infinite;-moz-animation:spin 3s linear infinite;-o-animation:spin 3s linear infinite;-ms-animation:spin 3s linear infinite;animation:spin 3s linear infinite}#loader:after{content:"";position:absolute;top:15px;left:15px;right:15px;bottom:15px;border-radius:50%;border:3px solid transparent;border-top-color:#FFF;-moz-animation:spin 1.5s linear infinite;-o-animation:spin 1.5s linear infinite;-ms-animation:spin 1.5s linear infinite;-webkit-animation:spin 1.5s linear infinite;animation:spin 1.5s linear infinite}@-webkit-keyframes spin{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}100%{-webkit-transform:rotate(360deg);-ms-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes spin{0%{-webkit-transform:rotate(0deg);-ms-transform:rotate(0deg);transform:rotate(0deg)}100%{-webkit-transform:rotate(360deg);-ms-transform:rotate(360deg);transform:rotate(360deg)}}#loader-wrapper .loader-section{position:fixed;top:0;width:51%;height:100%;background:#1abc9c;z-index:1000;-webkit-transform:translateX(0);-ms-transform:translateX(0);transform:translateX(0)}#loader-wrapper .loader-section.section-left{left:0}#loader-wrapper .loader-section.section-right{right:0}#loader-wrapper .load_title{font-family:"Open Sans";color:#FFF;font-size:19px;width:100%;text-align:center;z-index:9999999999999;position:absolute;top:60%;opacity:1;line-height:30px}#loader-wrapper .load_title span{font-weight:normal;font-style:italic;font-size:13px;color:#FFF;opacity:.5}</style></head><body><div id="loader-wrapper" ><div id="loader"></div><div class="loader-section section-left"></div><div class="loader-section section-right"></div><div class="load_title">正在检测您的设备安全( • ̀ω•́ )✧<br><span id="ino">Anti-DDOS..</span></div></div><script>function newUrl(url){if(url.indexOf("?")==-1){if(url.indexOf("#")==-1){return url+"?t="+(new Date).valueOf()}else{return url.slice(0,url.indexOf("#"))+"?t="+(new Date).valueOf()+url.slice(url.indexOf("#"))}}else{if(url.indexOf("#")==-1){return url+"&t="+(new Date).valueOf()}else{return url.slice(0,url.indexOf("#"))+"&t="+(new Date).valueOf()+url.slice(url.indexOf("#"))}}};setTimeout(function(res){document.getElementById("info").innerHTML="Network Checking..";setTimeout(function(res){document.getElementById("info").innerHTML="Decide Best Strategy..";setTimeout(function(res){document.getElementById("info").innerHTML="Connecting..";setTimeout(function(res){document.getElementById("info").innerHTML="Loading.."},600)},800)},800)},800);</script>';
echo "<script>setTimeout(()=>{window.location.href='$from'}, 1000)</script></body></html>";