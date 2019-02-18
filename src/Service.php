<?php

namespace Signalize\ModuleP1;

use Signalize\Service\Base;
use Signalize\Socket\Package;

class Service extends Base
{

    public function worker()
    {
        $device = new Device("/dev/ttyUSB0");
        $device->subscribe(function (Package $package) {
            Database::store('statistics', $package);
            $this->send($package);
        });
    }

    /**
     * @param Package $package
     * @return mixed|Package
     * @throws \Exception
     */
    public function execute(Package $package)
    {
        if ($package->offsetGet('subscribe')) {
            return $this->fetch($package);
        }

        throw new \Exception('Undefined function!');
    }


    private function fetch(Package $package)
    {
        $from = $package->offsetExists('from') ? $package->offsetExists('from') : strtotime(date("d-m-Y 00:00:00"));
        $untill = $package->offsetExists('from') ? $package->offsetExists('from') : strtotime(date("d-m-Y 00:00:00") . " +1day");

        $data = Database::collection('statistics')->find(function ($row) use ($from, $untill) {
            return (
                ($row->datetime > $from) &&
                ($row->datetime < $untill)
            );
        });

        return new Package($data->toArray());
    }

}