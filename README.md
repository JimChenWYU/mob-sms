<h1 align="center">Mob SMS</h1>

<p align="center">:calling: mob.com免费短信验证后端校验接口SDK</p>

[官网文档](http://sms.mob.com/)

### 安装

`$ composer require "jimchen/mob-sms"`

### 环境需求

- PHP >= 5.5

### 使用

```php
$sms = new MobSms([
    'appkey' => '27xxxxxxxxx',
    'zone'   => 86   // 区号
]);

$sms->verify('phone number', 'verification code');
```

### License
MIT
