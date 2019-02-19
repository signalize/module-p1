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

            $this->send(new Package($package));
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
        $from = $package->offsetExists('from') ? $package->offsetGet('from') : strtotime(date("d-m-Y 00:00:00"));
        $untill = $package->offsetExists('untill') ? $package->offsetGet('untill') : strtotime(date("d-m-Y 23:59:59"));

        $data = Database::collection('statistics')->find(function ($row) use ($from, $untill) {
            return ($row->datetime > $from && $row->datetime < $untill);
        });


        $plot = [];
        foreach ($data->toArray() as $row) {
            $date = date("ymdH", $row->datetime);
            if (!isset($plot[$date])) {
                $plot[$date] = 0;
            }
            $plot[$date]++;
        }
        return new Package($plot);
    }

}