<?php

namespace Jiuxiaoer\Notice\lib;

interface NoticeBase
{
    public function send(array $data): bool;
}
