<?php


namespace App\Traits;

use App\Http\StatusCode;

/**
 * restful对象化CRUD
 *
 * Trait RestFul
 * @package App\Traits
 */
trait RestFul
{
    use Filter;

    /**
     * 保存模型操作对象
     *
     * @var mixed
     */
    private $model;

    /**
     * 初始化模型操作对象
     *
     * RestFul constructor.
     */
    public function __construct()
    {
        $this->model = $this->getModel();
    }

    /**
     * 返回列表数据
     *
     * @return mixed
     */
    public function index()
    {
        $data = $this->filter($this->model);
        return $this->Json(StatusCode::SUCCESS, $data);
    }

    /**
     * 返回指定Id数据
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $data = $this->model::findOrFail($id);
        return $this->Json(StatusCode::SUCCESS, ['data' => $data]);
    }

    /**
     * 创建模型数据
     *
     * @return mixed
     */
    public function store()
    {
        $filedValue = $this->formVerif($this->addRule());
        $createModel = $this->model::create($filedValue);
        if ($createModel) {
            return $this->Json(StatusCode::SUCCESS);
        }
        return $this->Json(StatusCode::ERROR);
    }

    /**
     * 更新指定Id模型数据
     *
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        $filedValue = $this->formVerif($this->editRule());
        $status = $this->model::findOrFail($id)->update($filedValue);
        if ($status) {
            return $this->Json(StatusCode::SUCCESS);
        }
        return $this->Json(StatusCode::ERROR);
    }

    /**
     * 删除模型数据
     *
     * @param $ids
     * @return mixed
     */
    public function destroy($ids)
    {
        $status = $this->model::destroy($ids);
        if ($status) {
            return $this->Json(StatusCode::SUCCESS);
        }
        return $this->Json(StatusCode::ERROR);
    }

    /**
     * 返回操作模型对象
     *
     * @return mixed
     */
    public abstract function getModel();

    /**
     * 获得模型添加字段认证规则
     *
     * @return mixed
     */
    public abstract function addRule();

    /**
     * 获得模型编辑认证字段规则
     *
     * @return mixed
     */
    public abstract function editRule();
}