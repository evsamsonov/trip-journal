<?php declare(strict_types=1);

namespace App\Manager;

use App\Entity\Region;
use App\Entity\Trip;
use App\Exception\BusyCourierException;
use App\Exception\DatabaseException;
use App\Exception\InvalidArgumentException;
use App\Model\TripFilter;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class TripManager implements TripManagerInterface
{
    /** @var EntityManagerInterface|EntityManager  */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritdoc
     */
    public function getTrips(TripFilter $filter): array
    {
        $queryBuilder = $this->entityManager->getRepository(Trip::class)->createQueryBuilder('t');
        if ($filter->getStartDate()) {
            $queryBuilder
                ->andWhere('t.date >= :start_date')
                ->setParameter('start_date', $filter->getStartDate());
        }

        if ($filter->getEndDate()) {
            $queryBuilder
                ->andWhere('t.date <= :end_date')
                ->setParameter('end_date', $filter->getEndDate());
        }

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @inheritdoc
     */
    public function addTrip(Trip $trip): void
    {
        if (null === $trip->getRegion() || null === $trip->getCourier()) {
            throw new InvalidArgumentException('Не задан регион поездки или курьер');
        }

        $endDate = $this->computeEndDate($trip->getStartDate(), $trip->getRegion());
        $trip->setEndDate($endDate);

        if (false === $this->isFreeCourier($trip)) {
            throw new BusyCourierException('У курьера есть поездки в этот период. Одновременно он может быть только в одной');
        }

        try {
            $this->entityManager->persist($trip);
            $this->entityManager->flush();
        } catch (\Throwable $e) {
            throw new DatabaseException('Ошибка при сохранении данных');
        }
    }

    /**
     * @inheritdoc
     */
    public function computeEndDate(\DateTime $startDate, $region): \DateTime
    {
        if (is_int($region)) {
            $region = $this->entityManager->getRepository(Region::class)->find($region);
            if (null === $region) {
                throw new InvalidArgumentException('Регион не найден');
            }
        } elseif ( ! $region instanceof Region) {
            throw new InvalidArgumentException('Некорректный тип аргумента региона');
        }

        $endDate = clone $startDate;
        $endDate->modify(sprintf('+%d days', $region->getDuration()));
        return $endDate;
    }

    /**
     * Проверить, свободен ли курьер для текущей поездки
     * @param Trip $trip
     * @return bool
     */
    private function isFreeCourier(Trip $trip): bool
    {
        $result = $this->entityManager->getRepository(Trip::class)->createQueryBuilder('t')
            ->where('t.startDate <= :end_date')
            ->andWhere('t.endDate >= :start_date')
            ->andWhere('t.courierId = :courier_id')
            ->setParameter('start_date', $trip->getStartDate())
            ->setParameter('end_date', $trip->getEndDate())
            ->setParameter('courier_id', $trip->getCourier()->getId())
            ->getQuery()
            ->setMaxResults(1)
            ->getResult();

        return count($result) === 0;
    }
}