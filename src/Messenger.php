<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 7/27/2018
 * Time: 2:10 PM
 */

namespace JimChen\MobSms;

use JimChen\MobSms\Support\Config;
use JimChen\MobSms\Traits\HasHttpRequest;
use JimChen\MobSms\Contracts\MessengerInterface;
use JimChen\MobSms\Contracts\PhoneNumberInterface;
use JimChen\MobSms\Exceptions\RequestErrorException;

class Messenger implements MessengerInterface
{
    use HasHttpRequest;

    const DEFAULT_ZONE = 86;

    const ENDPOINT_HOST = 'webapi.sms.mob.com';

    const ENDPOINT_URI = '/sms/verify';

    /**
     * @var MobSms
     */
    protected $mobSms;

    /**
     * Messenger constructor.
     * @param MobSms $mobSms
     */
    public function __construct(MobSms $mobSms)
    {
        $this->mobSms = $mobSms;
    }

    /**
     * Send message.
     *
     * @param PhoneNumberInterface $to
     * @param string               $code
     * @return array
     * @throws RequestErrorException
     */
    public function verify(PhoneNumberInterface $to, $code)
    {
        $headers = [
            'content-type' => 'application/x-www-form-urlencoded;charset=UTF-8',
            'accept'       => 'application/json',
        ];

        $result = $this->request('post', $this->buildEndpoint($this->mobSms->getConfig()), [
            'headers'     => $headers,
            'form_params' => [
                'appkey' => $this->mobSms->getConfig()->get('appkey'),
                'zone'   => $to->getIDDCode() ?: $this->mobSms->getConfig()->get('zone', static::DEFAULT_ZONE),
                'phone'  => $to->getNumber(),
                'code'   => $code,
            ],
            'exceptions'  => false,
        ]);

        if (is_string($result)) {
            $result = json_decode($result, true);
        }

        if (200 != $result['status']) {
            throw new RequestErrorException($this->getErrorMessage($result['status']), $result['status'], $result);
        }

        return $result;
    }

    /**
     * Build endpoint url.
     *
     * @param Config $config
     *
     * @return string
     */
    protected function buildEndpoint(Config $config)
    {
    	$schema = $config->get('https', true) ? 'https' : 'http';
        return $schema . '://' . $config->get('domain', self::ENDPOINT_HOST) . self::ENDPOINT_URI;
    }

    /**
     * Error Message.
     *
     * @param $code
     * @return string
     */
    protected function getErrorMessage($code)
    {
        $errorMappers = [
            200 => '验证成功',
            405 => 'AppKey为空',
            406 => 'AppKey无效',
            456 => '国家代码或手机号码为空',
            457 => '手机号码格式错误',
            466 => '请求校验的验证码为空',
            467 => '请求校验验证码频繁（5分钟内同一个appkey的同一个号码最多只能校验三次）',
            468 => '验证码错误',
            474 => '没有打开服务端验证开关',
        ];

        return isset($errorMappers[$code]) ? $errorMappers[$code] : '未知错误';
    }
}
