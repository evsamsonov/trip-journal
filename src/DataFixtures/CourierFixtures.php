<?php

namespace App\DataFixtures;

use App\Entity\Courier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CourierFixtures extends Fixture
{
    public const COURIER_REFERENCE = 'courier';

    private static $data = [
        ['Соколов Ираклий Михаилович'],
        ['Кулаков Всеволод Ефимович'],
        ['Ершов Парамон Всеволодович'],
        ['Исаков Даниил Макарович'],
        ['Горшков Назарий Филиппович'],
        ['Сидоров Моисей Еремеевич'],
        ['Соколова Нонна Авдеевна'],
        ['Воронова Зара Семеновна'],
        ['Давыдова Сильва Викторовна'],
        ['Воронова Неолина Вадимовна']
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this::$data as $index => $item) {
            $courier = new Courier();
            $courier->setFullName($item[0]);

            $manager->persist($courier);
        }

        $manager->flush();
    }
}
