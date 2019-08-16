<?php


namespace App\Service\Search\Contract;

/**
 * 搜索接口
 *
 * Interface SearchInterface
 * @package App\Service\Search\Contract
 */
interface SearchInterface
{
    /**
     * 主要搜索方法
     *
     * @return mixed
     */
    public function search();

    /**
     * 查询结果高亮
     *
     * @return mixed
     */
    public function highLight();
}
