<?php


namespace App\Exceptions;

use Exception;

/**
 * api 异常处理
 *
 * Class ApiException
 * @package App\Exceptions
 */
class ApiException extends Exception
{
    private $throwInfo;

    public function __construct(array $throwInfo)
    {
        $this->throwInfo = $throwInfo;
    }

    /**
     * 直接响应
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json($this->throwInfo);
    }
}