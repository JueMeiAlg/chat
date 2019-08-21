import axios from "@/libs/axios";

/**
 * 好友消息
 *
 * @returns {ClientRequest | ClientHttp2Stream | * | never | Promise<AxiosResponse<T>> | Promise<T>}
 */
export const chatMsgRecord = (friendId) => {
    return axios.request({
        url: 'chat/msg?friend_id='+friendId,
        method: 'get'
    })
};
