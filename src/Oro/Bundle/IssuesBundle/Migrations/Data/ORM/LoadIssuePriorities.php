<?php
/**
 * Created by PhpStorm.
 * User: dandries
 * Date: 07.04.2016
 * Time: 17:32
 */

namespace Oro\Bundle\IssuesBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\IssuesBundle\Entity\IssuePriority;

class LoadIssuePriorities implements FixtureInterface
{

    /** @var array $data */
    protected $data = array(
        'minor' => array('label' => 'Minor', 'order' => 1),
        'trivial' => array('label' => 'Trivial', 'order' => 2),
        'major' => array('label' => 'Major', 'order' => 3),
        'critical' => array('label' => 'Critical', 'order' => 4),
        'blocker' => array('label' => 'Blocker', 'order' => 5),
    );

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $name => $details) {
            $priority = new IssuePriority($name);
            $priority->setLabel($details['label']);
            $priority->setOrder($details['order']);
            $manager->persist($priority);
        }

        $manager->flush();
    }
}
