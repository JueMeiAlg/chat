<?php


namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\StatusCode;
use App\Models\Chat\ChatMsgRecord;
use Illuminate\Support\Facades\Auth;

/**
 * 消息记录控制器
 *
 * Class MsgRecordController
 * @package App\Http\Controllers\Chat
 */
class MsgRecordController extends Controller
{
    /**
     * 好友消息列表
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\FromVerif
     */
    public function index()
    {
        $field = $this->formVerif([
            'friend_id' => 'required',
//            'page' => 'required',
//            'limit' => 'required',
        ]);
        $msg = ChatMsgRecord::query()
            ->where('user_id',Auth::id() )
            ->where('friend_id', $field['friend_id'])
            ->orWhere(function ($query) use($field) {
                $query->where('friend_id', Auth::id())
                    ->where('user_id',  $field['friend_id']);
            })
            ->orderByDesc('created_at')
//            ->skip(($field['page'] - 1) * $field['limit'])
//            ->take($field['limit'])
            ->get();
        $msgCount = ChatMsgRecord::query()
            ->where('user_id', Auth::id())
            ->where('friend_id', $field['friend_id'])
            ->count();
        return $this->Json(StatusCode::SUCCESS, ['data' => $msg, 'count' => $msgCount]);
    }
}