<?php

namespace App\DataFixtures;

use App\Entity\Demand;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function Sodium\add;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {


        $faker = Factory::create('fr_FR');

        $user = new User();
        $hash = $this->encoder->encodePassword($user, 'password');
        $user->setRoles(['ROLE_USER', 'ROLE_MANAGER', 'ROLE_SUPER_ADMIN'])
            ->setEmail('c.caudron59@gmail.com')
            ->setFirstName('Cedric')
            ->setLastName('Caudron')
            ->setIsVerified(true)
            ->setHouseNumber('11')
            ->setNbPerson(2)
            ->setPhone('06-37-95-36-35')
            ->setImageFileName('profil-default.jpg')
            ->setPassword($hash);

        $manager->persist($user);

        for ($d = 0; $d < 10; $d++) {
            $dateDemand = $faker->dateTimeBetween('2019-03-20T00:00:00.012345Z', 'now');

            $dateRecovery = clone $dateDemand;
            $dateRecovery = $dateRecovery->add(new \DateInterval('PT50M'));

            $demand = new Demand();
            $demand->setUser($user)
                ->setAcceptation(true)
                ->setDate($dateDemand)
                ->setDateMaskRecovery($dateRecovery);;

            $manager->persist($demand);
        }

        $demand = new Demand();
        $demand->setUser($user)
            ->setAcceptation(false)
            ->setDate(new \DateTime());
        $manager->persist($demand);


        $user = new User();
        $hash = $this->encoder->encodePassword($user, 'password');
        $user->setRoles(['ROLE_USER'])
            ->setEmail('barbarhourv@gmail.com')
            ->setFirstName('Cedric')
            ->setLastName('Caudron')
            ->setIsVerified(true)
            ->setHouseNumber('11')
            ->setNbPerson(2)
            ->setPhone('06-37-95-36-35')
            ->setImageFileName('profil-default.jpg')
            ->setPassword($hash);

        $manager->persist($user);

        for ($d = 0; $d < 10; $d++) {
            $dateDemand = $faker->dateTimeBetween('2019-03-20T00:00:00.012345Z', 'now');


            $dateRecovery = clone $dateDemand;
            $dateRecovery = $dateRecovery->add(new \DateInterval('PT40M'));

            $demand = new Demand();
            $demand->setUser($user)
                ->setAcceptation(true)
                ->setDate($dateDemand)
                ->setDateMaskRecovery($dateRecovery);;

            $manager->persist($demand);
        }

        $demand = new Demand();
        $demand->setUser($user)
            ->setAcceptation(false)
            ->setDate(new \DateTime());
        $manager->persist($demand);


        for ($u = 0; $u < 100; $u++) {
            $user = new User();

            $hash = $this->encoder->encodePassword($user, "password");

            $firstName = $faker->firstName;
            $lastName = $faker->lastName;

            $mail = str_to_noaccent(mb_strtolower($firstName . "." . $lastName));
            $mail = $mail . "@fake.com";

            $user->setFirstName($firstName)
                ->setLastName($lastName)
                ->setPassword($hash)
                ->setRoles(['ROLE_USER'])
                ->setIsVerified(true)
                ->setHouseNumber($faker->numberBetween(1, 450))
                ->setNbPerson($faker->numberBetween(1, 10))
                ->setPhone($faker->phoneNumber)
                ->setImageFileName('profil-default.jpg')
                ->setEmail($mail);


            $manager->persist($user);

            for ($d = 0; $d < mt_rand(0, 30); $d++) {
                $dateDemand = $faker->dateTimeBetween('2019-03-20T00:00:00.012345Z', 'now');

                $dateRecovery = clone $dateDemand;
                $dateRecovery = $dateRecovery->add(new \DateInterval('PT30M'));

                $demand = new Demand();
                $demand->setUser($user)
                    ->setAcceptation(true)
                    ->setDate($dateDemand)
                    ->setDateMaskRecovery($dateRecovery);

                $manager->persist($demand);
            }

            $demand = new Demand();
            $demand->setUser($user)
                ->setAcceptation(false)
                ->setDate(new \DateTime());
            $manager->persist($demand);
        }

        $manager->flush();
    }
}

function str_to_noaccent($str)
{
    $url = $str;
    $url = preg_replace('#Ç#', 'C', $url);
    $url = preg_replace('#ç#', 'c', $url);
    $url = preg_replace('#[èéêë]#', 'e', $url);
    $url = preg_replace('#[ÈÉÊË]#', 'E', $url);
    $url = preg_replace('#[àáâãäå]#', 'a', $url);
    $url = preg_replace('#[@ÀÁÂÃÄÅ]#', 'A', $url);
    $url = preg_replace('#[ìíîï]#', 'i', $url);
    $url = preg_replace('#[ÌÍÎÏ]#', 'I', $url);
    $url = preg_replace('#[ðòóôõö]#', 'o', $url);
    $url = preg_replace('#[ÒÓÔÕÖ]#', 'O', $url);
    $url = preg_replace('#[ùúûü]#', 'u', $url);
    $url = preg_replace('#[ÙÚÛÜ]#', 'U', $url);
    $url = preg_replace('#[ýÿ]#', 'y', $url);
    $url = preg_replace('#Ý#', 'Y', $url);
    $url = preg_replace('# #', '', $url);

    return ($url);
}
