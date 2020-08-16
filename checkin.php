<?php
include './functions.php';

$redis = new redis();
$redis->connect('redis',6379);


$fp = $_REQUEST['fp'];
$mask = $_REQUEST['mask'];
$token = $_REQUEST['token'];
$ip = $_REQUEST['ip'];
if(!isset($fp)) die();
if(!isset($mask)) die();


$id = md5($fp.$mask);


if(isset($token) && isset($ip)){
    $fip = md5($fp.$ip);
    $redis->set('auth/fip/'.$fip, $token);
    $redis->expire('auth/fip/'.$fip, 3600*72);
}

if(isset($ip) && !isset($token)){
    $fip = md5($fp.$ip);
    if($redis->exists('auth/fip/'.$fip)){
        $token = $redis->get('auth/fip/'.$fip);
    }else{
        die();
    }
}

if(!$redis->exists('auth/token/'.$token)){
    $redis->set('session/redirect/'.$id, $token);
    if(!$redis->exists('session/dialog/'.$token)){
        $redis->hMset('session/dialog/'.$token, array("group"=>"anonymous"));
    }
    echo $token;
    die();
}

$cnn = db__connect();
$hash =  $redis->get('auth/token/'.$token);
if(!db__rowNum($cnn, "account", "hash", $hash)){
    $redis->set('session/redirect/'.$id, $token);
    $redis->del('auth/token/'.$token);
    if(!$redis->exists('session/dialog/'.$token)){
        $redis->hMset('session/dialog/'.$token, array("group"=>"anonymous"));
    }
}else{
    $redis->set('session/redirect/'.$id, $token);
    if(!$redis->exists('session/dialog/'.$hash)){
        $data = db__getData($cnn, "account", "hash", $hash);
        foreach($data[0] as $key=>$val){
            $redis->hSet('session/dialog/'.$hash, $key, $val);
        }
    }
}

echo $token;

