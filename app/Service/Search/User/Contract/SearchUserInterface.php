<?php


namespace App\Service\Search\User\Contract;

use App\Service\Search\Contract\SearchInterface;

/**
 * 搜索用户接口
 *
 * Interface SearchUserInterface
 * @package App\Service\Search\User\Contract
 */
interface SearchUserInterface extends SearchInterface
{
    /**
     * 设置需要搜索的手机号
     *
     * @param string $phone
     * @return mixed
     */
    public function setPhone(string $phone);

    /**
     * 设置需要搜索的名字
     *
     * @param string $name
     * @return mixed
     */
    public function setName(string $name);

    /**
     * 设置需要搜索的签名
     *
     * @param string $signature
     * @return mixed
     */
    public function setSignature(string  $signature);

}
