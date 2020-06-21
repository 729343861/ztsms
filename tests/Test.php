<?php
include "../vendor/autoload.php";

try {

    $sms =  Yangwenqu\ZtSms\ZtSms::getInstance('xhwh888hy','9F21SRBG');

    $sms1 =  Yangwenqu\ZtSms\ZtSms::getInstance();

    $res = $sms1->getBalance();


    var_dump($res);

}catch (Exception $e){

    var_dump($e->getMessage());
}
