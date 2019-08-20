import Cookies from "js-cookie";
import {fdUserInfo} from '@/api/user'

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
    fdUserInfo(fd).then((response)=>{
        window.vueApp.$notify({
            title: '好友上线通知',
            message: `你的好友${response.data.data.name}上线啦`,
            position: 'top-left'
        });
        window.vueApp.$store.state.friend.columnFriend.forEach(item=>{
            item.friend.forEach(friendItem=>{
                if (friendItem.id == response.data.data.id) {
                    //更改fd状态
                    friendItem.fd = fd;
                    return;
                }
            })
        })
    })
}

var wsk = {

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

};

export default wsk
