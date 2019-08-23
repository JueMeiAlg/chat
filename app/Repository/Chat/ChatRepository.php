<?php


namespace App\Repository\Chat;

use App\Exceptions\ApiException;
use App\Http\StatusCode;
use App\Models\Chat\ChatMsgRecord;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

/**
 * 聊天数据仓库
 *
 * Class ChatRepository
 * @package App\Repository\Chat
 */
class ChatRepository
{
    /**
     * 返回与好友间的消息记录,及统计总数
     *
     * @param int $userId 当前用户Id
     * @param int $friendId 好友Id
     * @return array
     */
    public function msgRecord(int $userId, int $friendId)
    {
        $msg = ChatMsgRecord::query()
            ->where('user_id', $userId)
            ->where('friend_id', $friendId)
            ->orWhere(function (Builder $query) use($friendId, $userId) {
                $query->where('friend_id', $userId)
                    ->where('user_id',  $friendId);
            })
            ->orderByDesc('created_at')
            ->get();
        $msgCount = ChatMsgRecord::query()
            ->where('user_id', $userId)
            ->where('friend_id', $friendId)
            ->count();
        return [$msg, $msgCount];
    }

    /**
     * 创建消息
     *
     * @param int $userId
     * @param int $friendId
     * @param string $msg
     * @throws ApiException
     */
    public function createMsg(int $userId, int $friendId, string $msg)
    {
        try{
            DB::beginTransaction();
            //插入消息,双方消息反插
            ChatMsgRecord::query()->create([
                'msg' => $msg,
                'friend_id' => $friendId,
                'user_id' => $userId,
            ]);
            ChatMsgRecord::query()->create([
                'msg' => $msg,
                'friend_id' => $userId,
                'user_id' => $friendId,
            ]);
            DB::commit();
        }catch (QueryException $exception) {
            DB::rollBack();
            throw new ApiException(StatusCode::DBError($exception->getMessage()));
        }
    }
}