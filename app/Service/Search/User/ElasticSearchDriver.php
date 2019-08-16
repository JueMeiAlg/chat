<?php


namespace App\Service\Search\User;


use App\Service\Search\User\Contract\SearchUserInterface;

/**
 * 搜索用户采用es搜索引擎实现
 *
 * Class ElasticSearchDriver
 * @package App\Service\Search\User
 */
class ElasticSearchDriver implements SearchUserInterface
{
    /**
     * 设置需要搜索的名字
     *
     * @param string $name
     * @return mixed|void
     */
    public function setName(string $name)
    {
        // TODO: Implement setName() method.
    }

    /**
     * 设置需要搜索的电话
     *
     * @param string $phone
     * @return mixed|void
     */
    public function setPhone(string $phone)
    {
        // TODO: Implement setPhone() method.
    }

    /**
     * 设置需要搜索的签名
     *
     * @param string $signature
     * @return mixed|void
     */
    public function setSignature(string $signature)
    {
        // TODO: Implement setSignature() method.
    }

    /**
     * 主要搜索方法
     *
     * @return mixed|void
     */
    public function search()
    {
        // TODO: Implement search() method.
    }

    /**
     * 查询结果高亮
     *
     * @return mixed|void
     */
    public function highLight()
    {
        // TODO: Implement highLight() method.
    }

    /**
     * 设置当前搜索页
     *
     * @param int $page
     * @return mixed|void
     */
    public function setPage(int $page)
    {
        // TODO: Implement setPage() method.
    }

    /**
     * 设置数据大小
     *
     * @param int $limit
     * @return mixed|void
     */
    public function setLimit(int $limit)
    {
        // TODO: Implement setLimit() method.
    }

    /**
     * 总数
     *
     * @return mixed|void
     */
    public function total()
    {
        // TODO: Implement total() method.
    }
}
