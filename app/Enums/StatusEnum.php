<?php

namespace App\Enums;

enum StatusEnum:int
{
    case DEACTIVE = 0;
    case ACTIVE = 1;

    public function toString()
    {
        return match ($this){
            self::DEACTIVE=>"Deactive",
            self::ACTIVE=>"Active",

        };
    }
}
