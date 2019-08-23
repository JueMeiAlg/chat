<?php


namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Http\StatusCode;
use App\Models\Chat\ChatMsgRecord;
use App\Repository\Chat\ChatRepository;
use Illuminate\Database\Eloquent\Builder;
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
     * 聊天相关的数据仓库
     *
     * @var ChatRepository
     */
    protected $chatRepository;

    /**
     * 注入仓库服务
     *
     * MsgRecordController constructor.
     * @param ChatRepository $chatRepository
     */
    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatRepository = $chatRepository;
    }

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
        ]);

        [$msg, $msgCount] = $this->chatRepository->msgRecord(Auth::id(), $field['friend_id']);

        return $this->Json(StatusCode::SUCCESS, ['data' => $msg, 'count' => $msgCount]);
    }
}