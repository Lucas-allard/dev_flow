<?php

namespace App\DataFixtures;

use App\Entity\Payment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PaymentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($p = 10; $p < 40; $p++) {
            $payment = new Payment();
            $payment->setUser($this->getReference('user_' . $p));
            $payment->setDate($faker->dateTimeBetween('-2 months', '+1 months'));
            $payment->setAmount($faker->numberBetween(1, 1000));
            $payment->setMethod($faker->randomElement(['CB', 'Paypal', 'Virement']));
            $payment->setProject($this->getReference('project_' . rand(0, 9)));
            $payment->setMentorship($this->getReference('mentorship_' . $p));
            $manager->persist($payment);

            // create reference for later use
            $this->addReference('payment_' . $p, $payment);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return array(
            UserFixtures::class,
            ProjectFixtures::class,
            MentorshipFixtures::class,
        );
    }
}
