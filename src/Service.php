<?php

namespace Signalize\ModuleP1;

use Signalize\Service\Base;
use Signalize\Socket\Package;

class Service extends Base
{

    public function worker()
    {
        $device = new Device("/dev/ttyUSB0", 115200);
        $device->subscribe(function (Package $data) {
            $this->send($data);
        });
    }

    public function execute(Package $package)
    {
        // TODO: Implement execute() method.
    }

}