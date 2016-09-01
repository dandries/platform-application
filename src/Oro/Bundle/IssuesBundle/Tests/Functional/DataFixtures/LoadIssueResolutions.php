<?php

namespace Oro\Bundle\IssuesBundle\Tests\Functional\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\IssuesBundle\Entity\IssueResolution;

class LoadIssueResolutions extends AbstractFixture
{
    const RESOLUTION1 = 'resolution1';
    const RESOLUTION2 = 'resolution2';
    const RESOLUTION3 = 'resolution3';
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            self::RESOLUTION1 => ucfirst(self::RESOLUTION1),
            self::RESOLUTION2 => ucfirst(self::RESOLUTION2),
            self::RESOLUTION3 => ucfirst(self::RESOLUTION3),
        ];

        foreach ($data as $name => $label) {
            $type = new IssueResolution($name);
            $type->setLabel($label);

            $manager->persist($type);
            $this->addReference($name, $type);
        }

        $manager->flush();
    }
}
