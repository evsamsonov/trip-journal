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

    /**
     * Считает день окончания поездки
     * @param \DateTime $startDate
     * @param mixed $region
     * @return \DateTime
     */
    public function computeEndDate(\DateTime $startDate, $region): \DateTime;
}