<?php

namespace App\DataFixtures;

use App\Entity\Depot;
use App\Entity\Badge;
use App\Entity\EPCI;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DepotFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Créez des instances factices d'EPCI et Badge pour lier à Depot
        $epci = new EPCI();
        $epci->setName('SMD3');
        $epci->setToken('test');
        $manager->persist($epci);

        for ($i = 0; $i < 10; $i++) {
            $badge = new Badge();
            $badge->setName(substr($faker->word, 0, 10));
            $badge->setAuthorized($faker->boolean);
            $badge->setEpci($epci);
            $manager->persist($badge);

            $depot = new Depot();
            $depot->setAccessControlUid(substr($faker->uuid, 0, 10));
            $depot->setBadge($badge);
            $depot->setEpci($epci);
            $depot->setTimestamp($faker->unixTime);

            $manager->persist($depot);
        }

        $manager->flush();
    }
}
