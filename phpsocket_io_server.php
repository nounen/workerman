<?php

require_once 'vendor/autoload.php';

use Workerman\Worker;
use PHPSocketIO\SocketIO;

// 创建socket.io服务端，监听2021端口
$io = new SocketIO(3120);

// 当有客户端连接时打印一行文字
$io->on('connection', function ($socket) use ($io) {
    echo "new connection coming\n";

    // 定义chat message事件回调函数
    $socket->on('chat message', function ($msgFromClient) use ($io) {
        print_r($msgFromClient);
        // 触发所有客户端定义的chat message from server事件
        $io->emit('chat message from server', $msgFromClient);
    });
});

Worker::runAll();
