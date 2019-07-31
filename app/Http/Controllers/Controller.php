<?php

namespace App\Http\Controllers;

use App\Http\StatusCode;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Exceptions\FromVerif;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 返回Json格式数据
     *
     * @param array $code
     * @param array $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function Json(array $code, array $data = [],$status = 200)
    {
        return StatusCode::Json($code,$data,$status);
    }

    /**
     * 自定义验证规则
     *
     * @param array $rule 验证规则
     *
     * @return array 返回验证的数据
     *
     * @throws \App\Exceptions\FromVerif 如果验证失败抛出异常
     */
    protected function formVerif($rule)
    {
        //验证提交数据
        $validator = Validator::make(request()->all(), $rule);
        // 如果验证出错返回验证错误数据的第一条
        if ($validator->fails()) {
            throw  new FromVerif($validator->errors()->first());
        }
        return $validator->validate();
    }
}
