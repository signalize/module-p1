<?php

namespace Signalize\ModuleP1;

class Device extends \Signalize\Hardware\Serial
{
    /**
     * @param string $chuck
     * @param string $buffer
     * @return Package|bool
     */
    public function process(string $chuck, string $buffer)
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