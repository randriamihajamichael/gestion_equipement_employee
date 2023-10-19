<?php

namespace App\DataFixtures;
use App\Entity\Equipments;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $equipment = new Equipments;
            $equipment->setName('iPhone X 128Gb - ' . $i);
            $equipment->setNumber('OIUOI1iPhone X 128Gb - ' . $i);
            $equipment->setCategory('(téléphone - ' . $i);
            $equipment->setDescription('descr' . $i);
            $equipment->setNumber('(T00' . $i);

            $manager->persist($equipment);
        }

        $manager->flush();
    }
}
