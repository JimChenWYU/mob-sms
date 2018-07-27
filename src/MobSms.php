<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 7/27/2018
 * Time: 1:49 PM
 */

namespace JimChen\MobSms;

use JimChen\MobSms\Contracts\MessengerInterface;
use JimChen\MobSms\Contracts\PhoneNumberInterface;
use JimChen\MobSms\Support\Config;

class MobSms
{
    /**
     * @var MessengerInterface
     */
    protected $messenger;

    /**
     * @var Config
     */
    protected $config;

    /**
     * MobSms constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);
    }

    /**
     * @return MessengerInterface
     */
    public function getMessenger()
    {
        return $this->messenger ?: $this->messenger = new Messenger($this);
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Send Message.
     *
     * @param $to
     * @param $code
     * @return mixed
     */
    public function verify($to, $code)
    {
        $to = $this->formatPhoneNumber($to);

        return $this->getMessenger()->verify($to, $code);
    }

    /**
     * @param string|PhoneNumberInterface $number
     *
     * @return PhoneNumber
     */
    protected function formatPhoneNumber($number)
    {
        if ($number instanceof PhoneNumberInterface) {
            return $number;
        }

        return new PhoneNumber(trim($number));
    }
}
