<?php

namespace App\DataFixtures;

use App\Entity\Snowflake;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SnowflakeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $snowflake1 = new Snowflake();
        $snowflake1->setName('Betelgeuse')
            ->setLuckyNumber(777)
            ->setDescription('Je suis une étoile en fait, pas vraiment un flocon de neige')
            ->setCreatedAt(new \DateTime('now'))
        ;
        $manager->persist($snowflake1);

        $snowflake2 = new Snowflake();
        $snowflake2->setName('Antares')
            ->setLuckyNumber(1)
            ->setDescription("Je suis une étoile aussi en fait, c'est quoi le délire ?")
            ->setCreatedAt(new \DateTime('now'))
        ;
        $manager->persist($snowflake2);

        $snowflake3 = new Snowflake();
        $snowflake3->setName('Grande Ourse')
            ->setLuckyNumber(683)
            ->setDescription("T'as complètement loupé le principe des entités, ON EST DES ETOILES")
            ->setCreatedAt(new \DateTime('now'))
        ;
        $manager->persist($snowflake3);

        $manager->flush();
    }
}
