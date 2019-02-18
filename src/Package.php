<?php

namespace Signalize\ModuleP1;

class Package extends \Signalize\Socket\Package
{
    protected $package;

    public function __construct($package)
    {
        $this->package = explode("\r\n", $package);
        parent::__construct([
            'energy.usage.low' => $this->getValue(4),
            'energy.usage.high' => $this->getValue(5),
            'energy.result.low' => $this->getValue(6),
            'energy.result.high' => $this->getValue(7),
            'gas.usage.total' => $this->getValue(33, 1),
            'datetime' => time()
        ]);
    }

    private function getValue($index, $cursor = 0)
    {
        $values = explode("(", $this->package[$index]);
        array_shift($values);

        $values = array_map(function ($value) {
            return substr($value, 0, strpos($value, ")"));
        }, $values);

        return floatval($values[$cursor]);
    }
}
