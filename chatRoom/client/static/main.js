$(document).ready(function () {
    var username = '', password = '';
    // 打开一个 web socket
    var ws = new WebSocket("ws://127.0.0.1:8888");

    ws.onopen = function () {
        // Web Socket 已连接上，使用 send() 方法发送数据
        console.log("connect success!");
        showPrompt(username, password, ws);
    };

    ws.onmessage = function (evt) {
        console.log(evt.data);

        var msg = JSON.parse(evt.data);
        if (msg.code == 200 && msg.msg_type == 'msg') {
            $('#content').append("<p align='left'>" + msg.data.msg + "</p>");
            scrollLast();
        }else if(msg.code == 200 && msg.msg_type == 'online'){
            $('#con').append('<p fd="'+msg.data.fd+'">'+msg.data.username+'</p>')
        } else  {
            alert(msg.msg);
        }

    };

    ws.onclose = function () {
        // 关闭 websocket
        console.log("连接已关闭...");
    };

    $('#button').click(function () {
        var send = $('#tx').val();
        if (send == '') {
            return false;
        }
        ws.send(send);
        $('#tx').val('');
        $('#content').append("<p align='right'>" + send + "</p>");
        scrollLast();
    });

});

function scrollLast() {
    var ele = document.getElementById('content');
    if (ele.scrollHeight > ele.clientHeight) {
        ele.scrollTop = ele.scrollHeight;
    }

}

function setCookie(name, value) {
    document.cookie = name + "=" + escape(value)
}

function getCookie(name) {
    var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
    if (arr = document.cookie.match(reg))
        return unescape(arr[2]);
    else
        return null;
}

/**
 * 输入账号 密码
 * @param username
 * @param password
 * @param websocket
 */
function showPrompt(username, password, websocket) {
    while (username == '') {
        username = prompt("请输入用户名");
    }
    while (password == '') {
        password = prompt("请输入密码");
    }
    var msg = '{"type": 1, "data": {"username": "'+username+'", "password":"'+ password+'"}}';

    websocket.send(msg);
}