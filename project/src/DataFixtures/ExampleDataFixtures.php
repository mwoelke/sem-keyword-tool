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
        $group->setName('Ravioli');
        $manager->persist($group);

        $rule = new AssignmentRule();
        $rule->setKeywordGroup($group);
        $rule->setRegexPattern('ravioli');
        $manager->persist($rule);

        $manager->flush();
    }
}
