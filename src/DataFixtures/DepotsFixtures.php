<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\EPCI;
use App\Entity\Depot;
use App\Repository\EPCIRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DepotsFixtures extends Fixture implements DependentFixtureInterface
{

    public const DAYS_RANGE = 14;

    private $manager;
    private $epciRepository;

    public function __construct(EPCIRepository $epciRepository)
    {
        $this->epciRepository = $epciRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $faker = Factory::create();

        // On part sur une moyenne de max 4 dépots par jours et par badges
        $quantity = BadgesFixtures::BADGE_QUANTITY  * rand(0, 4 * $this::DAYS_RANGE);

        for ($i = 0; $i < count(EpcisFixtures::EPCIS); $i++) {
            for ($j = 0; $j < $quantity; $j++) {
                $depot = new Depot();
                $depot->setAccessControlUid($faker->regexify('[A-Z0-9]{13}'));
                $depot->setBadge($this->getReference(BadgesFixtures::BADGE_REFERENCE . rand(0, BadgesFixtures::BADGE_QUANTITY - 1)));
                $depot->setEpci($this->getReference(EpcisFixtures::EPCI_REFERENCE . $i));
                $dateTime = $faker->dateTimeBetween('-' . self::DAYS_RANGE . ' days', 'now');
                $depot->setTimestamp($dateTime->getTimestamp());
                $manager->persist($depot);
            }
        }

        // Ajout de donnée en lien avec S.Monitor
        $this->addDatas();

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            BadgesFixtures::class,
            EpcisFixtures::class,
        ];
    }

    /**
     * Ajout de données fixe pour test liés avec S.Monitor
     */
    private function addDatas()
    {
        $faker = Factory::create();
        $smd3 = $this->getEpciByName('SMD3');
        $quantity = 10 * rand(2, 4 * $this::DAYS_RANGE);

        for ($i = 0; $i < $quantity; $i++) {
            $depot = new Depot();
            $depot->setAccessControlUid("SIG_CATEST" . rand(1, 3));
            $depot->setBadge($this->getReference(BadgesFixtures::BADGE_REFERENCE . rand(0, BadgesFixtures::BADGE_QUANTITY - 1)));
            $depot->setEpci($smd3);
            $dateTime = $faker->dateTimeBetween('-' . self::DAYS_RANGE . ' days', 'now');
            $depot->setTimestamp($dateTime->getTimestamp());
            $this->manager->persist($depot);
        }
    }

    private function getEpciByName(string $name): ?EPCI
    {
        $epci = $this->epciRepository->findOneByName('SMD3');
        if ($epci) {
            return $epci;
        }

        throw new \Exception("EPCI with name $name not found.");
    }
}
