<?php

use GuzzleHttp\Client;
use Jiuxiaoer\Notice\lib\DingMsg;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class DingMsgTest extends TestCase
{
    public function testSendText()
    {
        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');
        $client = \Mockery::mock(Client::class);
        $client->allows()->post('https://oapi.dingtalk.com/robot/send?access_token=', [
            'headers' => [
                'Content-Type' => 'application/json;charset=utf-8',
            ],
            'json' => [
                'msgtype' => 'text',
                'text' => [
                    'content' => '普通消息测试',
                ],
                'at' => [
                    'atMobiles' => ['1769xxxxxxx'],
                    'isAtAll' => false,
                ],
            ],
        ])->andReturn($response);
        $D = \Mockery::mock(DingMsg::class, ['mock-key', 'mock-sign'])->makePartial();
        $D->allows()->getHttpClient()->andReturn($client);

        // 然后调用 `text` 方法，并断言返回值为模拟的返回值。
        $this->assertSame(true, $D->text('普通消息测试', ['1769xxxxxxx']));
    }

    public function testSendLink()
    {
        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');
        $client = \Mockery::mock(Client::class);
        $client->allows()->post('https://oapi.dingtalk.com/robot/send?access_token=', [
            'headers' => [
                'Content-Type' => 'application/json;charset=utf-8',
            ],
            'json' => [
                'msgtype' => 'link',
                'link' => [
                    'title' => '链接测试',
                    'text' => '欢迎Ceo!',
                    'messageUrl' => 'https://www.79xj.cn/',
                    'picUrl' => 'https://www.79xj.cn/usr/uploads/2021/03/44950235.jpg',
                ],
            ],
        ])->andReturn($response);
        $D = \Mockery::mock(DingMsg::class, ['mock-key', 'mock-sign'])->makePartial();
        $D->allows()->getHttpClient()->andReturn($client);
        $this->assertSame(true, $D->link('链接测试', '欢迎Ceo!', 'https://www.79xj.cn/', 'https://www.79xj.cn/usr/uploads/2021/03/44950235.jpg'));
    }

    public function testSendMarkdown()
    {
        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');
        $client = \Mockery::mock(Client::class);
        $client->allows()->post('https://oapi.dingtalk.com/robot/send?access_token=', [
            'headers' => [
                'Content-Type' => 'application/json;charset=utf-8',
            ],
            'json' => [
                'msgtype' => 'markdown',
                'markdown' => [
                    'title' => 'Markdown 测试',
                    'text' => '#### Markdown 测试',
                ],
                'at' => [
                    'atMobiles' => ['1769xxxxxxx'],
                    'isAtAll' => false,
                ],
            ],
        ])->andReturn($response);
        $D = \Mockery::mock(DingMsg::class, ['mock-key', 'mock-sign'])->makePartial();
        $D->allows()->getHttpClient()->andReturn($client);
        $this->assertSame(true, $D->markdown('Markdown 测试', '#### Markdown 测试', ['1769xxxxxxx']));
    }

    public function testActionCard()
    {
        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');
        $client = \Mockery::mock(Client::class);
        $client->allows()->post('https://oapi.dingtalk.com/robot/send?access_token=', [
            'headers' => [
                'Content-Type' => 'application/json;charset=utf-8',
            ],
            'json' => [
                'msgtype' => 'actionCard',
                'actionCard' => [
                    'title' => '我 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
                    'text' => "![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png) \n\n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划",
                    'btnOrientation' => '0',
                    'singleTitle' => '阅读全文',
                    'singleURL' => 'https://www.dingtalk.com/',
                ],
            ],
        ])->andReturn($response);
        $D = \Mockery::mock(DingMsg::class, ['mock-key', 'mock-sign'])->makePartial();
        $D->allows()->getHttpClient()->andReturn($client);
        $this->assertSame(true, $D->actionCard('我 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
            "![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png) \n\n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划", '阅读全文', 'https://www.dingtalk.com/', '0'));
    }

    public function testActionCardAlone()
    {
        $response = new Response(200, [], '{"errcode":0,"errmsg":"ok"}');
        $client = \Mockery::mock(Client::class);
        $client->allows()->post('https://oapi.dingtalk.com/robot/send?access_token=', [
            'headers' => [
                'Content-Type' => 'application/json;charset=utf-8',
            ],
            'json' => [
                'msgtype' => 'actionCard',
                'actionCard' => [
                    'title' => '我 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
                    'text' => "![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png) \n\n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划",
                    'btnOrientation' => '0',
                    'btns' => [['title' => '6666', 'actionURL' => 'https://www.79xj.cn'], ['title' => '6666', 'actionURL' => 'https://www.79xj.cn']],
                ],
            ],
        ])->andReturn($response);
        $D = \Mockery::mock(DingMsg::class, ['mock-key', 'mock-sign'])->makePartial();
        $D->allows()->getHttpClient()->andReturn($client);
        $this->assertSame(true, $D->actionCardAlone('我 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身',
            "![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png) \n\n #### 乔布斯 20 年前想打造的苹果咖啡厅 \n\n Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划", [['title' => '6666', 'actionURL' => 'https://www.79xj.cn'], ['title' => '6666', 'actionURL' => 'https://www.79xj.cn']]));
    }
}
