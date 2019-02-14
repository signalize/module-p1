<?php

namespace Signalize\ModuleP1;

class Device extends \Signalize\Hardware\Serial
{
    /**
     * @param string $chuck
     * @param string $buffer
     * @return \Signalize\Hardware\Package
     */
    public function process(string $chuck, string $buffer): \Signalize\Hardware\Package
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