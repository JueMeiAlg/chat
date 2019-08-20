import Cookies from "js-cookie";

var wsServer = 'ws://127.0.0.1:9502';
var websocket = new WebSocket(wsServer);

websocket.onmessage = function (evt) {
    console.log('服务器来消息啦!', evt.data);
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
        if (websocket.readyState === 1) {
            console.log(`发送:${msg},类型消息`, JSON.stringify({msg: msg, data: data}));
            websocket.send(JSON.stringify({msg: msg, data: data}))
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
