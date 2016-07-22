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

use Oro\Bundle\IssuesBundle\Entity\IssueResolution;

class LoadIssueResolutions implements FixtureInterface
{

    /** @var array $data */
    protected $data = array(
        'fixed' => 'Fixed',
        'wont_fix' => 'Won\'t Fix',
        'duplicate' => 'Duplicate',
        'incomplete' => 'Incomplete',
        'cannot_reproduce' => 'Cannot reproduce',
        'done' => 'Done',
        'wont_do' => 'Won\'t do',
        'rejected' => 'Rejected',
    );

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->data as $name => $label) {
            $resolution = new IssueResolution($name);
            $resolution->setLabel($label);
            $manager->persist($resolution);
        }

        $manager->flush();
    }
}
