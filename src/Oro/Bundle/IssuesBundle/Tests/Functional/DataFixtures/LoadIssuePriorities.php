<?php

namespace Oro\Bundle\IssuesBundle\Tests\Functional\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\IssuesBundle\Entity\IssuePriority;

class LoadIssuePriorities extends AbstractFixture
{
    const PRIORITY1 = 'priority1';
    const PRIORITY2 = 'priority2';
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            self::PRIORITY1 => ucfirst(self::PRIORITY1),
            self::PRIORITY2 => ucfirst(self::PRIORITY2),
        ];

        $i = 1;
        foreach ($data as $name => $label) {
            $type = new IssuePriority($name);
            $type->setLabel($label);
            $type->setOrder($i++);

            $manager->persist($type);
            $this->addReference($name, $type);
        }

        $manager->flush();
    }
}
