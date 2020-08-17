<?php

include './functions.php';

$seed = $_REQUEST['seed'];
$ip = $_REQUEST['ip'];
$fp = $_REQUEST['fp'];

if(!isset($seed) || strlen($seed)!=64 || !isset($ip) || strlen($ip)<8 || strlen($ip)>16 || !isset($fp) || strlen($fp)!=6) {
    header('status: 505 Illegal Params');
    die();
};


header("Content-Type: application/json;charset=utf-8");

$fip = md5($fp.$ip);


// bad seed
if(!$redis->exists('auth/seed/'.$seed)){
    echo json_encode(array(
        "code"=>400,
        "message"=>"Bad Seed!"
    ));
    die();
}


$token = $redis->get('auth/seed/'.$seed);

//bad token
if(strlen($token)!=64){
    echo json_encode(array(
        "code"=>500,
        "message"=>"Bad token!"
    ));
    die();
}


//good
$redis->set('auth/fip/'.$fip, $token);
$redis->expire('auth/fip/'.$fip, 60);
echo json_encode(array(
    "code"=>200
));

