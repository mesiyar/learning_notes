# 地域 （每次切换出发4次ajax请求）
* /api/network/v1/az/subnet?locale=zh-cn&_=1574774673362
```
request payload {vpcId: "5c2c5b28-b375-465b-8e70-44ac190cd4ca", az: "zoneB"}

response ：
{"result":[{
"accountId":"c60f7bf379434616b57b52cddc513944",
"az":"zoneB","cidr":"192.168.16.0/20",
"createdTime":"2019-11-25T13:57:03Z",
"description":"","enable_ipv6":null,
"ipv6Cidr":"","name":"系统预定义子网B",
"shortId":"sbn-50etsgykqrtk",
"subnetId":"c35c7d8a-5843-4921-9a8f-9a7b985bae99",
"subnetType":1,"subnetUuid":"c35c7d8a-5843-4921-9a8f-9a7b985bae99",
"tags":null,"totalIps":-1,"type":1,"updatedTime":"2019-11-25T13:57:03Z",
"usedIps":-1,"vpcId":"5c2c5b28-b375-465b-8e70-44ac190cd4ca",
"vpcShortId":"vpc-wdyj527phv62"}],"success":true}


```
* /api/rds/instance/get_price?locale=zh-cn&_=1574774673366
```
request 
{"instance":{
"engine":"MySQL","engineVersion":"5.7","cpuCount":1,
"allocatedMemoryInGB":1,"allocatedStorageInGB":5,
"azone":"zoneB","vpcId":"5c2c5b28-b375-465b-8e70-44ac190cd4ca",
"subnetId":"zoneB:d6c482f0-971f-4096-b26c-55e18147f879",
"category":"","isEnhanced":false,"diskIoType":"normal_io"
},
"number":1,"productType":"prepay","duration":1,"diskTypeStatus":"ssdDisk","loading":true}

response : {"success":true,"message":{},"result":{"price":123.8,"trafficInGB":0E-10}}

```
* /api/rds/instance/subnet/detail?locale=zh-cn&_=157477467361
```
request : {"subnetId":"c35c7d8a-5843-4921-9a8f-9a7b985bae99"}

response : {"success":true,"status":200,"result":{"name":"系统预定义子网B","subnetId":"c35c7d8a-5843-4921-9a8f-9a7b985bae99","az":"zoneB","cidr":"192.168.16.0/20","ipv6Cidr":"","vpcId":"5c2c5b28-b375-465b-8e70-44ac190cd4ca","vpcShortId":"vpc-wdyj527phv62","subnetUuid":"c35c7d8a-5843-4921-9a8f-9a7b985bae99","accountId":"c60f7bf379434616b57b52cddc513944","subnetType":1,"type":1,"createdTime":"2019-11-25T13:57:03Z","updatedTime":"2019-11-25T13:57:03Z","description":"","shortId":"sbn-50etsgykqrtk","usedIps":1,"totalIps":4094,"tags":null,"enable_ipv6":null}}

```

# 地域 可用区的变换 会直接导致配置信息的变换
## 单区切换 会发起一次 subnet 请求 
## 多区切换 会发起两次 subnet 请求 
## 多可用区系列选择只有双机可用+
