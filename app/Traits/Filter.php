<?php

namespace App\Traits;

/**
 * 列表数据过滤
 *
 * Trait Filter
 * @package App\Traits
 */
trait Filter
{
    /**
     * 过滤数据
     *
     * @param $model
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function filter($model)
    {
        try {
            $page = request()->input('page', 1);
            $limit = request()->input('limit', 10);
            $orderBy = explode(',', request()->input('orderBy', 'id,desc'));
            $search = request()->input('search', false);
            $where = request()->input('where', false);
            if (request()->isMethod('get')) {
                $search = $search ? json_decode($search, true) : false;
                $where = $where ? json_decode($where, true) : false;
            }
            if ($where) {
                $where = array_filter($where, function ($var) {
                    return $var !== '' || $var !== null;
                });
                foreach ($where as $k => $v) {
                    if (is_array($v)) {
                        $model = $model->whereIn($k, $v);
                        unset($where[$k]);
                    }
                }
                if (count($where) > 0) {
                    $model = $model->where($where);
                }
            }
            if ($search && $search['value'] !== '' && $search['value'] !== null) {
                $model = $model->where($search['field'], 'like', '%' . $search['value'] . '%');
            }
            $count = $model->count();
            $data = $model->skip(($page - 1) * $limit)
                ->take($limit)
                ->orderBy($orderBy[0], $orderBy[1])
                ->get();
            return ['count' => $count, 'data' => $data];
        } catch (\Exception $exception) {
            return response()->json(['msg' => $exception->getMessage()]);
        }
    }
}