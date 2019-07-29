<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
聊天界面
<button onclick="send()">发送消息</button>
<script>
    var wsServer = 'ws://127.0.0.1:9502';
    var websocket = new WebSocket(wsServer);

    websocket.onopen = function (evt) {
        websocket.send('123');
        console.log("Connected to WebSocket server.");
    };

    websocket.onclose = function (evt) {
        console.log("Disconnected");
    };

    websocket.onmessage = function (evt) {
        console.log('Retrieved data from server: ' + evt.data);
    };

    websocket.onerror = function (evt, e) {
        console.log('Error occured: ' + evt.data);
    };

    function send() {
        websocket.send('123')
    }
</script>
</body>
</html>