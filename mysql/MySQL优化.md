# MySql 优化
## 1. 概述 
### 1.1 为什么要进行MySql 优化
.一个应用的瓶颈往往在数据库的处理速度上
.随着应用的使用，数据库数据逐渐增多，数据库处理压力则见增大
.关系型数据库数据都放在磁盘上，读写速度较慢（与内存的数据库相比）
### 1.2 如何优化
.表字段的设计阶段,应当选用最有的存储和计算
.数据库自身提供的优化功能,如索引 explain 工具
.横向扩展,主从复制,读写分离,负载均衡和高可用
.典型的SQL语句的优化
##2 字段设计
###2.1 典型方案
.对精度有要求的 一般使用decimal 类型 或者把小数转换成整数
.能用整数表示的字符串尽量使用整数表示 如 ip INET_ATON("192.168.1.1")  INET_NTOA(3232235777)
.字段尽可能都使用 not null (null数值计算逻辑比较复杂)
.char 和varchar 的选择 如果事先设计字段的长度是固定的 使用 char 其他使用 varchar 
char 和 varchar的区别在于对char而言 如果长度超过预设的长度 那么超出长度的内容将被截取 
如果存入的长度比预设的短 那么占用的空间不变 varchar则是使用多少就是多少 由于长度固定所以在效率上
char比varchar高
.一张表的字段数不要太多,字段注释一定要注明,字段命名做到见名知意,可以预留扩展字段以作备用
### 2.2 范式
.第一范式 原子性(关系型数据库有列的概念,默认就符合)
.第二范式 消除对主键的部分依赖(使用一个与业务无关的字段作为主键,如innodb引擎的自增列)
.第三范式 消除对主键的传递依赖 高内聚 如商品表 可以分成主要信息和详细信息两张表
## 3 存储引擎的选择(innodb,myISAM)
* 功能差异 innodb支持事务处理 行级锁 外键
* 存储差异 
  1.存储方式 innodb数据和索引都在一起,myISAM的数据 索引都是分开存储的
  2.碎片 myISAM 删除数据是会产生随便,需要定期手动清理 命令为:optimize table tablename.但是innodb不会产生
* 选择依据 : 读多写少使用myISAM 如(新闻,博客网站); 读多写也多使用innodb (支持事务和外键,保证数据的一致性,完整性;并发能力强(行锁))
## 4 索引
### 4.1 什么是索引
从数据中提取具有标识性的关键字,并且有对应数据的关系
### 4.2 索引类型
* 主键索引(primary key) 要求关键字唯一且不能为null
* 普通索引(normal key) 符合索引仅按照第一字段有序
* 唯一索引(unique key) 要求关键字唯一
* 全文索引(fulltext key) 该索引不支持中文
### 4.3 索引的管理语法
* 查看索引  show create table xxx; desc xxx
* 建立索引 1 创建表时指定; 2.alter table xxx add key/ unique key/fulltext key key_name 
* 删除索引 alter table xxx  drop key xxx (如果删除的是主键,并且主键自增 需要先取消自增 再删除)
### 4.4 执行计划 explain
分析 sql 是否用到了索引 用到了哪些索引
### 4.5 索引的使用场景
* where: 如果查找的字段都建立了索引 则会索引覆盖
* order by: 如果排序字段建立了索引,而且索引又是有序排列的,则会直接根据索引拿出数据即可,与读取所有的结果出来再排序相比效率高得多
* join: 如果join 的字段建立了索引,那么会变得高效
* 什么是索引覆盖:直接对索引进行查找,而不用去读取数据
### 4.6 即使建立了索引但是也唯一会用到的情况
* where i+1= ? 若是对字段进行函数操作 则不会使用到索引 正确写发应为 where i= 1+?
* like  like '%keyword%' 不会使用索引, like "keyword%" 会使用到索引
* or 只有两边都建立了索引才会使用 否则不会用到
* !=或者<>,可能导致不走索引
### 4.7 索引的存储结构
* btree:搜索多叉树,节点内关键字有序排列,关键字之间有个指针
* b+tree:由btree升级而来,数据和关键字存储在一起,省去了关键之到数据的映射找数据的时间
## 5 查询缓存
* 查询缓存:将selct查询的结果缓存起来,key为sql语句,value为查询结果(如果sql功能一样但是sql语句有改动都会导致key的不匹配)
* 开启方式:query_cache_type (0 不开启;1 开启,默认缓存每条select,如需针对某个sql不缓存 则:select sql_no_cache xxx;2 默认都不缓存通过 select sql_cache 制定缓存哪一条)
* 缓存大小设置:query_cache_size
* 重置缓存:reset query cache
* 缓存失效: 对表的结构进行改动会导致缓存失效
## 6 分区
概念:默认情况下 一张表的数据都是存储在一组存储结构中的,但是当数据量比较大时需要将数据分到多个存储文件中,保证单个文件的处理效率
* 分区逻辑:hash分区、key分区、range、list
* 分区管理:创建分区(create table xxx partition by key(xxx) partitions 10;alter table xxx add partition ? )
* 分区字段应选择常用的检索字段,否则意义不大
## 7 水平分区和垂直分区
*水平分区  所有分区的表结构都相同 ,每张表都保证了唯一性
*垂直分区  分割字段到多张表,这些表的记录都是一一对应的
## 8 集群
* 主从复制

mysql的主从复制，是用来建立一个和主数据库完全一样的数据库环境，称为从数据库，主数据库一般是实时的业务数据操作，从数据库常用的读取为主。

优点主要有

1，可以作为备用数据库进行操作，当主数据库出现故障之后，从数据库可以替代主数据库继续工作，不影响业务流程

2，读写分离，将读和写应用在不同的数据库与服务器上。一般读写的数据库环境配置为，一个写入的数据库，一个或多个读的数据库，各个数据库分别位于不同的服务器上，充分利用服务器性能和数据库性能；当然，其中会涉及到如何保证读写数据库的数据一致，这个就可以利用主从复制技术来完成。

3，吞吐量较大，业务的查询较多，并发与负载较大。

```sql
1,首先在主机上赋予丛机的权限，如果有多台从机的话，就赋予多次：
GRANT REPLICATION SLAVE ON *.* TO slave@'xx' IDENTIFIED BY 'xxx';

2,然后就需要设置主机数据库的my.cnf,设置主机标识的service-id,确保可写的二进制log_bin文件，具体如下：
server_id=1#主机的标识
log-bin=mysql-bin.log#确保可写入的日志文件
binlog_format=mixed#二进制日志的格式，

binlog-do-db=master#允许主从复制数据库
binlog-ignore-db=mysql#不允许主从复制的数据库
~~~~~~~~~~~~~~~~~~~~重新启动mysql服务

3，配置丛机的配置，同样也是在my.cnf的配置文件中，注意service_id不可重复：
server_id=2#主机的标识
log-bin=mysql-bin.log#确保可写入的日志文件
binlog_format=mixed#二进制日志的格式，
replicate_wild_do_table=oldboy.%
replicate_wild_ignore_table=mysql.%

4，给主机的（1）mysql  锁表，（2）查询master的状态，并（3）解锁：

(1)flush tables with read lock;
(2)show master status;（是查看当前bin-log日志的位置点）
(3)unlock tables;
5,在从库上链接主数据库，链接数据master_host='是主机的ip' 依次在数据上执行：
stop slave;

change master to master_host='119.27.169.173',master_user='slave',master_password='1234',master_log_file='mysql-bin.000006',master_log_pos=245;

start slave;

6,最后查看slave的状态：show slave status;
当Slave_IO_Running和Slave_SQL_Running线程都为yes是主从复制配置成功！

```



 

