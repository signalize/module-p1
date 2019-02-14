<?php

namespace Signalize\ModuleP1;

use Signalize\Service\Base;

class Service extends Base
{
    public function worker()
    {
//        $device = new Device("/dev/ttyUSB0", 115200);
//        $device->subscribe(function (Package $data) {
//            $this->send($data);
//        });
        while (true) {
            $this->send(json_encode([
                "data" => "dummy"
            ]));
            sleep(1);
        }


    }


    public function execute(string $data)
    {
        $this->send(json_encode([
            "data" => "hello"
        ]));
    }


}