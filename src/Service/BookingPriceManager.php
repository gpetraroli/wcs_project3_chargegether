<?php

namespace App\Service;

class BookingPriceManager
{
    private int $fees = 1;
    private float $coefficient = 2;
    private float $electricityPrice = 0.3;


    public function calculateBookingPrice(
        \DateTimeImmutable $dateBegin,
        \DateTimeImmutable $dateEnd,
        int $vehiclePower,
        int $stationPower
    ): ?array {
        $interval = $dateEnd->diff($dateBegin);
        $intervarInHours = (int) $interval->format('%h') + (int) $interval->format('%i') / 60;
        $power = ($vehiclePower < $stationPower) ? $vehiclePower : $stationPower;
        return [
            'price' => $this->electricityPrice * $this->coefficient * $intervarInHours * $power,
            'fees' => $this->fees
        ];
    }
}
