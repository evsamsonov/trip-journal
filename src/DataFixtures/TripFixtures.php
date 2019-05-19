<?php

namespace App\DataFixtures;

use App\Entity\Courier;
use App\Entity\Region;
use App\Entity\Trip;
use App\Exception\BusyCourierException;
use App\Manager\TripManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TripFixtures extends Fixture
{
    private const QUANTITY = 1000;
    private const START_DATE = '2015-06-01';

    /** @var TripManagerInterface */
    private $tripManager;

    public function __construct(TripManagerInterface $tripManager)
    {
        $this->tripManager = $tripManager;
    }

    /**
     * @inheritdoc
     */
    public function getDependencies(): array
    {
        return [
            CourierFixtures::class,
            RegionFixtures::class,
        ];
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $couriers = $manager->getRepository(Courier::class)->findAll();
        $regions = $manager->getRepository(Region::class)->findAll();

        $i = 0;
        while($i < self::QUANTITY) {
            $randomCourier = $couriers[array_rand($couriers)];
            $randomRegion = $regions[array_rand($regions)];
            $randomDate = $this->getRandomDateInRange(new \DateTime(self::START_DATE), new \DateTime('now'));

            $trip = new Trip();
            $trip
                ->setCourier($randomCourier)
                ->setRegion($randomRegion)
                ->setStartDate($randomDate);

            try {
                $this->tripManager->addTrip($trip);
            } catch (BusyCourierException $e) {
                continue;
            }

            $i++;
        }
    }

    /**
     * Генерирует случайную дату в промежутке
     * @param \DateTime $start
     * @param \DateTime $end
     * @return \DateTime
     * @throws \Exception
     */
    private function getRandomDateInRange(\DateTime $start, \DateTime $end): \DateTime
    {
        $randomTimestamp = random_int($start->getTimestamp(), $end->getTimestamp());
        $randomDate = new \DateTime();
        $randomDate->setTimestamp($randomTimestamp);

        return $randomDate;
    }
}
