<?php

use Workerman\Worker;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * http://doc.workerman.net/315113
 * 
 * 实例三、直接使用TCP传输数据
 *
 * 运行命令 php tcp_test.php start 
 *
 **/

/**
* 服务端
*/

// 创建一个Worker监听2347端口，不使用任何应用层协议
$tcp_worker = new Worker("tcp://0.0.0.0:2347");

// 启动4个进程对外提供服务
$tcp_worker->count = 4;

// 当客户端发来数据时
$tcp_worker->onMessage = function($connection, $data) {
    // 向客户端发送hello $data
    $connection->send('hello ' . $data);
};

// 运行worker
Worker::runAll();

/*
* 客户端
* win10 开启 telnet https://kencenerelli.wordpress.com/2017/07/16/enabling-telnet-client-in-windows-10/
*
* 在控制台运行 telnet 127.0.0.1 2347
*/