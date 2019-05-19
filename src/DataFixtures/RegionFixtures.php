<?php

namespace App\DataFixtures;

use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class RegionFixtures extends Fixture
{
    private static $data = [
        ['Санкт-Петербург', 4],
        ['Уфа', 2],
        ['Нижний Новгород', 10],
        ['Владимир', 3],
        ['Кострома', 5],
        ['Екатеринбург', 15],
        ['Ковров', 21],
        ['Воронеж', 1],
        ['Самара', 3],
        ['Астрахань', 4]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this::$data as $item) {
            $region = new Region();
            $region
                ->setName($item[0])
                ->setDuration($item[1]);

            $manager->persist($region);
        }

        $manager->flush();
    }
}
