<?php

/**
 * 访问 http://xx.xx.xx.xx:8090/ 看到输出
 */

$fd = stream_socket_server("tcp://0.0.0.0:8090", $errno, $errstr);

stream_set_blocking($fd, 0);      //设置成非阻塞方式

while (true) {
    $startDate = date('Y-m-d H:i:s');

    // stream_socket_accept, 会阻塞在这儿, 所谓阻塞, 就是等待事件的发生, 如果事件没有发生, 就会持续等待. 当有客户端有新请求发起时, 事件发生, 激活进程, 继续向下执行.
    $conn = stream_socket_accept($fd);

    sleep(5); // 假设有业务阻塞在这里

    $endDate = date('Y-m-d H:i:s');

    $message = "Hi {$startDate} {$endDate}";

    $len = strlen($message);

    // socket 也是文件, 所以可以使用诸如 read, write 这样的函数.
    fwrite($conn, "HTTP/1.0 200 OK\r\nContent-Length: $len\r\n\r\n$message");

    fclose($conn);
}
