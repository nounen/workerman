### workerman 使用学习
* http://doc.workerman.net/

* 注意阅读手册里的每一章



### 必读章节
* 序言: http://doc.workerman.net/315110
    * 理解 workerman 是什么, 以及应用场景
    * 理解 workerman 的理念


* 原理: http://doc.workerman.net/315109
    * 主进程 / Worker 子进程 / 客户端 :
        * 1. 客户端与worker进程的关系
        * 2. 主进程与worker子进程关系
    

* 开发必读: http://doc.workerman.net/329713
    1. workerman不依赖apache或者nginx
    2. workerman是命令行启动的
    3. 长连接必须加心跳
    4. 客户端和服务端协议一定要对应才能通讯
    5. 连接失败可能的原因
    6. 不要使用exit die语句
    7. 改代码要重启
    8. 长连接应用建议用GatewayWorker框架
    9. 支持更高并发


* 特性: http://doc.workerman.net/315112
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