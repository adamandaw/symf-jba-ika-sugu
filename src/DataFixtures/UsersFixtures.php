<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $encoder){}

    public function load(ObjectManager $manager): void
    {
        // $faker = Factory::create('fr_FR');
        $roles=["ROLE_ADMIN"];
        $plainPassword = 'passer';
        $pos= rand(0,1);
        for ($i=1; $i < 2; $i++) { 
            $user = new User();
            $user->setRoles([$roles[0]]);
            $user->setEmail("mohamedndaw697@gmail.com");
            $encoded = $this->encoder->hashPassword($user,$plainPassword);
            $user->setPassword($encoded);
            
            $manager->persist($user);
            $this->addReference("User".$i, $user);
        }

        $manager->flush();
    }
    // public function getDependencies(){
    //     return array(
    //         TuteurFixtures::class,
    //         Assistantixtures::class
    //     ); 
    // }

}
