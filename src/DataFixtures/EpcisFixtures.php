<?php

namespace App\DataFixtures;

use App\Entity\EPCI;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EpcisFixtures extends Fixture
{
    public const EPCI_REFERENCE = 'epci';

    // NOTE : Le token doit être unique
    public const EPCIS = [
        'SMD3' => 'test',
        'PaysDeDuras' => 'test2'
    ];


    public function load(ObjectManager $manager)
    {
        $i = 0;
        foreach (self::EPCIS as $name => $token) {
            $epci = new EPCI();
            $epci->setName($name);
            $epci->setToken($token);
            $manager->persist($epci);

            // Stockez les références pour les utiliser dans d'autres fixtures
            $this->addReference(self::EPCI_REFERENCE . $i, $epci);
            $i++;
        }

        $manager->flush();
    }
}
