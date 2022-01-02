<?php

namespace App\DataFixtures;

use App\Entity\AssignmentRule;
use App\Entity\Domain;
use App\Entity\Keyword;
use App\Entity\KeywordGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ExampleDataFixtures extends Fixture
{
    public function __construct()
    {
    }
    public function load(ObjectManager $manager): void
    {
        $domain = new Domain();
        $domain->setName('example.org');
        $manager->persist($domain);

        $group = new KeywordGroup();
        $group->setDomain($domain);
        $group->setName('Pasta');
        $manager->persist($group);

        $group2 = new KeywordGroup();
        $group2->setDomain($domain);
        $group2->setName('Overused pop culture references');
        $manager->persist($group2);

        $rule = new AssignmentRule();
        $rule->setKeywordGroup($group);
        $rule->setRegexPattern('ravioli');
        $manager->persist($rule);

        $manager->flush();
    }
}
