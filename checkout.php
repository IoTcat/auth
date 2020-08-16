<?php

include './functions.php';


$cnn = db__connect();

if(isset($_COOKIE['_token']) && db__rowNum($cnn, "token", "token", $_COOKIE['_token'])){
    db__pushData($cnn, "token", array(
        "state"=>'0'
    ), array(
        "token"=>$_COOKIE['_token']
    ));

}

setcookie("_token", "", time()-3600);
echo '<script>window.location.href="https://login.yimian.xyz/"</script>';
