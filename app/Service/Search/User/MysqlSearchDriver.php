<?php


namespace App\Service\Search\User;


use App\Models\User;
use App\Service\Search\User\Contract\SearchUserInterface;

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
     * 搜索方法
     *
     * @return array|mixed
     */
    public function search()
    {
        $query = User::query();
        //拼装查询
        if (!is_null($this->name)) {
            $query = $query->orWhere('name', 'like', '%'.$this->name.'%');
        }
        if (!is_null($this->signature)) {
            $query = $query->orWhere('signature', 'like', '%'.$this->signature.'%');
        }
        if (!is_null($this->phone)) {
            $query = $query->orWhere('phone', 'like', '%'.$this->phone.'%');
        }

        $this->user = $query->get()
                            ->toArray();

        $this->highLight();

        return $this->user;
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
        $str="在中国古典四大名著中，绝大多数儿童最喜欢的就是西游记。";//定义原始字符串
        $keyword="西游记";//指定要替换的关键字
        echo str_replace($keyword,"<font color=red><b>$keyword</b></font>",$str);//加粗加颜色

        foreach ($this->user as $key=>$userItem) {

        }
    }
}
