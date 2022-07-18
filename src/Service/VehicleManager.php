<?php

namespace App\Service;

use Doctrine\Common\Collections\Collection;
use phpDocumentor\Reflection\Types\Void_;
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

    public function removeSelectedVehicle(int $id): void
    {
        if ($this->getSelectedVehicle() === $id) {
            $session = $this->requestStack->getSession();
            $session->remove('selectedVehicle');
        }
    }

    public function selectDefaultVehicle(Collection $vehicles): void
    {
        if (!$vehicles->isEmpty() && !$this->getSelectedVehicle()) {
            $this->setSelectedVehicle($vehicles->first()->getId());
        }
    }
}
