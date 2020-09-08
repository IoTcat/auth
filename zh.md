# auth

Ushio用户系统

[English Version](./README.md)

## 实现方法

Ushio用户系统中存在三个概念，分别是hash, token以及mask。

每个用户拥有一个自己唯一的hash，这个hash代表着此用户所有的权限。如果hash被泄露，用户需要手动刷新hash。但这将导致此用户之前绑定的所有设备和服务自动登出。    

每个设备（比如浏览器）拥有唯一的token。设备上运行的各种服务（比如不同的网站）各自拥有自己唯一的mask。    

为了安全起见，token储存在auth.yimian.xyz下的cookie中。每次用户打开新的网站时，系统会判断并将mask自动绑定到token。此时，多个mask对应一个token。如下图

```
     token
   /   |   \
mask1 mask2 mask3
```

每次用户登录或注册时，系统所做的事情是在服务器端将token与代表用户的hash联系起来。用户登出时，服务器端的token和hash将断开连接，用户便退出来了。


## 登录逻辑

考虑到我们时长很难记住密码，因此本站登录逻辑设计为邮箱或手机号验证码登录。登陆后，系统将根据fp, ip的变化对用户的设备安全进行评估。如果系统评估结果为危险，则会要求用户进行验证，否则用户将一直处于登录状态。


## 依赖

Ushio用户系统严重依赖ushio-session，fp，ip等项目。
