<?php

namespace App\DataFixtures;

use App\Entity\Observation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class MeasurementFixtures extends Fixture
{
    public const USER_1_EMAIL = 'test@test.com';
    public const USER_1_UUID = 'e9eae405-e6e3-46a6-a232-b3b3c57539dc';

    public const OBSERVATION_1_UUID = 'ca45b3e2-8b66-42e2-9953-0eb0191108c1';
    public const OBSERVATION_1_NAME = 'Observation 1';

    public const MEASUREMENT_1_UUID = 'e2dbc62e-3af1-4bba-8fb1-36cf5df18b1e';

    public function load(ObjectManager $manager): void
    {
        $user1 = new User(self::USER_1_EMAIL, Uuid::fromString(self::USER_1_UUID));
        $user1->setPassword('$2y$13$6Pn.ouTaH8mOCImFT5aAgeZk646bFCfv1h1KSg9sDZZe9hf2JgOhq'); // "test"
        $manager->persist($user1);

        $manager->persist(new Observation(
            $user1,
            Uuid::fromString(self::OBSERVATION_1_UUID),
            self::OBSERVATION_1_NAME
        ));

        $manager->flush();
    }
}