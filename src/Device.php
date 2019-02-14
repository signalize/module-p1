<?php

namespace Signalize\ModuleP1;

class Device extends \Signalize\Hardware\Serial
{
    public function process($chuck, $buffer): Package
    {
        if (substr($buffer, 0, 1) === '/') {
            if (substr($chuck, 0, 1) === '!') {
                return new Package($buffer);
            }
            return true;
        }
        return false;
    }
}