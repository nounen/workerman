<?php

function daemonize()
{
    $pid = pcntl_fork();

//    echo "fork(1) {$pid}", PHP_EOL;

    if ($pid == -1) {
        die("fork(1) failed!\n");
    } elseif ($pid > 0) {
        //让由用户启动的进程退出
        exit(0);
    }

    echo "fork(1) {$pid}", PHP_EOL;

    //建立一个有别于终端的新session以脱离终端
    posix_setsid();

    $pid = pcntl_fork();

//    echo "fork(2) {$pid}", PHP_EOL;

    if ($pid == -1) {
        die("fork(2) failed!\n");
    } elseif ($pid > 0) {
        //父进程退出, 剩下子进程成为最终的独立进程
        exit(0);
    }

    echo "fork(2) {$pid}", PHP_EOL;
}

daemonize();

// 假设业务执行了五秒
sleep(5); // ps -ef | grep php. 五秒后看不到该进程. ppid 是 1