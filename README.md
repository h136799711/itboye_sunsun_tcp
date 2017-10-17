1. envcheck.sh用于检测workerman的环境
2. 设置时区为UTC时区
3. 设置mysql wait_timeout = 1800半小时
域名地址
sunsunxiaoli.com
#关闭tcp的几种情况
1. tcp链接后如果30s以内没有设备上线请求，则会关闭tcp通道
2. 已登录设备如果接收到无法解密的数据，服务器则会关闭tcp通道
3. 业务处理如果发生异常，服务器则会关闭tcp通道
4. 如果客户端断开链接，服务器则会关闭tcp通道
5. tcp通道如果5分钟无任何数据，则关闭tcp通道

#分布式下的数据库操作问题
1. 考虑Events中调用AsyncTcpConnection 发送数据并接收结果

## -1. SERVER 统一设备服务
### 采用同一个register服务，不同设备开放不同端口
### 目前只有变频水泵接入了该服务
register服务使用端口: 1212
gateway开放外部链接端口：8290
gateway内部服务端口 4700 - 4708
### 变频水泵 all_water_pump_gateway
gateway开放外部链接端口：8286
gateway内部服务端口 4730 - 4734

## 0. transfer_station 设备信息中转服务器
register服务使用端口: 1250
gateway开放外部链接端口：8300
gateway内部服务端口 5900 - 5904

## 1. 过滤桶
register服务使用端口: 1237
gateway开放外部链接端口：8282
gateway内部服务端口 2900 - 2904

## 2. aq806
register服务使用端口: 1238
gateway开放外部链接端口：8284
gateway内部服务端口 3400 - 3404

## 3. 加热棒
register服务使用端口: 1239
gateway开放外部链接端口：8283
gateway内部服务端口 3900 - 3904

## 4. aph300
register服务使用端口: 1240
gateway开放外部链接端口：8285
gateway内部服务端口 4100 - 4104

## 5. water_pump【已停用】
register服务使用端口: 1241
gateway开放外部链接端口：8286
gateway内部服务端口 4200 - 4204

## 6. adt
register服务使用端口: 1242
gateway开放外部链接端口：8287
gateway内部服务端口 4300 - 4304

## 7. cp1000
register服务使用端口: 1243
gateway开放外部链接端口：8288
gateway内部服务端口 4110 - 4114


