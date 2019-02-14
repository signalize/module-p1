<?php

namespace Signalize\ModuleP1;

use Signalize\Service\Base;

class Service extends Base
{
    public function worker()
    {
        $device = new Device("/dev/ttyUSB0", 115200);
        $device->subscribe(function (Package $data) {
            $this->send($data);
        });
    }

    public function execute(string $data)
    {
        # There are no commands defined
    }


}