import Cookies from "js-cookie";
import {chatMsgRecord} from '@/api/chat'

var wsServer = 'ws://127.0.0.1:9502';
var websocket = new WebSocket(wsServer);

websocket.onmessage = function (evt) {
    console.log('服务器来消息啦!', evt.data);
    let response = JSON.parse(evt.data);
    let methodName = response.msg;
    eval(`${methodName}(response)`);
};

websocket.onerror = function (evt, e) {
    console.log('Error occured: ' + evt.data, e);
};

/**
 * 绑定Fd
 */
function bindFd(response) {
    Cookies.set('fd', response.data.fd);
}

/**
 * 响应成功函数
 */
function OK(response) {
    //成功处理了响应OK
    console.log(response)
}

/**
 * 好友上线处理函数
 */
function friendOnline(response) {
    let fd = response.data.fd;
    window.vueApp.$notify({
        title: '好友上线通知',
        message: `你的好友${response.data.userName}上线啦`,
        position: 'top-left'
    });
    window.vueApp.$store.state.friend.columnFriend.forEach(item => {
        item.friend.forEach(friendItem => {
            if (friendItem.id == response.data.id) {
                //更改fd状态
                friendItem.fd = fd;
                return;
            }
        })
    });
    window.vueApp.$store.state.talk.currentBeinTalkFriend.forEach(item=>{
        if (item.id == response.data.id) {
            //更改fd状态
            item.fd = fd;
            return;
        }
    });
    window.vueApp.$store.state.talk.friendList.forEach(item=>{
        if (item.id == response.data.id) {
            //更改fd状态
            item.fd = fd;
            return;
        }
    });
}

/**
 * 好友发来消息处理函数
 *
 * @param response
 */
function friendMsg(response) {

    if (wsk.isExistMsgRecord(response.data.friend_id)) {
        wsk.msgJoinRecord(response.data.friend_id, response.data.msg);
    } else {
        wsk.getFriendMsgRecord(response.data.friend_id);
    }
    //当前消息是否是正在聊天的消息
    if (window.vueApp.$store.state.talk.currentBeinTalkFriend.id == response.data.friend_id) {
        //加入到当前正在聊天的vuex状态中
        window.vueApp.$store.state.talk.currentBeingTalkRecord.push({
            user_id:response.data.friend_id,
            msg:response.data.msg
        })
    }

}

var wsk = {
    /**
     * 本地是否存在和好友的消息聊天记录
     *
     * @param friendId
     */
    isExistMsgRecord(friendId) {
        for (let i = 0; i < window.vueApp.$store.state.talk.friendChatRecord.length; i++) {
            //与这个好友的聊天记录双方存在缓存中
            if (window.vueApp.$store.state.talk.friendChatRecord[i].id == friendId) {
                return true
            }
        }
        return false;
    },

    /**
     * 消息加入记录中
     *
     * @param friendId
     * @param msg
     */
    msgJoinRecord(friendId, msg) {

        for (let i = 0; i < window.vueApp.$store.state.talk.friendChatRecord.length; i++) {
            //与这个好友的聊天记录双方存在缓存中
            if (window.vueApp.$store.state.talk.friendChatRecord[i].id == friendId) {
                window.vueApp.$store.state.talk.friendChatRecord[i].record.push({
                    user_id: window.vueApp.$store.state.user.userId,
                    friend_id: friendId,
                    msg: msg
                });
                return
            }
        }

    },

    /**
     * 获得好友的聊天记录
     *
     * @param friendId
     */
    getFriendMsgRecord(friendId) {
        chatMsgRecord(friendId).then((apiRes) => {
            window.vueApp.$store.state.talk.friendChatRecord.push({
                id: friendId,
                record: apiRes.data.data
            });
        })
    },

    /**
     * 消息发送
     *
     * @param msg
     * @param data
     */
    send(msg, data) {
        if (websocket.readyState === 1) {
            let message = {
                msg: msg,
                data: data
            };
            message = JSON.stringify(message);
            console.log(`发送:${msg},类型消息`, message);
            websocket.send(message);
        } else {
            //do something
        }
    },

    /**
     * 发送绑定Fd消息
     */
    sendBindFd() {
        this.send('bindFd', {userId: Cookies.get('userId'), fd: Cookies.get('fd')})
    },
    /**
     * 发送好友消息
     *
     * @param friend
     * @param msg
     */
    sendMsg(friend,msg) {
        this.send('friendMsg', {
            userId:window.vueApp.$store.state.user.userId,
            friendId:friend,
            msg:msg
        });

        window.vueApp.$store.state.talk.currentBeingTalkRecord.push({
            user_id:window.vueApp.$store.state.user.userId,
            msg:msg
        })
    }
};

export default wsk
