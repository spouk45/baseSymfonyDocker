<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Depot;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DepotsFixtures extends Fixture implements DependentFixtureInterface
{

    public const DAYS_RANGE = 14;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // On part sur une moyenne de max 4 dépots par jours et par badges
        $quantity = BadgesFixtures::BADGE_QUANTITY  * rand(0, 4 * $this::DAYS_RANGE);

        for ($i = 0; $i < count(EpcisFixtures::EPCIS); $i++) {
            for ($j = 0; $j < $quantity; $j++) {
                $depot = new Depot();
                $depot->setAccessControlUid(substr($faker->uuid, 0, 10));
                $depot->setBadge($this->getReference(BadgesFixtures::BADGE_REFERENCE . rand(0, BadgesFixtures::BADGE_QUANTITY - 1)));
                $depot->setEpci($this->getReference(EpcisFixtures::EPCI_REFERENCE . $i));
                $dateTime = $faker->dateTimeBetween('-' . self::DAYS_RANGE . ' days', 'now');
                $depot->setTimestamp($dateTime->getTimestamp());
                $manager->persist($depot);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            BadgesFixtures::class,
        ];
    }
}
