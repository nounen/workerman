<?php

use Workerman\Worker;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * http://doc.workerman.net/315113
 * 
 * 实例一、使用HTTP协议对外提供Web服务
 *
 * 运行命令 php http_test.php start 
 *
 * 访问: 假设服务端ip为127.0.0.1, 在浏览器中访问url http://127.0.0.1:2345
 *
 **/

// 创建一个Worker监听2345端口，使用http协议通讯
$http_worker = new Worker("http://0.0.0.0:2345");

// 启动4个进程对外提供服务
$http_worker->count = 4;

// 接收到浏览器发送的数据时回复hello world给浏览器
$http_worker->onMessage = function($connection, $data)
{
    // 向浏览器发送hello world
    $connection->send('hello world');
};

// 运行worker
Worker::runAll();
