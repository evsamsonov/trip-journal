<?php declare(strict_types=1);

namespace App\Manager;

use App\Entity\Trip;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class TripManager
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
     * @param array $filters
     * @return Trip[]
     */
    public function getTrips(array $filters = []): array
    {
        $queryBuilder = $this->entityManager->getRepository(Trip::class)->createQueryBuilder('t');
        if (isset($filters['start_date']) && $filters['start_date'] instanceof \DateTimeInterface) {
            /** @var \DateTime $startDate */
            $startDate = $filters['start_date'];
            $queryBuilder
                ->andWhere('t.date >= :date')
                ->setParameter('date', $startDate->format('Y-m-d'))
            ;
        }

        if (isset($filters['end_date']) && $filters['end_date'] instanceof \DateTimeInterface) {
            /** @var \DateTime $startDate */
            $endDate = $filters['end_date'];
            $queryBuilder
                ->andWhere('t.date <= :date')
                ->setParameter('date', $endDate->format('Y-m-d'))
            ;
        }

        return $queryBuilder->getQuery()->getResult();
    }
}