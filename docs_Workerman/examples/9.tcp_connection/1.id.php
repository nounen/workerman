<?php

use Workerman\Worker;

require_once '../../../vendor/autoload.php';

$worker = new Worker('tcp://0.0.0.0:8484');

$worker->onConnect = function($connection) {
    var_dump($connection->id);
};

// 运行worker
Worker::runAll();

// 连接: telnet 127.0.0.1 8484
