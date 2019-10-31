$(document).ready(function () {

    // 打开一个 web socket
    var ws = new WebSocket("ws://127.0.0.1:8888");

    ws.onopen = function()
    {
        // Web Socket 已连接上，使用 send() 方法发送数据
        console.log("connect success!")
    };

    ws.onmessage = function (evt)
    {
        var received_msg = evt.data;
        $('#content').append("<p align='left'>"+received_msg+"</p>");
        scrollLast();
    };

    ws.onclose = function()
    {
        // 关闭 websocket
        console.log("连接已关闭...");
    };

    $('#button').click(function () {
        var send = $('#tx').val();
        if(send == '') {
            return false;
        }
        ws.send(send);
        $('#tx').val('');
        $('#content').append("<p align='right'>"+send+"</p>");
        scrollLast();
    });

});

function scrollLast() {
    var ele = document.getElementById('content');
    if(ele. scrollHeight > ele.clientHeight) {
        ele.scrollTop = ele.scrollHeight;
    }

}