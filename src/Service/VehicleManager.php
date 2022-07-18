<?php

namespace App\Service;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\RequestStack;

class VehicleManager
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function setSelectedVehicle(int $id): void
    {
        $session = $this->requestStack->getSession();

        $session->set('selectedVehicle', $id);
    }

    public function getSelectedVehicle(): ?int
    {
        $session = $this->requestStack->getSession();

        return $session->get('selectedVehicle');
    }
}
