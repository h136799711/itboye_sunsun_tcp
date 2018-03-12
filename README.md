# itboye/sunsun_tcp   

[![Latest Stable Version](https://poser.pugx.org/itboye/sunsun_tcp/v/stable)](https://packagist.org/packages/itboye/sunsun_tcp)
[![Total Downloads](https://poser.pugx.org/itboye/sunsun_tcp/downloads)](https://packagist.org/packages/itboye/sunsun_tcp)
[![Monthly Downloads](https://poser.pugx.org/itboye/sunsun_tcp/d/monthly)](https://packagist.org/packages/itboye/sunsun_tcp)
[![Daily Downloads](https://poser.pugx.org/itboye/sunsun_tcp/d/daily)](https://packagist.org/packages/itboye/sunsun_tcp)
[![License](https://poser.pugx.org/itboye/sunsun_tcp/license)](https://packagist.org/packages/itboye/sunsun_tcp)
# TODO

1. 实现代理服务器，硬件与代理服务器通信

1. envcheck.sh用于检测workerman的环境
2. 设置时区为UTC时区
3. 设置mysql wait_timeout = 1800半小时
域名地址
sunsunxiaoli.com
# 关闭tcp的几种情况
1. tcp链接后如果30s以内没有设备上线请求，则会关闭tcp通道
2. 已登录设备如果接收到无法解密的数据，服务器则会关闭tcp通道
3. 业务处理如果发生异常，服务器则会关闭tcp通道
4. 如果客户端断开链接，服务器则会关闭tcp通道
5. tcp通道如果5分钟无任何数据，则关闭tcp通道

# 分布式下的数据库操作问题
1. 考虑Events中调用AsyncTcpConnection 发送数据并接收结果
最大端口 1245
8290
