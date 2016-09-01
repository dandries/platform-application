<?php

namespace Oro\Bundle\IssuesBundle\Tests\Functional\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\IssuesBundle\Entity\IssueType;

class LoadIssueTypes extends AbstractFixture
{
    const TYPE1 = 'type1';
    const TYPE2 = 'type2';
    const TYPE3 = 'type3';
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            self::TYPE1 => ucfirst(self::TYPE1),
            self::TYPE2 => ucfirst(self::TYPE2),
            self::TYPE3 => ucfirst(self::TYPE3),
        ];

        foreach ($data as $name => $label) {
            $type = new IssueType($name);
            $type->setLabel($label);

            $manager->persist($type);
            $this->addReference($name, $type);
        }

        $manager->flush();
    }
}
