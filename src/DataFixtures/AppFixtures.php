<?php

namespace App\DataFixtures;

use App\Factory\EmployeFactory;
use App\Factory\ProjetFactory;
use App\Factory\TacheFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        EmployeFactory::createMany(10);
        ProjetFactory::createMany(5);
        TacheFactory::createMany(20);

    }
}
