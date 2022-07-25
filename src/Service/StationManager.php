<?php

namespace App\Service;

use Doctrine\Common\Collections\Collection;

class StationManager
{
    public function getReviewAvg(?Collection $reviews): float|null
    {
        if (!$reviews->count()) {
            return null;
        }

        $sum = 0;
        foreach ($reviews as $review) {
            $sum += $review->getRate();
        }

        return ($sum / $reviews->count());
    }
}
