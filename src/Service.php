<?php

namespace Signalize\Modules\P1;

use Signalize\Service\Base;

class Service extends Base
{
    protected function worker()
    {
        $device = new Device("/dev/ttyUSB0", 115200);
        $device->subscribe(function (Package $data) {
            $this->send('services/module-p1', $data);
        });
    }

    static function converter(string $data): string
    {
        return $data;
    }
}