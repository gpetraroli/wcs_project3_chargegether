<?php

namespace App\Config;

// TODO: ask for 11kw and 22kw icons
enum StationPower: int
{
    case kW3 = 3;
    case kW7 = 7;
    case kW11 = 11;
    case kW22 = 22;
}
