<?php

namespace Jiuxiaoer\Notice\lib;

use GuzzleHttp\Client;
use Jiuxiaoer\Notice\Exceptions\HttpException;

class DingMsg implements NoticeBase
{
    protected $dingUrl;
    protected $key;
    protected $sign;
    protected $guzzleOptions = [];

    /**
     * @param $client
     */
    public function __construct(string $key, string $sign)
    {
        $this->key = $key;
        $this->dingUrl = 'https://oapi.dingtalk.com/robot/send?access_token=';
        $this->sign = $sign;
    }

    public function getHttpClient(): Client
    {
        return new Client($this->guzzleOptions);
    }

    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }

    protected function getWebhookUrl(): string
    {
        // 获取微秒数时间戳
        $Temptime = explode(' ', microtime());
        // 转换成毫秒数时间戳
        $msectime = (float) sprintf('%.0f', (floatval($Temptime[0]) + floatval($Temptime[1])) * 1000);
        // 拼装成待加密字符串
        // 格式：毫秒数+"\n"+密钥
        $stringToSign = $msectime."\n".$this->sign;
        // 进行加密操作 并输出二进制数据
        $sign = hash_hmac('sha256', $stringToSign, $this->sign, true);
        // 加密后进行base64编码 以及url编码
        $sign = urlencode(base64_encode($sign));

        return $this->dingUrl.$this->key .= '&timestamp='.$msectime .= '&sign='.$sign;
    }

    /**
     * @throws HttpException
     */
    public function text(string $content, array $atMobiles = [], bool $isAtAll = false): bool
    {
        $data = [
            'msgtype' => 'text',
            'text' => [
                'content' => $content,
            ],
            'at' => [
                'atMobiles' => $atMobiles,
                'isAtAll' => $isAtAll,
            ],
        ];

        return $this->send($data);
    }

    /**
     * @throws HttpException
     */
    public function link(string $title, string $text, string $messageUrl, string $picUrl = ''): bool
    {
        $data = [
            'msgtype' => 'link',
            'link' => [
                'title' => $title,
                'text' => $text,
                'messageUrl' => $messageUrl,
                'picUrl' => $picUrl,
            ],
        ];

        return $this->send($data);
    }

    /**
     * @throws HttpException
     */
    public function markdown(string $title, string $text, array $atMobiles = [], bool $isAtAll = false): bool
    {
        $data = [
            'msgtype' => 'markdown',
            'markdown' => [
                'title' => $title,
                'text' => $text,
            ],
            'at' => [
                'atMobiles' => $atMobiles,
                'isAtAll' => $isAtAll,
            ],
        ];

        return $this->send($data);
    }

    /**
     * @throws HttpException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function actionCard(string $title, string $text, string $singleTitle, string $singleURL, string $btnOrientation = '0'): bool
    {
        $data = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $text,
                'btnOrientation' => $btnOrientation,
                'singleTitle' => $singleTitle,
                'singleURL' => $singleURL,
            ],
        ];

        return $this->send($data);
    }

    /**
     * @param string $singleTitle
     * @param string $singleURL
     *
     * @throws HttpException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function actionCardAlone(string $title, string $text, array $btns, string $btnOrientation = '0'): bool
    {
        $data = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $text,
                'btnOrientation' => $btnOrientation,
                'btns' => $btns,
            ],
        ];

        return $this->send($data);
    }

    /**
     * @throws HttpException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(array $data): bool
    {
        $query = array_filter([
            'headers' => [
                'Content-Type' => 'application/json;charset=utf-8',
            ],
            'json' => $data,
        ]);
        try {
            $response = $this->getHttpClient()->post('mock-key' == $this->key ? $this->dingUrl : $this->getWebhookUrl(),
                $query)->getBody()->getContents();
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
        $response = \json_decode($response, true);

        return isset($response['errmsg']) && 'ok' == $response['errmsg'];
    }
}
