---

# Notice

[![Build Status](https://github.com/jiuxiaoer/notice/actions/workflows/test.yml/badge.svg)](https://github.com/jiuxiaoer/weather/actions)
![StyleCI build status](https://github.styleci.io/repos/460353935/shield)

消息通知集合包 钉钉 √ 微信 ....... 通知渠道  laravel 适配 

## 安装

```sh
$ composer require jiuxiaoer/notice -vvv
```

## 配置

在使用本扩展之前，你需要去钉钉群创建一个自定义机器人 获取到 Webhook 和 加签值
https://open.dingtalk.com/document/group/custom-robot-access

## 使用

```php
use Jiuxiaoer\Notice\lib\DingMsg;

$key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';
$sign = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';

$dingMsg = new DingMsg($key,$sign);
```

### 发送 txt 文本消息
```php
$dingMsg->text('普通消息测试', ['1769xxxxxxx'])
```

### 发送 link 文本消息
```php
$dingMsg->link('链接测试', '欢迎Ceo!', 'https://www.79xj.cn/', 'https://www.79xj.cn/usr/uploads/2021/03/44950235.jpg')
```

### 发送 markdown 文本消息
```php
$dingMsg->markdown('Markdown 测试', "#### Markdown 测试", ['1769xxxxxxx'])
```

### 发送 ActionCard 卡片
```php
$dingMsg->actionCard('我 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
            "![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png) \n\n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划"
            , '阅读全文', 'https://www.dingtalk.com/', '0')
```

### 发送 ActionCardAlone 卡片
```php
$dingMsg->actionCardAlone('我 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
            "![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png) \n\n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划"
            , [['title' => '6666', 'actionURL' => 'https://www.79xj.cn'], ['title' => '6666', 'actionURL' => 'https://www.79xj.cn']])
```
### 在 Laravel 中使用

在 Laravel 中使用也是同样的安装方式，配置写在 `config/services.php` 中：
```php
	.
	.
	.
	 'notice' => [
		'dingKey' => env('DING_KEY'),
		'dingSign' => env('DING_SIGON'),
    ],
```
然后在 `.env` 中配置 `dingKey dingSign` ：

```env
DING_KEY=xxxxxxxxxxxxxxxxxxxxx

DING_SIGON=xxxxxxxxxxxxxxxxxxxxx
```
可以用两种方式来获取 `Jiuxiaoer\Notice\lib\DingMsg` 实例：

#### 方法参数注入

```php
	.
	.
	.
	public function edit(DingMsg $weather) 
	{
		$response = $dingMsg->txt('测试');
	}
	.
	.
	.
```

#### 服务名访问

```php
	.
	.
	.
	public function edit() 
	{
		$response = app('dingMsg')->txt('测试');
	}
	.
	.
	.

```
## 参考
https://open.dingtalk.com/document/group/custom-robot-access
## License

MIT