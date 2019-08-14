<?php


namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\StatusCode;
use App\Models\User\UserColumn;
use App\Models\User\UserColumnRelationUser;
use App\Traits\RestFul;
use Illuminate\Support\Facades\Auth;

/**
 * 用户好友分栏
 *
 * Class ColumnController
 * @package App\Http\Controllers\User
 */
class ColumnController extends Controller
{
    /**
     * 存储栏目数据
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\FromVerif
     */
    public function store()
    {
        $field = $this->formVerif([
            'name' => 'required'
        ]);
        $field['user_id'] = Auth::id();
        $id = UserColumn::query()->create($field)->id;
        return $this->Json(StatusCode::SUCCESS, ['data'=>['id'=>$id]]);
    }

    /**
     * 修改栏目信息
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\FromVerif
     */
    public function update($id)
    {
        $field = $this->formVerif([
            'name' => 'required'
        ]);
        UserColumn::query()
            ->where('id', $id)
            ->update($field);
        return $this->Json(StatusCode::SUCCESS);
    }

    /**
     * 删除分栏信息,如果分栏下有好友信息,自动移动到其他分栏下
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //他的其他分组
        $column = UserColumn::query()
            ->where('user_id', Auth::id())
            ->whereNotIn('id', [$id])
            ->first();

        //如果没有数据 说明在删除最后一个分栏信息,最后一个不允许删除
        if (is_null($column)) {
            return $this->Json(StatusCode::ERROR, ['msg' => '最后一个分栏不允许删除']);
        }

        //查出这个分栏下关联的好友信息
        $userIds = UserColumnRelationUser::query()
            ->where('column_id', $id)
            ->pluck('user_id')->toArray();

        //删除关联信息
        UserColumnRelationUser::query()
            ->where('column_id', $id)
            ->delete();

        //重写跟新分栏建立关联关系
        foreach ($userIds as $userId) {
            UserColumnRelationUser::query()->create([
                'column_id' => $column->id,
                'user_id' => $userId,
            ]);
        }

        UserColumn::query()
            ->where('id', $id)
            ->delete();

        return $this->Json(StatusCode::SUCCESS, ['msg' => '删除成功,如果下面有好友,会自动移动到其他分组中']);
    }

    /**
     * 用的分栏和分栏下的好友信息
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $columnFriend = UserColumn::query()
            ->where('user_id', Auth::id())
            ->with('friend')
            ->get();
        return $this->Json(StatusCode::SUCCESS, ['data' => $columnFriend]);
    }
}