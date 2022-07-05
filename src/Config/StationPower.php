<?php

namespace App\Config;

// TODO: ask for 11kw and 22kw icons
enum StationPower: int
{
    case kW3 = 3;
    case kW7 = 7;
    case kW18 = 11;
}
