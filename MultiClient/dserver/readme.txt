
1  compile and run (configure) 
  1.1  cd  src
  1.2 make
  1.3  ./dserver (already running redis(port 6379))

2 port 分配
  2.1   msgserver  : 6000 6001 6002 and more
  2.2  route : 7000 7001 7002 and more
  2.3  loadbalance/geteway :  8000  8001  and more 
  2.4  cache/redis :  6379

3
  ZADD key score member 
  ZRANGE page_rank 0 -1 WITHSCORES
  ZINCRBY key increment member 
  当key不存在，或member不是key的成员时，ZINCRBY key increment member等同于ZADD key score member。

  ZRANGE key start stop [WITHSCORES] 
  其中成员的位置按score值递增(从小到大)来排序

  ZREVRANGE key start stop [WITHSCORES] 
  其中成员的位置按score值递减(从大到小)来排列

  ZREM key member 
  移除有序集key中的成员member，如果member不是有序集中的成员，那么不执行任何动作

  数据存储选型及设计
  ip:port (192.168.0.1:5000)
  3.1  sadd   msgservers   ip:port
  3.1  sadd   msgservers   ip:port
  3.2 smemebers
  
  保持了每个session对应的msgserver服务器ip：port
  sessionid : (ip:port)

  zadd msgservers 

  新增加命令：

    //  loadbalance  msgservers   type  \r\n 

user@swd2:~$ telnet 127.0.0.1 8000
Trying 127.0.0.1...
Connected to 127.0.0.1.
Escape character is '^]'.
 loadbalance  msgservers 
127.0.0.1:6001

  
7
   about sessions manager 
   session生成算法参考php，保存在redis中。
    7.1  生成一个新的session id .
    7.2  redis 查找是否已经存在
    7.3  如存在则返回 7.1 
    7.4  保持session ,继续其他操作

8
   libhiredis (还是直接用redis自带官方的吧)
   or 
   credis  (没有zset的接口，及set的接口调试不正确，查看代码发现兼容的协议不一致)
6  
   参考或直接用: 
   beansdb (net , redis protocol)
   ngircd (IRC)
   jabbed2 (XMPP)
   lvs (Linux Virtual Server 负载策略)
   php (generate session)
   redis 
   fishchat
   zimg
   teamtalk（蘑菇街）
   hiredis or credis (client for redis)
   ini （https://github.com/benhoyt/inih）

LVS十种调度算法
 ①lc（Least-Connection）：最少连接
 ②wlc(Weighted Least-Connection Scheduling)：加权最少连接。


   
   


   
   


