<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 7/27/2018
 * Time: 2:03 PM
 */

namespace JimChen\MobSms\Contracts;

interface PhoneNumberInterface extends \JsonSerializable
{
    /**
     * 86.
     *
     * @return int
     */
    public function getIDDCode();

    /**
     * 18888888888.
     *
     * @return int
     */
    public function getNumber();

    /**
     * +8618888888888.
     *
     * @return string
     */
    public function getUniversalNumber();

    /**
     * 008618888888888.
     *
     * @return string
     */
    public function getZeroPrefixedNumber();

    /**
     * @return string
     */
    public function __toString();
}
