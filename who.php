<?php

header('Access-Control-Allow-Origin:*');

include './functions.php';

$mask = $_REQUEST['mask'];
$ip = $_REQUEST['ip'];
$fp = $_REQUEST['fp'];

if(!isset($mask) || strlen($mask)!=64 || !isset($ip) || strlen($ip)<8 || strlen($ip)>16 || !isset($fp) || strlen($fp)!=6) {
    header('status: 505 Illegal Params');
    die();
};

/* special php program */
set_time_limit(0);
ob_end_clean();
header("Connection: close");
header("HTTP/1.1 200 OK");
header("Content-Type: application/json;charset=utf-8");
header('Access-Control-Allow-Origin:*');
ob_start();



$cnn = db__connect();

if(db__rowNum($cnn, "mask", "mask", $mask)){
    $token = db__getData($cnn, "mask", "mask", $mask)[0]['token'];
    echo json_encode(array(
        "code"=> 200
    ));
}else{
    $fip = md5($fp.$ip);
    if($redis->exists('auth/fip/'.$fip)){
        $token = $redis->get('auth/fip/'.$fip);
        db__pushData($cnn, "mask", array(
            "mask"=>$mask,
            "token"=>$token,
            "created_at"=>date("Y-m-d H:i:s", time())
        ), array(
            "mask"=>$mask
        ));        
        echo json_encode(array(
            "code"=> 200
        ));
    }else{
        echo json_encode(array(
            "code"=> 404
        ));
    }
    die();
}


/* close connection */
ob_end_flush();
flush();
if (function_exists("fastcgi_finish_request")) {
    fastcgi_finish_request();
}
sleep(2);
ignore_user_abort(true);
set_time_limit(0);

if(db__rowNum($cnn, "fip", "token", $token, "mask", $mask, "fp", $fp, "ip", $ip)){
    db__pushData($cnn, "fip", array(
        "updated_at"=>date("Y-m-d H:i:s", time())
    ), array(
        "token"=>$token,
        "mask"=>$mask,
        "fp"=>$fp,
        "ip"=>$ip
    ));
}else{
    db__pushData($cnn, "fip", array(
        "token"=>$token,
        "mask"=>$mask,
        "fp"=>$fp,
        "ip"=>$ip,
        "created_at"=>date("Y-m-d H:i:s", time())
    ));
}

die();
