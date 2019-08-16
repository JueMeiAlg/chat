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

    /**
     * 设置当前搜索页
     *
     * @param int $page
     * @return mixed
     */
    public function setPage(int $page);

    /**
     * 设置查询条数
     *
     * @param int $limit
     * @return mixed
     */
    public function setLimit(int $limit);

    /**
     * 总数
     *
     * @return mixed
     */
    public function total();
}
