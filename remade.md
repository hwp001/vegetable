### 后台

##### 后台内容

- 数据库设计
  - 数据库命名： a_b_c
- 类名
  - 驼峰式命名
- 小程序端
  - wxss : a_b_c
  - js:  驼峰

##### 整体模块

- ##### 后端技术要点

  - ```
    dingo
    easy-wechat 
    vagrant
    homestead
    jwt
    ```

- 后端设计

  - 管理员
  - 权限
  - 菜单
  - 操作日志
  - 用户信息
  - 商品分类 选择 添加
  - 统计数据（附加）
  - 公众号消息设置（附加）


##### 数据库设计

- 客户表

| id   | username | name     | avatar | phone | email | times    | ip     | address  | decs | state  | created_at | updated_at |
| ---- | -------- | -------- | ------ | ----- | ----- | -------- | ------ | -------- | ---- | ------ | ---------- | ---------- |
|      | 用户名   | 真实姓名 | 头像   | 电话  | 邮箱  | 登录次数 | 登录ip | 账号地址 | 描述 | 假删除 |            |            |
|      |          |          |        |       |       |          |        |          |      |        |            |            |
|      |          |          |        |       |       |          |        |          |      |        |            |            |

​    

- 公众号表（包含客户表）

  | id   | cid    | mp_openid    | wx_openid  | unionid           | state  | created_at | updated_at |
  | ---- | ------ | ------------ | ---------- | ----------------- | ------ | ---------- | ---------- |
  |      | 客户id | 公众号openid | 微信openid | 公众号平台unionid | 假删除 |            |            |
  |      |        |              |            |                   |        |            |            |
  |      |        |              |            |                   |        |            |            |

  

- 种类表

  | id   | name     | pid    | state  | created_at | updated_at |
  | ---- | -------- | ------ | ------ | ---------- | ---------- |
  |      | 种类名称 | 父类id | 假删除 |            |            |
  |      |          |        |        |            |            |
  |      |          |        |        |            |            |

- 图片表

  | id   | imgUrl   | description | state | created_at | updated_at |      |
  | ---- | -------- | ----------- | ----- | ---------- | ---------- | ---- |
  |      | 图片路径 | 图片描述    |       |            |            |      |
  |      |          |             |       |            |            |      |
  |      |          |             |       |            |            |      |

- 评论表

  | id   | cid    | gid or oid         | star       | description | img    | state | created_at | updated_at |      |
  | ---- | ------ | ------------------ | ---------- | ----------- | ------ | ----- | ---------- | ---------- | ---- |
  |      | 用户id | 商品id 或者 订单id | 星级(评分) | 评论        | 晒照片 |       |            |            |      |
  |      |        |                    |            |             |        |       |            |            |      |
  |      |        |                    |            |             |        |       |            |            |      |

  

- 商品表（包含属性表和种类表）

  | id   | title    | description | kind_id | img_ids | price | discount | count | cavr     | state | created_up | updated_up |
  | ---- | -------- | ----------- | ------- | ------- | ----- | -------- | ----- | -------- | ----- | ---------- | ---------- |
  |      | 商品标题 | 商品描述    | 种类id  | 图片id  | 价格  | 折扣价格 | 数量  | 收藏人数 |       |            |            |
  |      |          |             |         |         |       |          |       |          |       |            |            |
  |      |          |             |         |         |       |          |       |          |       |            |            |

  

- 订单表

  | id   | cid    | cargo_id | gain_way_bool          | pay_way_bool | have_way_bool | time       | true_order   | state | created_at | updated_at |
  | ---- | ------ | -------- | ---------------------- | ------------ | ------------- | ---------- | ------------ | ----- | ---------- | ---------- |
  |      | 客户id | 收货表id | 获取方式（自取，配送） | 支付方式     | 是否预订      | 下订单时间 | 订单是否完成 |       |            |            |
  |      |        |          |                        |              |               |            |              |       |            |            |
  |      |        |          |                        |              |               |            |              |       |            |            |

  

- 收货表

  | id   | cid    | name   | phone    | address  | state | created_at | update_at |      |      |
  | ---- | ------ | ------ | -------- | -------- | ----- | ---------- | --------- | ---- | ---- |
  |      | 客户id | 收货名 | 收货号码 | 收货地址 |       |            |           |      |      |
  |      |        |        |          |          |       |            |           |      |      |
  |      |        |        |          |          |       |            |           |      |      |

  

##### 前端

- 支付页面
- 订单页面(支付，自提)
- 个人详情页面
- 后台数据接入
- 界面修改 优化



##### 微信公众号功能

- 分享接入小程序
- 消息回复
- 个性化菜单
  - 小程序
  - 商品详情
  - 个人资料
    - 个人资料
    - 订单详情
- 统计公众号访问次数（附加）
- 图文（附加）

##### 未完成

- 后面将用户表更新 弄到 中间件
- 异常处理（事务处理）



### BS草稿

##### laravel-admin

- [配置微信公众号，微信小程序](https://learnku.com/articles/40373)

##### 



##### layui

- https://learnku.com/articles/41597

layui文档

- http://layuimini.99php.cn/onepage/v2/index.html#/page/welcome-3.html

毕设后台名称

composer create-project laravel/laravel=6.0 --prefer-dist bs01



最终：暂时用laravel-admin 后期有时间再来，layui进行修改增添



homestead 可以实现暴露ip给外网或同局域网

##### 小程序和微信公众号的 openid

我来回答你这个问题：

- 同一个用户在小程序和公众号的下的两个openid肯定不一样

- 如果小程序和公众号都绑定在同一个开放平台账号下的话，用户在小程序和在公众号下的unionid是一样的

- 如果先有公众号并且积累了大量粉丝，然后才有的小程序，然后想在小程序下也能识别公众号粉丝怎么办呢？

- - 首先将公众号和小程序关联到同一个开放平台账号
  - 通过API将公众号粉丝列表全部拉一遍，同时计算这些粉丝的unionid并保存起来
  - 用户进入小程序时计算unionid，然后根据之前保存的公众号粉丝unionid的数据映射过去就好了

说句题外话，微信为什么要设计出用户对几个号的openid不一样的机制呢？想象一下如果一样会怎么样，几个大号把自己的粉丝openid一串就把整个微信的用户ID摸透了，换做你是平台建设者你能忍吗？



laraval-admin 搭建分类   https://learnku.com/articles/17510



### bs问题

##### composer

1. dingo版本可能和项目冲突，最后还是镜像的问题，换成腾讯云的镜像（阿里云还有composer自身的镜像无效）

2. **换http源，更改配置不要使用https加密连接**

   1. ```
      composer config -g secure-http false
      composer self-update
      ```



composer中国镜像：https://www.v2ex.com/t/579600

##### homestead 

内网穿透（失败 ）未解决

- 测试 ： 不是内网穿透的问题
- 预估：是homestead 端口问题

##### 编译器问题

- 路径手贱换行，导致整体路径出错，请求失败，耗时4个小时；

##### curl使用

- https://www.cnblogs.com/stj123/p/10790013.html



##### unionid

- 微信公众号测试号 获取不了unionid 
- 微信公众号获取得到unionid 但是菜单功能无效
- 没有获得用户基本信息的权限  unionid只能暂时自己想办法（手动添加）

解决办法：

- 先不用菜单功能先把 openid unionid 用户信息存储起来，
- 后面再用测试号，测试菜单功能 

### 好东西

[免费api](https://learnku.com/articles/30329)





