<?php


namespace App\Policy\Login\Contract;

/**
 * 登录接口
 *
 * Interface LoginInterface
 * @package App\Policy\LoginInterface\Contract
 */
interface LoginInterface
{
    /**
     * 主要登录函数
     *
     * @return mixed
     */
    public function login();

    /**
     * 检测用户状态,用户是否被封禁
     *
     * @return mixed
     */
    public function checkUserStatus();

    /**
     * 生成Token
     *
     * @return mixed
     */
    public function createToken();

    /**
     * 存储Token
     *
     * @param $tokne
     * @return mixed
     */
    public function storeToken($tokne);
}