<?php

namespace App\DataFixtures;

use App\Entity\Departement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < 4; $i++) {
            $departement = new Departement();
            $departement->setNomDepartement('departement '.$i);
            $departement->setEmailDepartement('departement '.$i.'@eff.fr');
            $manager->persist($departement);
        }

        $manager->flush();
    }
}
