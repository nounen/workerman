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
