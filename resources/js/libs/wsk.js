import Cookies from "js-cookie";

var wsServer = 'ws://127.0.0.1:9502';
var websocket = new WebSocket(wsServer);

websocket.onmessage = function (evt) {
    console.log('服务器来消息啦!');
    let response = JSON.parse(evt.data);
    let methodName = response.msg;
    eval(`${methodName}(response)`);
};

websocket.onerror = function (evt, e) {
    console.log('Error occured: ' + evt.data);
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
    console.log(response)
}

var wsk = {
    /**
     * 消息发送
     *
     * @param msg
     * @param data
     */
    send(msg, data) {
        websocket.send(JSON.stringify({msg: msg, data: data}))
    },
    /**
     * 发送绑定Fd消息
     */
    sendBindFd  () {
        this.send('bindFd', {userId: Cookies.get('userId'), fd: Cookies.get('fd')})
    },
};

export default wsk
