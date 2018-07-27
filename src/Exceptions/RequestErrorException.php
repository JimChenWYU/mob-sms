<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 7/27/2018
 * Time: 2:33 PM
 */

namespace JimChen\MobSms\Exceptions;

/**
 * Class RequestErrorException
 * @package JimChen\MobSms\Exceptions
 */
class RequestErrorException extends \Exception
{
    /**
     * @var array
     */
    public $raw = [];

    /**
     * GatewayErrorException constructor.
     *
     * @param string $message
     * @param int    $code
     * @param array  $raw
     */
    public function __construct($message, $code, array $raw = [])
    {
        parent::__construct($message, intval($code));
        $this->raw = $raw;
    }
}