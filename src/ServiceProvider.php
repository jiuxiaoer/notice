<?php

namespace Jiuxiaoer\Notice;

use Jiuxiaoer\Notice\lib\DingMsg;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(DingMsg::class, function () {
            return new DingMsg(config('services.notice.dingKey', config('services.notice.dingSign')));
        });

        $this->app->alias(DingMsg::class, 'dingMsg');
    }

    public function provides()
    {
        return [DingMsg::class, 'dingMsg'];
    }
}
