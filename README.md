<h1 align="center">Express</h1>



第一次使用助通科技SMS平台接口,于是习惯性composer search 发现没有可用的包，然而官方只有简单的面向过程demo，为了方便自己和像我这样需要composer search的phper,所以编写了这个简单的包，如果有遇到bug请issue。



## 安装
```shell
composer require yangwenqu/ztsms
```

## 使用说明

```php
<?php

namespace App\Http\Controllers;

use Yangwenqu\ZtSms\ZtSms;

class DemoController
{

    public function index()
    {       
    
        try {
              //第一次实例的时候会需要构造参数，可在基类里提前把实例创建起来，在后面的使用中则不需要传入构造参数
              $ztsms = ZtSms::getInstance('username','password');
              //获取余额信息
              $blance = $ztsms->getBalance();
              //发送自定义短信，第二个参数必须包含签名【xxxx】
              $res = $ztsms->sendCustomizeMsg('phone',"【猎人】尊重的用户您好,您的验证码是:123456,请妥善保管！");
              if($res){
                //成功
              }       

         }catch (\Exception $e){
            
            var_dump($e->getMessage());
        
        }


    }

    
}
```
