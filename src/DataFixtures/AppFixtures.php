<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Meuble;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       $faker = Factory::create();

        // CATEGORY
        $categorie = new Categorie();
        $categorie->setLibelle("Salon");

        $manager->persist($categorie);

        // CREATE 20 MEUBLES
        for ($i = 0; $i < 20; $i++) {

            $meuble = new Meuble();

            $meuble->setNom($faker->word());

            $meuble->setPrix($faker->numberBetween(200, 5000));

            $meuble->setDescription($faker->sentence(10));

            $meuble->setStock($faker->numberBetween(1, 50));

            $meuble->setImage(
                "https://picsum.photos/400/300?random=".$i
            );

            $meuble->setCategorie($categorie);

            $manager->persist($meuble);
        }

        $manager->flush();
    }
}
