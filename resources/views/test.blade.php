<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style type="text/css" media="screen">
        body {
            margin: 0;
            padding: 0;
        }

        .container .ul li {
            width: 100px;
            height: 20px;
            /*background: #eee;*/
            margin-bottom: 10px;
            list-style: none;
        }

        .container {
            border: 1px solid #000;
        }

        .container:hover {
            background: #1b1e21;
        }

        li:hover {
            background: green;
        }
    </style>
</head>
<body>
<div class="container">
    <button onclick="sendBindFd()">点击</button>
</div>
<script>
    function setCookie(name, value) {
        var Days = 30;
        var exp = new Date();
        exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
        document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
    }

    function getCookie(name) {
        var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
        if (arr = document.cookie.match(reg))
            return unescape(arr[2]);
        else
            return null;
    }

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
        setCookie('fd', response.data.fd);
    }
    function sendBindFd() {
        send('bindFd', {userId:1,fd:getCookie('fd')})
    }

    /**
     * 响应成功函数
     */
    function OK(response) {
        console.log(response)
    }

    /**
     * 消息发送
     *
     * @param msg
     * @param data
     */
    function send(msg, data) {
        websocket.send(JSON.stringify({msg: msg, data: data}))
    }

</script>
</body>
</html>