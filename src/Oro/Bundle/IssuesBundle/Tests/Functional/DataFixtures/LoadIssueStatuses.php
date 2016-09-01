<?php


namespace Oro\Bundle\IssuesBundle\Tests\Functional\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\IssuesBundle\Entity\IssueStatus;

class LoadIssueStatuses extends AbstractFixture
{
    const STATUS1 = 'status1';
    const STATUS2 = 'status2';
    const STATUS3 = 'status3';
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            self::STATUS1 => ucfirst(self::STATUS1),
            self::STATUS2 => ucfirst(self::STATUS2),
            self::STATUS3 => ucfirst(self::STATUS3),
        ];

        $i = 1;
        foreach ($data as $name => $label) {
            $type = new IssueStatus($name);
            $type->setLabel($label);
            $type->setOrder($i++);

            $manager->persist($type);
            $this->addReference($name, $type);
        }

        $manager->flush();
    }
}
