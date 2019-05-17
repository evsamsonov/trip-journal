<?php

namespace App\Manager;

use App\Entity\Trip;
use App\Model\TripFilter;

interface TripManagerInterface
{
    /**
     * Получить список поездок
     * @param TripFilter $filter
     * @return Trip[]
     */
    public function getTrips(TripFilter $filter): array;

    /**
     * Добавить поездку
     * @param Trip $trip
     */
    public function addTrip(Trip $trip): void;
}