<?php 

namespace App\DataFixtures;

use App\Entity\Badge;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BadgesFixtures extends Fixture implements DependentFixtureInterface
{
    public const BADGE_REFERENCE = 'badge';
    public const BADGE_QUANTITY = 50;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < self::BADGE_QUANTITY; $i++) {
            $badge = new Badge();
            $badge->setEpci($this->getReference(EpcisFixtures::EPCI_REFERENCE . rand(0, count(EpcisFixtures::EPCIS) - 1)));
            $badge->setName(substr($faker->word, 0, 10));
            $badge->setAuthorized($faker->boolean);
            $manager->persist($badge);

            $this->addReference(self::BADGE_REFERENCE . $i, $badge);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            EpcisFixtures::class,
        ];
    }
}
