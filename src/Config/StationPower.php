<?php

namespace App\Config;

enum StationPower: int
{
    // TODO: keep 3, 7, 11, 22
    case kW3 = 3;
    case kW7 = 7;
    case kW11 = 11;
}
