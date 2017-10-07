### workerman 使用学习
* http://doc.workerman.net/

* 注意阅读手册里的每一章



### 必读章节

#### 序言: http://doc.workerman.net/315110
* 理解 workerman 是什么, 以及应用场景
* 理解 workerman 的理念


#### 原理: http://doc.workerman.net/315109
* 主进程 / Worker 子进程 / 客户端 :
* 1. 客户端与worker进程的关系
* 2. 主进程与worker子进程关系


#### 开发必读: http://doc.workerman.net/329713
1. workerman不依赖apache或者nginx
2. workerman是命令行启动的
3. 长连接必须加心跳
4. 客户端和服务端协议一定要对应才能通讯
5. 连接失败可能的原因
6. 不要使用exit die语句
7. 改代码要重启
8. 长连接应用建议用GatewayWorker框架
9. 支持更高并发


#### 特性: http://doc.workerman.net/315112
1. 纯PHP开发
2. 支持PHP多进程
3. 支持TCP、UDP
4. 支持长连接
5. 支持各种应用层协议
6. 支持高并发
7. 支持服务平滑重启
8. 支持文件更新检测及自动加载
9. 支持以指定用户运行子进程
10. 支持对象或者资源永久保持
11. 高性能
13. 支持分布式部署
14. 支持守护进程化
15. 支持多端口监听
16. 支持标准输入输出重定向


#### 环境要求: http://doc.workerman.net/315115
* 关于WorkerMan依赖的扩展

1. `pcntl` 扩展:
    * `pcntl` 扩展是 PHP 在 Linux 环境下进程控制的重要扩展.
    * **WorkerMan 用到了其进程创建、信号控制、定时器、进程状态监控等特性**。此扩展win平台不支持。

2. `posix` 扩展
    * posix 扩展使得 PHP 在 Linux 环境可以调用系统通过 POSIX 标准提供的接口。
    * **WorkerMan 主要使用了其相关的接口实现了守护进程化、用户组控制等功能**。此扩展win平台不支持。

3. `libevent` 扩展 或者 Event 扩展
    * `libevent` 扩展(或者event扩展)使得 PHP 可以使用系统 Epoll、Kqueue 等高级**事件处理机制**，能够显著提高WorkerMan在高并发连接时CPU利用率。
    * 在高并发长连接相关应用中非常重要。libevent 扩展(或者 event 扩展)不是必须的， *如果没安装，则默认使用 PHP 原生 Select 事件处理机制*。


#### 启动与停止: http://doc.workerman.net/315117
* 貌似只有在 linux 的环境下才有守护进程, 平滑重启
```
启动
以debug（调试）方式启动
php start.php start

以daemon（守护进程）方式启动
php start.php start -d

停止
php start.php stop

重启
php start.php restart

平滑重启
php start.php reload

查看状态
php start.php status

查看连接状态（需要Workerman版本>=3.5.0）
php start.php connections
```

* 平滑重启的原理 以及注意点:
    * 平滑重启实际上是让旧的业务进程逐个退出然后并逐个创建新的进程做到的

    * 为了在平滑重启时不影响客用户，这就要求进程中不要保存用户相关的状态信息，**即业务进程最好是无状态的，避免由于进程退出导致信息丢失**


#### 开发前必读: http://doc.workerman.net/315119
* 一、WorkerMan开发与普通PHP开发的不同之处:
    1. 应用层协议不同
        * 普通PHP开发一般是基于HTTP应用层协议，WebServer已经帮开发者完成了协议的解析

        * WorkerMan支持各种协议，目前内置了HTTP、WebSocket等协议。WorkerMan推荐开发者使用更简单的自定义协议通讯

    2. 请求周期差异

    3. 注意避免类和常量的重复定义

    4. 注意单例模式的连接资源的释放
        * 当数据库服务器发现某个连接在一定时间内没有活动后可能会主动关闭socket连接，这时再次使用这个数据库实例时会报错，（错误信息类似mysql gone away）。WorkerMan提供了数据库类，有断开重连的功能，开发者可以直接使用

    5. 注意不要使用exit、die出语句

* 二、需要了解的基本概念
    1. TCP传输层协议

    2. 应用层协议

    3. 短连接
        * 短连接是指通讯双方有数据交互时，就建立一个连接，数据发送完成后，则断开此连接，即每次连接只完成一项业务的发送。像 WEB 网站的 HTTP 服务一般都用短连接

        * 短连接应用程序开发可以参考基本开发流程一章

    4. 长连接
        * 长连接，指在一个连接上可以连续发送多个数据包

        * 注意：长连接应用必须加 **心跳**，否则连接可能由于长时间不活跃而被路由节点防火墙断开

        * 长连接应用程序开发可以参考Gateway/Worker开发流程

    5. 平滑重启
        * 平滑重启则不是一次性的停止所有进程，而是一个进程一个进程的停止，每停止一个进程后马上重新创建一个新的进程顶替，直到所有旧的进程都被替换为止。

        * 平滑重启WorkerMan可以使用 `php your_file.php reload` 命令，能够做到在不影响服务质量的情况下更新应用程序。

        * 注意：只有在 `on{...}` 回调中载入的文件平滑重启后才会自动更新，启动脚本中直接载入的文件或者写死的代码运行 reload 不会自动更新。

* 三、区分主进程和子进程
    * 一般来说在 `Worker::runAll();` 调用前运行的代码都是在 **主进程** 运行的

    * `onXXX` 回调运行的代码都属于 **子进程**

    * **注意**： 不要在主进程中初始化数据库、memcache、redis等连接资源，因为主进程初始化的连接可能会被子进程自动继承（尤其是使用单例的时候），所有进程都持有同一个连接，服务端通过这个连接返回的数据在多个进程上都可读，会导致数据错乱。同样的，如果任何一个进程关闭连接(例如daemon模式运行时主进程会退出导致连接关闭)，都导致所有子进程的连接都被一起关闭，并发生不可预知的错误，例如mysql gone away 错误。


#### Workerman 的目录结构: http://doc.workerman.net/315120


### Worker 类

### PHPSocketIO
* https://github.com/walkor/phpsocket.io

* phpsocket.io 做服务端 , socket.io 做客户端

* 通过事件来进行通讯: `on` 方法监听事件, `emit` 方法触发事件
