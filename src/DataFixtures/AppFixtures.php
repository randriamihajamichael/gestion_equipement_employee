<?php

namespace App\DataFixtures;
use App\Entity\Equipments;
use App\Entity\Employee;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création des employées.
        $listEmployee = [];
        for ($i = 0; $i < 10; $i++) {

            $employee = new Employee();
            $employee->setName("Employée N°" . $i);
            $manager->persist($employee);

            $listEmployee[] = $employee;
        }

        //création des équipements
        for ($i = 0; $i < 10; $i++) {
            $equipment = new Equipments;
            $equipment->setName('iPhone X 128Gb - ' . $i);
            $equipment->setNumber('OIUOI1iPhone X 128Gb - ' . $i);
            $equipment->setCategory('(téléphone - ' . $i);
            $equipment->setDescription('descr' . $i);
            $equipment->setNumber('(T00' . $i);
            $equipment->setEmployee($listEmployee[array_rand($listEmployee)]);

            $manager->persist($equipment);
        }



        $manager->flush();
    }
}
