<?php

namespace App\EventListener;

use App\Entity\Keyword;
use App\Repository\AssignmentRuleRepository;
use Doctrine\ORM\EntityManagerInterface;

class KeywordCreatedListener
{
    public function __construct(
        private AssignmentRuleRepository $assignmentRuleRepository,
        private EntityManagerInterface $entityManagerInterface
    ) {
    }

    /**
     * Check if any assignment rule matches when new keyword is created and put in the respective keyword group
     *
     * @param Keyword $keyword
     * @return void
     */
    public function postPersist(Keyword $keyword): void
    {
        //get all assignment rules for keywords domain
        $rules = $this->assignmentRuleRepository->findByDomain($keyword->getDomain());

        $name = $keyword->getName();
        $changed = false;
        //loop over all rules
        foreach($rules as $rule) {
            $pattern = $rule->getRegexPattern();
            //check if regex pattern matches
            if(preg_match("/$pattern/i", $name) === 1) {
                //add keyword to keyword group
                $keyword->addKeywordGroup($rule->getKeywordGroup());
                $changed = true;
            } 
        }

        //update keyword if new group was added
        if($changed) {
            $this->entityManagerInterface->persist($keyword);
            $this->entityManagerInterface->flush();
        }
    }
}
