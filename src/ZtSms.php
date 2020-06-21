<?php

namespace Yangwenqu\ZtSms;


class ZtSms
{
    private static $instance = null;
    private $username;
    private $password;

    private $host = "https://api.mix2.zthysms.com/v2/";
    private $balanceApi = "balance";
    private $sendSmsApi = "sendSms";

    private function __construct($username,$password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public static function getInstance($username = "",$password="")
    {
        if(self::$instance === null){
            if(empty($username)){
                throw new \Exception('username is empty!');
            }
            if(empty($password)){
                throw new \Exception('password is empty!');
            }

            self::$instance = new self($username,$password);
        }
        return self::$instance;
    }

    public function getBalance(){

        $timestamp = time();
        $params = [
            'username' => $this->username,
            'password' => md5(md5($this->password).$timestamp),
            'tKey'    => $timestamp
        ];

        $result = $this->httpPost($this->balanceApi,$params);
        $data = json_decode($result,true);

        if($data['code'] != 200){

            return false;
        }

        return $data['sumSms'];

    }


    /**
     * 自定义短信消息
     * @param $mobile
     * @param $message
     * @return bool
     * @throws \Exception
     */
    public function sendCustomizeMsg($mobile,$message){

        if(!$mobile){
            throw new \Exception('mobile is empty!');
        }
        if(!$message){
            throw new \Exception('message is empty!');
        }
        $timestamp = time();
        $params = [
            'username' => $this->username,
            'password' => md5(md5($this->password).$timestamp),
            'tKey'    => $timestamp,
            'mobile'   =>  $mobile,
            'content'  => $message
        ];

        $result = $this->httpPost($this->sendSmsApi,$params);

        $data = json_decode($result,true);

        if($data['code'] != 200){

            return false;
        }

        return true;

    }


    protected function httpPost($apiRoute, $params) { // 模拟提交数据函数

        $url = $this->host.$apiRoute;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8'
        ));
        $result = curl_exec($curl);
        if (curl_errno($curl)) {
            throw new \Exception(curl_error($curl));
        }
        curl_close($curl);
        return $result;
    }

}