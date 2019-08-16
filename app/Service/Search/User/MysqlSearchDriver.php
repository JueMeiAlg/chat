<?php


namespace App\Service\Search\User;


use App\Models\User;
use App\Service\Search\User\Contract\SearchUserInterface;
use Illuminate\Support\Facades\Auth;

/**
 * 实现搜索用户接口,采用mysql去模糊匹配用户
 *
 * Class MysqlSearchDriver
 * @package App\Service\Search\User
 */
class MysqlSearchDriver implements SearchUserInterface
{
    /**
     * 想查找的用户名
     *
     * @var
     */
    protected $name = null;

    /**
     * 想查找的手机号
     *
     * @var
     */
    protected $phone = null;

    /**
     * 想查找的签名
     *
     * @var
     */
    protected $signature = null;
    /**
     * 当前查询页
     *
     * @var int
     */
    protected $page = 0;
    /**
     * 数据限制条数
     *
     * @var int
     */
    protected $limit = 0;

    /**
     * 查询结构
     *
     * @var array
     */
    protected $user;

    /**
     * 设置要被搜索的名字
     *
     * @param string $name
     * @return $this|mixed
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * 要搜索的电话号码
     *
     * @param string $phone
     * @return $this|mixed
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * 要查找的签名
     *
     * @param string $signature
     * @return $this|mixed
     */
    public function setSignature(string $signature)
    {
        $this->signature = $signature;
        return $this;
    }

    /**
     * 设置当前搜索页
     *
     * @param int $page
     * @return $this|mixed
     */
    public function setPage(int $page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * 设置限制条数
     *
     * @param int $limit
     * @return $this|mixed
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * 搜索方法
     *
     * @return array|mixed
     */
    public function search()
    {
        $query = User::query();
        //拼装查询
        if (!is_null($this->name)) {
            $query = $query->orWhere('name', 'like', '%' . $this->name . '%');
        }
        if (!is_null($this->signature)) {
            $query = $query->orWhere('signature', 'like', '%' . $this->signature . '%');
        }
        if (!is_null($this->phone)) {
            $query = $query->orWhere('phone', 'like', '%' . $this->phone . '%');
        }

        $this->user = $query
            //把自己排除在外
            ->where('id', '!=', Auth::id())
            ->skip(($this->page -1) * $this->limit)
            ->take($this->limit)
            ->get()
            ->toArray();

        $this->highLight();

        return ['users'=>$this->user, 'total'=>$this->total()];
    }

    /**
     * 查询结果高亮
     *
     * @return mixed|void
     */
    public function highLight()
    {
        //查询结果为空直接返回
        if (empty($this->user)) {
            return $this->user;
        }

        foreach ($this->user as $key => $userItem) {

            if (!is_null($this->name)) {
                $this->user[$key]['name'] = str_replace($this->name, "<font color=red><b>$this->name</b></font>", $userItem['name']);
            }
            if (!is_null($this->signature)) {
                $this->user[$key]['signature'] = str_replace($this->signature, "<font color=red><b>$this->signature</b></font>", $userItem['signature']);
            }
            if (!is_null($this->phone)) {
                $this->user[$key]['phone'] = str_replace($this->phone, "<font color=red><b>$this->phone</b></font>", $userItem['phone']);
            }
        }
    }

    /**
     * 返回所有能正常登陆的用户总数
     *
     * @return int|mixed
     */
    public function total()
    {
        return User::query()
            ->where('id', '!=', Auth::id())//自己除开
            ->where('status', User::NORMAL)
            ->count();
    }
}
